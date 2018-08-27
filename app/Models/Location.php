<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = array('latitude','longitude','address');

    public $timestamps = false;

    public function post(){
    	return $this->HasOne(Post::Class);
    }
}
