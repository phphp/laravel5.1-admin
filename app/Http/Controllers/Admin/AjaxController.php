<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use DB;

class AjaxController extends Controller
{
    /**
     * Ajax 更新 roles sort 字段
     * @return [str]           [description]
     *
     * 排序字段需要唯一，用于验证更新成功 or 回滚
     * 排序字段默认为 NULL
     */
    public function sortRole(Request $request)
    {
        $newSortArray = $request->new_sort;

        // 检查是否存在 id，或者缺少 id
        $rs = DB::table('roles')->whereIn('id', $newSortArray)->get();
        $all = DB::table('roles')->count();
        if ( $all != count($rs) ) return 'error';

        // 拼接 WHEN THEN 语句
        $sql = '';
        foreach ( $newSortArray as $k=>$v )
        {
            $k++;
            $sql .= "WHEN $v THEN $k "; 
        }

        DB::beginTransaction(); // 事务开始
        try
        {
            // 清空字段
            DB::update("UPDATE roles SET sort = NULL");
            // 更新操作
            DB::update("UPDATE roles
                            SET sort = CASE id
                                $sql
                            END");
            DB::commit(); // 事务提交
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return 'error';
        }
    }


    public function sortPermission(Request $request)
    {
        $newSortArray = $request->new_sort;

        // 检查是否存在 id，或者缺少 id
        $rs = DB::table('permissions')->whereIn('id', $newSortArray)->get();
        $all = DB::table('permissions')->count();
        if ( $all != count($rs) ) return 'error';

        // 拼接 WHEN THEN 语句
        $sql = '';
        foreach ( $newSortArray as $k=>$v )
        {
            $k++;
            $sql .= "WHEN $v THEN $k "; 
        }

        DB::beginTransaction(); // 事务开始
        try
        {
            // 清空字段
            DB::update("UPDATE permissions SET sort = NULL");
            // 更新操作
            DB::update("UPDATE permissions
                            SET sort = CASE id
                                $sql
                            END");
            DB::commit(); // 事务提交
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return 'error';
        }
    }


    public function sortCategory(Request $request)
    {
        $newSortArray = $request->new_sort;

        // 检查是否存在 id，或者缺少 id
        $rs = DB::table('categories')->whereIn('id', $newSortArray)->get();
        $all = DB::table('categories')->count();
        if ( $all != count($rs) ) return 'error';

        // 拼接 WHEN THEN 语句
        $sql = '';
        foreach ( $newSortArray as $k=>$v )
        {
            $k++;
            $sql .= "WHEN $v THEN $k "; 
        }

        DB::beginTransaction(); // 事务开始
        try
        {
            // 清空字段
            DB::update("UPDATE categories SET sort = NULL");
            // 更新操作
            DB::update("UPDATE categories
                            SET sort = CASE id
                                $sql
                            END");
            DB::commit(); // 事务提交
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return 'error';
        }
    }


}
