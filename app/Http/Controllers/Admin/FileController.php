<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use Storage;
use App\Http\Requests\Admin\CreateDirectoryRequest;
use App\Http\Requests\Admin\UploadFileRequest;
use File;
use URL;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $folder = $request->folder ? $request->folder : null;

        if ( ! Storage::disk('local')->has($folder) && $folder !== null )
            return redirect()->route('admin_filesystem')->withErrors('不存在该目录，返回根目录');

        // 当前目录下所有的目录
        $directories = Storage::disk('local')->directories($folder);

        // 当前目录下所有的文件
        $tmp = Storage::disk('local')->files($folder);
        // dd($tmp);
        $files = array();
        foreach ( $tmp as $k=>$v )
        {
            $size = Storage::disk('local')->size($v);
            $files[$k]['name'] = $tmp[$k];
            $files[$k]['type'] = Storage::disk('local')->mimeType($v);
            $files[$k]['size'] = format_filesize($size);
            $files[$k]['modified'] = date('y-m-d H:i', Storage::disk('local')->lastModified($v));
        }
        return view( 'admin/filesystem/index', compact('folder', 'directories', 'files') );
    }

    /**
     * 创建文件夹
     */
    public function createDirectory(CreateDirectoryRequest $request)
    {
        if ( Storage::disk('local')->has($request->current_folder .'/'. $request->new_directory_name) )
            return redirect()->route('admin_filesystem')->withErrors('目录已存在');

        // 新建目录
        Storage::disk('local')->makeDirectory( $request->current_folder . '/' . $request->new_directory_name );
        return back()->with('message', '创建目录 "' . $request->new_directory_name . '" 成功');
    }

    /**
     * 上传文件
     * 表单中 rename 用与判断是否重命名上传文件成随机名称
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $request->file('upload_file');
        $originalName = addslashes($file->getClientOriginalName());

        // 服务器端最大上传文件数量由 php.ini: max_file_uploads 控制
        if ( $file->getClientSize()/1024 > config('admin.upload_file_size') ) return '文件过大';

        // 如果是来自 admin_filesystem，来源页面的目录作为上传文件的目录；否则当前日期为目录
        if ( str_is( route('admin_filesystem').'*', URL::previous() ) )
        {
            $folder = explode('?folder=', URL::previous());
            $current_folder = isset($folder[1]) ? $folder[1] : '';
            if ( Storage::disk('local')->has( $current_folder.'/'.$originalName ) ) return '存在同名文件';
        }
        else
        {
            $current_folder = 'img/'. date('Y/m/d');
        }

        // 参数中 rename 为真时执行 随机命名
        if ( $request->rename )
        {
            $newName = str_random(6) .'.'. $file->getClientOriginalExtension();
            Storage::disk('uploads')->put( $current_folder.'/'.$newName , File::get($file) );
            return json_encode($newName);
        }
        else
        {
            Storage::disk('local')->put( $current_folder.'/'.$originalName , File::get($file) );
            return json_encode($originalName);
        }
    }

    /**
     * 删除目录
     */
    public function destroyDirectory(Request $request)
    {
        if ( ! Storage::disk('local')->has( $request->path ) ) return back()->withErrors('目录不存在');
        if ( ! Storage::disk('local')->deleteDirectory($request->path) ) return back()->withErrors('删除目录失败');
        return back()->with('message', '删除目录 "' . $request->path . '" 成功');
    }

    /**
     * 删除文件
     */
    public function destoryFile(Request $request)
    {
        if ( ! Storage::disk('local')->has( $request->path ) ) return back()->withErrors('文件不存在');
        if ( ! Storage::disk('local')->delete($request->path) ) return back()->withErrors('删除文件失败');
        return back()->with('message', '删除文件 "' . $request->path . '" 成功');
    }

    /**
     * 移动目录
     */
    public function moveDirectory(Request $request)
    {
        if ( ! Storage::disk('local')->has( $request->oldDirPath ) ) return back()->withErrors('需要移动的目录不存在');
        if ( Storage::disk('local')->has( $request->newDirPath ) ) return back()->withErrors('新目录已经存在');
        Storage::disk('local')->move( $request->oldDirPath, $request->newDirPath );
        return back()->with('message', '操作成功，新路径为：'.$request->newDirPath);
    }

    /**
     * 移动文件
     */
    public function moveFile(Request $request)
    {
        if ( ! Storage::disk('local')->has( $request->oldFilePath ) ) return back()->withErrors('需要移动的文件不存在');
        if ( Storage::disk('local')->has( $request->newFilePath ) ) return back()->withErrors('新文件已经存在');
        Storage::disk('local')->move( $request->oldFilePath, $request->newFilePath );
        return back()->with('message', '操作成功，新路径为：'.$request->newFilePath);
    }

}
