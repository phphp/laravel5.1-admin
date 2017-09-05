<?php
namespace App\Helpers;

class Avatar
{
    private $avatarType = ['l'=>100, 'm'=>70, 's'=>50];

    /**
     * 上传头像
     * /public/uploads/avatar 需要有写权限
     * @param  str $file   上传临时文件路径 \Input::file('avatar')
     * @param  str $size   jcrop 提供的裁切尺寸，json 格式
     * @param  int $userId 用户 id，用于生成头像文件名
     * @return bool        是否生成头像
     */
    public function upload($file, $size, $userId)
    {
        // 没有有头像文件上传
        if ( ! $file )
            return false;
        else
        {
            $check = $this->check($file); // 检验文件
            // 裁切并生成多种头像
            $size = json_decode($size);
            foreach ( $this->avatarType as $k=>$v )
            {
                $img = \Image::make($file)->crop(floor($size->w), floor($size->h), floor($size->x), floor($size->y))->resize($v, $v);
                $rs = $img->save('uploads/avatar/'.$userId.'-'.$k.'.jpg', 100);
            }
            return true;
        }
    }

    /**
     * 删除头像
     * @param  int $id 用户 ID
     * @return mix     无返回／删除失败返回表单
     */
    public function delete($id)
    {
        foreach ( $this->avatarType as $k=>$v )
        {
            $path = public_path()."/uploads/avatar/$id-$k.jpg";
            if ( file_exists($path) )
            {
                if ( ! unlink($path) ) throw new Exception('删除头像失败');
            }
        }
    }

    /**
     * 检查是否成功上传文件
     */
    private function check($file)
    {
        if ( ! $file->isValid() )
        {
            \Log::notice('Upload file fail, '.$request->ip()); // 记录日志
            abort( 600, '上传文件失败' );
        }
    }
}