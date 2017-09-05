<?php
/**
 * Laravel5.1 事件的使用
 * https://laravel-china.org/docs/5.1/events
 * 
 * 1. app/Providers/EventServiceProvider 注册事件侦听器（一般在 $listen 数组中定义，也可以在 boot() 中定义）
 * 2. php artisan event:generate 命令会生成上面 $listen 数组中需要的文件（app/Events/ & app/Listener）
 * 3. Event 一个事件类只是一个包含了相关事件信息的数据容器
 * 4. 在 Listener 中 handle() 编写响应该事件的逻辑，__construct() 可以注入所需的依赖，Listener 可以队列，命名空间已导入，implements ShouldQueue 即可
 * 5. 触发事件：Event::fire(new EventName($value)); 使用全局函数触发：event(new EventName($value));
 *
 * 修改时间：2017-04-28 14:21:59
 */
namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\SomeEvent' => [
        //     'App\Listeners\EventListener',
        // ],
        // 登陆失败，自增失败次数
        'App\Events\IncrementLoginAttempts' => [
            'App\Listeners\IncrementLoginAttemptsListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
