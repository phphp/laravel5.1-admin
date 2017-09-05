<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use App\Role;
use App\Permission;
use App\PermissionRelationship;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('sort')->get();
        $permissions = Permission::orderBy('sort')->get();
        return view( 'admin/role/index', compact('roles', 'permissions') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('sort')->get();
        return view( 'admin/role/create', compact('permissions') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        DB::beginTransaction();
        try
        {
            // 添加 role
            $role = new Role;
            $role->name = $request->name;
            $role->sort = $role->count()+1;
            $role->save();

            // 添加关联数据
            if ( $request->permissions )
            {
                foreach ( $request->permissions as $v )
                {
                    $tmp[] = [
                        'role_id' => $role->id,
                        'permission_id' => $v,
                    ];
                }
                PermissionRelationship::insert($tmp);
            }
            DB::commit();
            return redirect()->route('role_index')->with('message', '添加成功');
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
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        return view( 'admin/role/show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $allPermissions = Permission::orderBy('sort')->get();
        return view( 'admin/role/edit', compact('role', 'permissions', 'allPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        DB::beginTransaction();
        try
        {
            // 更新 role
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $role->save();

            // 更新 permissions
            $role->permissions()->detach();
            if ( $request->permissions )
            {
                foreach ( $request->permissions as $v ) $tmp[] = [ 'role_id' => $role->id, 'permission_id' => $v ];
                PermissionRelationship::insert($tmp);
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
            $role = Role::findOrFail($id);
            $role->permissions()->detach(); // 删除 permissions 关联数据
            $role->users()->detach(); // 删除 users 关联数据
            $role->delete();
            DB::commit();
            return redirect()->route('role_index')->with('message', '删除成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('删除失败！');
        }
    }


    /**
     * 更新角色权限缓存
     */
    public function updateCache()
    {
        \Cache::forget('roles');
        return back()->with('message', '缓存更新成功');
    }
}
