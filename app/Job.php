<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

	public function getAvailableAtAttribute()
	{
        return date('Y-m-d H:i:s', $this->attributes['available_at']);
	}
}
