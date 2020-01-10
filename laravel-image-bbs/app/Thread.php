<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['threadId', 'threadName', 'last_posted'];
    
    public function posts()
    {
        return $this->hasMany('App\Post', 'threadId', 'threadId');
    }
}
