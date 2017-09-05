<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use App\Post;
use App\Category;
use App\Tag;
use App\CategoryRelationship;
use App\TagRelationship;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(config('admin.admin_post_size'));
        return view( 'admin/post/index', compact('posts') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('sort')->get();
        $tags = Tag::get();
        return view( 'admin/post/create', compact('categories', 'tags') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        try
        {
            // 新建 post
            $post = Post::create($request->input());
            // 新建 分类关联
            $data[] = ['post_id'=>$post->id, 'category_id'=>$request->category];
            $categoryRelationship = CategoryRelationship::insert($data);
            // 新建 标签关联
            $this->insertTags($request->tags, $post->id);

            DB::commit();
            return redirect()->route('admin_post')->with('message', '添加成功');
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
        $post = Post::findOrFail($id);
        $category = $post->category;
        $tags = $post->tags;
        return view( 'admin/post/show', compact('post', 'category', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $selectedCategory = $post->categoryId;
        $categories = Category::orderBy('sort')->get();

        $selectedTagIds = $post->tagIds;
        $tags = Tag::get();

        return view( 'admin/post/edit', compact('post', 'selectedCategory', 'categories', 'selectedTagIds', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        DB::beginTransaction();
        try
        {
            // 更新 post
            $post = Post::findOrFail($id);
            $post->fill($request->all());
            $post->save();

            // 更新 category
            $post->category()->detach();
            $categoryRelationship = new CategoryRelationship;
            $categoryRelationship->post_id = $post->id;
            $categoryRelationship->category_id = $request->category;
            $categoryRelationship->save();

            // 更新 tags
            $post->tags()->detach();
            $this->insertTags($request->tags, $post->id);

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
            $post = Post::findOrFail($id);
            $post->category()->detach();
            $post->tags()->detach();
            $post->delete();
            DB::commit();
            return redirect()->route('admin_post')->with('message', '删除成功');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->withErrors('删除失败！');
        }
    }

    /**
     * 关联文章和标签
     * @param  arr $requestTags 标签 ID 数组
     * @param  int $postId      文章 ID
     * @return bool             true
     */
    private function insertTags($requestTags, $postId)
    {
        if ( ! $requestTags ) return true;
        foreach ( $requestTags as $v )
        {
            $tmp[] = [
                'post_id' => $postId,
                'tag_id' => $v,
            ];
        }
        TagRelationship::insert($tmp);
        return true;
    }
}
