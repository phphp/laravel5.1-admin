<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title', 'slug', 'status', 'type', 'content'];

    public function category()
    {
        return $this->belongsToMany('App\Category', 'category_relationships');
    }

    public function categoryId()
    {
        return $this->hasOne('App\CategoryRelationship');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'tag_relationships');
    }

    public function tagIds()
    {
        return $this->hasMany('App\TagRelationship');
    }

}
