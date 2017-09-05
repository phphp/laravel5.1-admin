<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'sort'];

    public function posts()
    {
        return $this->belongsToMany('App\Post', 'category_relationships');
    }
}
