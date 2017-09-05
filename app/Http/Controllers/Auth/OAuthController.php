<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use
use Auth;
use Socialite;
use App\User;
use App\Oauth;

class OAuthController extends Controller
{
    /**
     * 将用户重定向到 Provider 认证页面
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 从 Provider 获取认证用户信息
     */
    public function handleProviderCallback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/')->withError('认证失败');
        }

        $user = $this->findOrCreateUser($providerUser, $provider);

        Auth::login($user, true);

        return redirect('/')->with('message', '登录成功');
    }

    /**
     * 查询返回用户，或者创建新用户后返回用户
     * @param  $providerUser
     * @param  $provider
     * @return $user
     */
    private function findOrCreateUser($providerUser, $provider)
    {
        // has OAuth user
        if ( $oauthUser = Oauth::where('provider', 'github')->where('open_auth_id', $providerUser->id)->first() )
        {
            $user = User::where('id', $oauthUser->user_id)->first();
        }
        else
        {
            $hasUser = User::where('name', $providerUser->name)->first();
            if ( $hasUser ) {
                $userName = $providerUser->name.'_'.substr($provider, 0, 1).$providerUser->id;
                $rename = 1;
            } else {
                $userName = $providerUser->name;
                $rename = 0;
            }

            // create user
            $user = User::create([
                'name'      => $userName,
                'active'    => 1,
                'admin'     => 0,
                ]);

            // create oauth user
            $oauthUser = Oauth::create([
                'user_id'           => $user->id,
                'provider'          => 'github',
                'rename'            => $rename,
                'open_auth_id'      => $providerUser->id,
                'name'              => $providerUser->name,
                'nickname'          => $providerUser->nickname,
                'email'             => $providerUser->email,
                'avatar'            => $providerUser->avatar,
                'provider_user_link'=> $providerUser->user['html_url'],
                'access_token'      => $providerUser->token,
                'refresh_token'     => $providerUser->refreshToken,
                'expires_in'        => $providerUser->expiresIn,
                ]);
        }

        return $user;
    }

}
