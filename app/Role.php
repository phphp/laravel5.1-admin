<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'sort'];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permission_relationships');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_relationships');
    }
}
