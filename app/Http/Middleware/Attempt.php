<?php

namespace App\Http\Middleware;

use Closure;

// use
use Session;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Lang;

class Attempt
{
    private $maxLoginAttempts; // 最大尝试次数
    private $lockoutTime = 90; // 禁止访问时长

    use ThrottlesLogins;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $tries 每分钟最多允许访问的次数
     * @return mixed
     */
    public function handle($request, Closure $next, $tries=5)
    {
        $this->maxLoginAttempts = $tries;
        $this->incrementLoginAttempts($request); // 访问次数自增
        // 检查尝试次数是否过多
        if ($this->hasTooManyLoginAttempts($request))
        {
            $this->logAttempts($request);
            return $this->sendLockoutResponse($request);
        }
        return $next($request);
    }

    /**
     * 重写 trait ThrottlesLogins 的 getThrottleKey 方法
     */
    protected function getThrottleKey(Request $request)
    {
        return mb_strtolower($request->path()).'|'.$request->ip();
    }

    /**
     * 重写 trait ThrottlesLogins 的 sendLockoutResponse 方法
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $this->getThrottleKey($request)
            );
        return redirect()->back()->withErrors($this->getLockoutErrorMessage($seconds));
    }

    /**
     * 重写 trait ThrottlesLogins 的 getLockoutErrorMessage 方法
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return '访问过于频繁，请于'.$seconds.'秒后再试';
    }

    /**
     * 记录日志
     */
    private function logAttempts($request)
    {
        $tmp = '';
        if ( $request->has('name') ) $tmp .= ' | ' . $request->name;
        if ( $request->has('email') ) $tmp .= ' | ' . $request->email;
        if ( $request->user() ) $tmp .= ' | 已登录 ID:' . $request->user()->id;
        \Log::notice('Too Many Attempts: ' . $request->ip() . ' @ ' . $request->path() . $tmp);
    }

}
