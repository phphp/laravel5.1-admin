<?php

namespace App\Listeners;

use App\Events\IncrementLoginAttempts;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Auth\ThrottlesLogins; // 错误尝试限制
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers; // 验证和注册用户 incrementLoginAttempts() 需要

class IncrementLoginAttemptsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IncrementLoginAttempts  $event
     * @return void
     */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins; // incrementLoginAttempts() 所需
    public function handle(IncrementLoginAttempts $event)
    {
        // $event 的 requests 属性由事件类中定义（App\Events\IncrementLoginAttempts）
        $this->incrementLoginAttempts($event->requests); // 增加一次尝试次数，默认达到5次开始限制
    }
}
