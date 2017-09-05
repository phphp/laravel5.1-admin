<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oauth extends Model
{
    protected $table = 'oauth';
    protected $fillable = [
    'user_id',
    'provider',
    'open_auth_id',
    'name',
    'nickname',
    'email',
    'avatar',
    'provider_user_link',
    'acccess_token',
    'refresh_token',
    'expires_in'
    ];
}
