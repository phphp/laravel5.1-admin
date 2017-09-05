<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use Illuminate\Support\Facades\DB;
use Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 查询注册
        $users = DB::table('users')->whereRaw('Date(created_at) = CURDATE()')->get();
        $yesterdayUsers = $this->getYesterdayCache('users');

        // 查询文章
        $posts = DB::table('posts')->whereRaw('Date(created_at) = CURDATE()')->get();
        $yesterdayPosts = $this->getYesterdayCache('posts');

        // 查询今日日志数
        $logs = $this->countLog( storage_path('logs/laravel-'.date('Y-m-d').'.log') );

        return view('admin/dashboard/home', compact('users', 'yesterdayUsers', 'posts', 'yesterdayPosts', 'logs'));
    }

    /**
     * 查询并缓存昨日数据，如昨日注册、文章
     */
    private function getYesterdayCache($tableName)
    {
        $cacheName = 'yesterday_'.$tableName;
        if ( ! Cache::has($cacheName) )
        {
            // 查询并缓存
            $yesterdayData = DB::table($tableName)->whereRaw('Date(created_at) = SUBDATE(CURDATE(),1)')->get();
            $expiresAt = Carbon::today()->addDay(1);
            Cache::store('file')->put($cacheName, $yesterdayData, $expiresAt);
        }
        else
            $yesterdayData = Cache::get($cacheName);
        return $yesterdayData;
    }

    /**
     * 统计日志数
     */
    private function countLog($file)
    {
        $fp = @fopen($file, "r");
        if ( ! $fp ) return 0;
        $i = 0;
        while( ! feof($fp) ) {
            //每次读取1M
            if( $data = fread($fp,1024*1024) ) {
                //计算读取到的行数
                $num = substr_count($data,"[20");
                $i += $num;
            }
        }
        fclose($fp);
        return $i;
    }


}
