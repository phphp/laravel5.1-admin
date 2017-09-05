<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

// use
use Mail;
// use Illuminate\Mail\Message;

class SendReminderEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $view; // 需要发送的视图文件
    protected $value; // 视图中用到的用户数据

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($view, $value)
    {
        $this->view = $view;
        $this->value = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 发送重置密码邮件
        $response = Mail::send($this->view, $this->value, function ($message) {
            $message->from(config('mail.username'), 'admin');
            $message->to($this->value['user']['email'], $this->value['user']['name'])->subject('重置密码');
        });
    }


    /**
     * 执行失败，记录日志
     * 最大失败数通过指令设置，如：sudo php artisan queue:listen --tries 3
     */
    public function failed()
    {
        \Log::alert('发送重置密码队列邮件失败 @ ' . $this->value['user']['email'] . "\n");
    }
}
