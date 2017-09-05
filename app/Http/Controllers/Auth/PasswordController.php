<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

// use
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendReminderEmail;
use Carbon\Carbon;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    | 部分重写 trait ResetsPasswords
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    // 重设密码后跳转的地址
    protected $redirectTo = '/';


    /**
     * Create a new password controller instance.
     * 已经登录的用户会返回首页，不是由 $redirectTo 属性控制
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * 重写 ResetsPasswords postEmail()
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'captcha' => 'required|captcha|size:4'
            ]);

        $user = User::where('email', $request->input('email'))->first();
        if ( $user == null || $user->active != 1 )
        {
            return redirect()->back()->withErrors(['email' => trans('passwords.user')]);
        }

        // 生成重置链接
        $token = $this->createToken();
        $resetURL = route('password_get_reset', ['token'=>$token]);

        // 修改 password_resets 表
        DB::table('password_resets')->where('email', $user->email)->delete();
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now()
            ]);

        $job = ( new SendReminderEmail('emails.password', compact('user', 'resetURL')) )
        ->onQueue('emails')->delay(10);
        $this->dispatch($job);
        return redirect()->back()->with('status', trans('passwords.sent'));
    }


    /**
     * 生成重置密码用的 token
     * @return str token
     */
    private function createToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }


    /**
     * 重写 ResetsPasswords resetPassword()
     */
    protected function resetPassword($user, $password)
    {
        $user->password = $password; // 在 App/User.php 中 hash

        $user->save();

        Auth::login($user);
    }


}
