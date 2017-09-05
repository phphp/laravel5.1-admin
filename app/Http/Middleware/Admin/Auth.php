<?php

namespace App\Http\Middleware\Admin;

use Closure;

class Auth
{
    /**
     * 验证管理员登录
     * 1. 验证用户是否登录
     * 2. 验证 users 表的 active 和 admin 字段
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user())
        {
            if ( $request->user()->active != 1 || $request->user()->admin != 1 )
            {
                return redirect()->guest('admin/login')->withErrors('禁止访问');
            }
        }
        else
        {
            return redirect()->guest('admin/login')->withErrors('请登录');
        }
        return $next($request);
    }
}
