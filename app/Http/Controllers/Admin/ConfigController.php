<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use Storage;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $files = Storage::disk('config')->allFiles(); // 读取所有配置文件
        $file = $request->file ? $request->file : $files[0];
        if ( ! file_exists( config_path() .'/'. $file ) ) return redirect()->route('admin_config')->withErrors('文件不存在');
        $contents = Storage::disk('config')->get($file); // 读取一个配置文件内容
        return view( 'admin/config/index', compact('files', 'file', 'contents') );
    }


    public function update(Request $request, $file)
    {
        if ( ! Storage::disk('config')->has($file) ) return redirect()->route('admin_config')->withErrors('文件不存在');
        try
        {
            Storage::disk('config')->put($file, $request->contents);
        }
        catch(\Exception $e)
        {
            return back()->withErrors('没有服务器权限修改这个文件');
        }
        return back()->with('message', '修改成功');
    }



}
