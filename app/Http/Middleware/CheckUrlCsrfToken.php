<?php

namespace App\Http\Middleware;

use Closure;

class CheckUrlCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $token)
    {
        if ( $request->token != csrf_token() ) return 'Wrong csrf_token'; // 错误的 token 提示错误退出程序
        return $next($request);
    }
}
