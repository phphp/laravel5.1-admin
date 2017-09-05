<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRelationship extends Model
{
    protected $table = 'permission_relationships';
    protected $fillable = ['role_id', 'permission_id'];
    public $timestamps = false;
}
