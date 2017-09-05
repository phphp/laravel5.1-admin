<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleRelationship extends Model
{
    protected $table = 'role_relationships';
    protected $fillable = ['user_id', 'role_id'];
	public $timestamps = false;
}
