<?php

if ( ! function_exists('is_route') )
{
    /**
     * 判断当前 URL 是否和路由别名相同
     * 例：{{ is_route('admin_homepage') ? 'active' : '' }}
     * @return boolean
     * 
     * 修改时间：2016-12-07 16:01:13
     */
    function is_route()
    {
        $args = func_get_args();

        foreach($args as &$arg)
        {
            if(is_array($arg))
            {
                $route = array_shift($arg);
                $arg = ltrim(route($route, $arg, false), '/');
                continue;
            }
            $arg = ltrim(route($arg, [], false), '/');
        }

        return call_user_func_array(array(app('request'), 'is'), $args);
    }
}


if ( ! function_exists('format_filesize') )
{
    /**
     * 格式化文件大小
     * @param  int  $bytes    文件大小（比特）
     * @param  int $decimals  小数位
     * @return str            格式化后的字符串
     */
    function format_filesize($bytes, $decimals = 2)
    {
        $size = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
    }
}


if ( ! function_exists('is_dir_empty') )
{
    /**
     * 判断目录是否是空目录
     * @param  str  $dir 目录路径
     * @return boolean
     */
    function is_dir_empty($dir)
    {
        if (!is_readable($dir)) return NULL; 
        $handle = opendir($dir);
        while ( false !== ($entry = readdir($handle)) )
        {
            if ($entry != "." && $entry != "..") return FALSE;
        }
        return TRUE;
    }
}


if ( ! function_exists('markdown') )
{
    /**
     * 把文本通过 markdown 语法输出为 html 字符串
     * 需要用到 Parsedown 组件
     * @param  str $text 原文本
     * @return str HTML 字符串
     */
    function markdown($text='')
    {
        $parsedown = new \Parsedown();
        return $parsedown->text($text);
    }
}




if ( ! function_exists('format_time') )
{
    function format_time($dt)
    {
        $format = [
            'between_one_minute' => '刚刚',
            'before_minute'      => '分钟前',
            'after_minute'       => '分钟后',
            'today'              => 'H:i',
            'yesterday'          => '昨天 H:i',
            'tomorrow'           => '明天 H:i',
            'default'            => 'n月d日 H:i',
            'diff_year'          => 'Y年n月d日 H:i',
            'error'              => '时间显示错误'
        ];

        //创建对象
        if( is_int($dt) ) {
            $dt = Carbon\Carbon::createFromTimestamp($dt);
        } else if( ! $dt instanceof \Carbon\Carbon) {
            //错误时间
            if( $dt == '0000-00-00 00:00:00' || $dt === '0' ) return $format['error'];
            $dt = new Carbon\Carbon($dt);
        }

        $now = \Carbon\Carbon::now();
        //今天
        if( $dt->isToday() ) {
            $diff_minute = floor(abs($now->timestamp - $dt->timestamp) / 60);
            $diff_second = $now->timestamp - $dt->timestamp;
            //一小时内
            if($diff_minute < 60) {
                //一分钟内
                if($diff_second < 60 && $diff_second >= 0) return $format['between_one_minute'];
                return $diff_second < 0 ? $diff_minute.$format['after_minute'] : $diff_minute.$format['before_minute'] ;
            }
            return $dt->format($format['today']);
        }

        //昨天
        if( $dt->isYesterday() ) return $dt->format($format['yesterday']);
        //明天
        if( $dt->isTomorrow() ) return $dt->format($format['tomorrow']);
        //非今年，其他时间
        if( $dt->format('Y') !== $now->format('Y') ) return $dt->format($format['diff_year']);
        //今年，其他时间
        return $dt->format($format['default']);
    }
}