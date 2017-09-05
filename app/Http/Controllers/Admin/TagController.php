<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use App\Tag;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Http\Requests\Admin\UpdateTagRequest;
use App\Http\Requests\Admin\AjaxStoreTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view( 'admin/tag/index', compact('tags') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'admin/tag/create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->save();

            DB::commit();
            return redirect()->route('admin_tag')->with('message', '添加成功');
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
        $tag = Tag::findOrFail($id);
        return view( 'admin/tag/show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view( 'admin/tag/edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, $id)
    {
        DB::beginTransaction();
        try
        {
            // 更新 role
            $tag = Tag::findOrFail($id);
            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->save();

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
            $tag = tag::findOrFail($id);
            $tag->posts()->detach();
            $tag->delete();
            DB::commit();
            return redirect()->route('admin_tag')->with('message', '删除成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('删除失败！');
        }
    }

    /**
     * ajax 添加新标签
     */
    public function ajaxStore(AjaxStoreTagRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $tag = new Tag;
            $tag->name = $request->new_tag_name;
            $tag->slug = $request->new_tag_slug;
            $tag->save();
            DB::commit();
            return response()->json( [ 'status' => 200, 'message' => '添加成功', 'tag_id' => $tag->id, 'tag_name' => $tag->name ] );
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json( [ 'status' => 500, 'message' => '添加失败' ] );
        }
    }
}
