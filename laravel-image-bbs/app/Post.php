<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['threadId', 'noInThread', 'name', 'text', 'imageName'];
    
    public function thread()
    {
        return $this->belongsTo('App\Thread', 'threadId', 'threadId');
    }
}
