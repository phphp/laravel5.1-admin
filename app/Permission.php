<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['name', 'url', 'code', 'sort'];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'permission_relationships');
    }
}
