<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // 验证 url 的 CSRF token
        'checkUrlCsrfToken' => \App\Http\Middleware\CheckUrlCsrfToken::class,

        // 验证用户的 active 和 admin 字段
        'adminAuth' => \App\Http\Middleware\Admin\Auth::class,

        // 验证 admin 页面访问权限
        'checkAdminPermission' => \App\Http\Middleware\Admin\CheckAdminPermission::class,

        // 限制一分钟内访问次数
        'attempt' => \App\Http\Middleware\Attempt::class,

    ];
}
