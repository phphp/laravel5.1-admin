<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use App\User;
use App\Oauth;
use App\Role;
use App\RoleRelationship;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Requests\Admin\UpdateOauthUserRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Helpers\Avatar;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $order = $request->order ? $request->order : 'desc';
        $users = User::orderBy($orderBy, $order)->simplePaginate(config('admin.user_page_size'));
        return view( 'admin/user/index', compact('users', 'order') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('sort')->get();
        return view( 'admin/user/create', compact('roles') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = User::create($request->input()); // 新建用户

            if ( $request->roles )
            {
                foreach ( $request->roles as $v ) $data[] = ['user_id'=>$user->id, 'role_id'=>$v];
                RoleRelationship::insert($data); // 关联用户和角色
            }

            // 如果自定义了头像，则 update avatar 字段
            $avatar = new Avatar();
            if ( $avatar->upload(\Input::file('avatar'), $request->avatar_size, $user->id) )
            {
                // 生成新头像后更新
                $user = User::find($user->id);
                $user->avatar = $user->id;
                $user->save();
            }

            DB::commit();
            return redirect()->route('user_index')->with('message', '添加成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $oauthUsers = Oauth::where('user_id', $id)->get();
        $roles = $user->roles;
        return view( 'admin/user/show', compact('user', 'roles', 'oauthUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->roles;
        $allRoles = Role::orderBy('sort')->get();
        return view( 'admin/user/edit', compact('user', 'roles', 'allRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try
        {
            // 修改 user
            $fillData = $request->password ? $request->input() : $request->except('password');
            $user = User::findOrFail($id);
            $user->fill($fillData);
            // 如果有头像上传，正确保存图片后，修改 avatar 字段，没有上传则不处理 avatar 字段
            $avatar = new Avatar();
            if ( $avatar->upload(\Input::file('avatar'), $request->avatar_size, $id) )
                $user->avatar = $id;
            $user->save();

            // 删除旧关联数据
            $user->roles()->detach();
            if ( $request->roles )
            {
                foreach ( $request->roles as $v ) $data[] = ['user_id'=>$user->id, 'role_id'=>$v];
                RoleRelationship::insert($data);
            }
            DB::commit();
            return back()->with('message', '修改成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('修改失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $user = User::findOrFail($id);
            $user->roles()->detach(); // 删除 roles 关联数据
            $user->delete();
            $avatar = new Avatar();
            $avatar->delete($id); // 删除头像文件
            $oauthUser = Oauth::where('user_id', $user->id)->delete(); // 删除 oauth 用户

            DB::commit();
            return redirect()->route('user_index')->with('message', '删除成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('删除失败！');
        }
    }

    /**
     * 修改自身用户数据
     */
    public function profile()
    {
        $user = User::findOrFail(\Auth::user()->id);
        return view( 'admin/user/profile', compact('user'));
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        DB::beginTransaction();
        try
        {
            // 修改 user
            $fillData = $request->password ? $request->input() : $request->except('password');
            $user = User::findOrFail($request->user()->id);
            $user->fill($fillData);
            // 如果有头像上传，正确保存图片后，修改 avatar 字段，没有上传则不处理 avatar 字段
            $avatar = new Avatar();
            if ( $avatar->upload(\Input::file('avatar'), $request->avatar_size, $request->user()->id) )
                $user->avatar = $request->user()->id;
            $user->save();
            DB::commit();
            return back()->with('message', '修改成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('修改失败');
        }
    }

    /**
     * 查询用户
     */
    public function search(Request $request)
    {
        $key = $request->input('q', false);
        if ( ! $key ) return redirect()->route('user_index')->withErrors('请输入需要查询的 id / name');

        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $order = $request->order ? $request->order : 'desc';
        $users = User::where('name', 'LIKE', '%'. $key .'%')
                    ->orwhere('id', 'LIKE', '%'. $key .'%')
                    ->orderBy($orderBy, $order)
                    ->paginate(10);
        $users->appends(['q' => $key]); // 添加参数到分页链接中
        $request->flash();
        return view( 'admin/user/index', compact('users', 'order', 'key') );
    }

    /**
     * 所有 oauth 用户
     */
    public function oauth(Request $request)
    {
        $users = Oauth::orderBy('id')->simplePaginate(config('admin.user_page_size'));
        return view( 'admin/user/oauth', compact('users') );
    }

    /**
     * 编辑 oauth 用户
     */
    public function oauthEdit($id)
    {
        $user = Oauth::findOrFail($id);
        return view( 'admin/user/oauthEdit', compact('user') );
    }

    /**
     * 更新 oauth 用户
     */
    public function oauthUpdate(UpdateOauthUserRequest $request, $id)
    {
        $user = Oauth::findOrFail($id);
        $user->user_id = $request->user_id;
        $user->save();
        return back()->with('message', '修改成功');
    }

    /**
     * 删除 oauth 用户
     */
    public function oauthDestroy($id)
    {
        $user = Oauth::findOrFail($id);
        $user->delete();
        return redirect()->route('oauth_user')->with('message', '删除成功');
    }
}
