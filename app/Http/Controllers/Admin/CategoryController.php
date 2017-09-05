<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use App\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('sort')->get();
        return view( 'admin/category/index', compact('categories') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'admin/category/create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $category = new Category;
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->sort = $category->count()+1;
            $category->save();

            DB::commit();
            return redirect()->route('admin_category')->with('message', '添加成功');
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
        $category = Category::findOrFail($id);
        return view( 'admin/category/show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view( 'admin/category/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        DB::beginTransaction();
        try
        {
            // 更新 role
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();

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
            $category = Category::findOrFail($id);
            $category->posts()->detach();
            $category->delete();
            DB::commit();
            return redirect()->route('admin_category')->with('message', '删除成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('删除失败！');
        }
    }
}
