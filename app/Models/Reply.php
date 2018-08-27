<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\User;

class Reply extends Model
{
	protected $table = 'replies';
    
    protected $fillable = [
        'reply', 'post_id','user_id',
    ];

    public function user(){
    	return $this->belongsTo(User::Class);
    }

     public function post(){
    	return $this->belongsTo(Post::Class);
    }
}
