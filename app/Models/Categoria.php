<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
	
	public $timestamps = false;
    
    protected $fillable = array('nome');

    public function posts(){
    	return $this->hasMany(Post::Class);
    }

    public function search( Array $data){
    	return $this->where( function($query) use ($data){
    		if(isset($data['id']))
    			$query->where('id',$data['id']);
    		if(isset($data['categoria']))
    			$query->where('nome','like','%'.$data['categoria'].'%');
    	})->paginate(10);

    }
}
