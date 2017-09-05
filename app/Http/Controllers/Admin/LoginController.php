<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use Auth;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class LoginController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    /**
     * 后台登录表单页面
     */
    public function loginPage()
    {
        return view('admin/login/page');
    }

    /**
     * 验证管理员登录
     */
    function loginAuth(AdminLoginRequest $request)
    {
        // 正确的账户密码 && active = 1 && admin = 1
        if ( ! Auth::attempt(['name' => $request->name, 'password' => $request->password, 'active' => 1, 'admin' => 1], $request->remember) )
        {
            $this->incrementLoginAttempts($request); // 登录次数自增
            return back()->withErrors('错误的账号或密码')->withInput(); // 认证用户失败
        }
        else
        {
            return redirect()->route('dashboard_homepage'); // 认证用户通过
        }
    }

    /**
    * 登出
    */
    function logout()
    {
        Auth::logout();
        return redirect()->route('admin_login_page')->with('message','登出成功');
    }

    /**
     * 返回验证码
     * mews/captcha https://packagist.org/packages/mews/captcha
     * 配置文件： config/captcha.php
     */
    function captcha()
    {
        return captcha('admin_login'); // 使用配置文件中 'admin_login' 配置
    }


}
