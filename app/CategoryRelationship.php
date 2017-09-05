<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryRelationship extends Model
{
    protected $table = 'category_relationships';
    protected $fillable = ['post_id', 'category_id'];
    public $timestamps = false;
}
