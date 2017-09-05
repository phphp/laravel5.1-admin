<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 自定义的 nickname 表单验证规则
        \Validator::extend('nickname', function($attribute, $value, $parameters, $validator) {
            if (preg_match('/^[\x{4e00}-\x{9fa5}]{'.config('admin.zh_name_min_length').','.config('admin.zh_name_max_length').'}$/u', $value)) return true;
            elseif (preg_match('/^[a-zA-Z0-9_]{'.config('admin.name_min_length').','.config('admin.name_max_length').'}$/u', $value)) return true;
            else return false;
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
