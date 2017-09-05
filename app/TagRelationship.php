<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagRelationship extends Model
{
    protected $table = 'tag_relationships';
    protected $fillable = ['post_id', 'tag_id'];
    public $timestamps = false;
}
