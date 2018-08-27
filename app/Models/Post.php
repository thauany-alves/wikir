<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Location;
use App\User;
use App\Models\Reply;

class Post extends Model
{
    protected $table = 'posts';
	
	public $timestamps = true;
    
    protected $fillable = array('descricao','status','image','categoria_id','user_id', 'location_id');

    protected $guarded = ['id'];

    public function categoria(){
    	return $this->belongsTo(Categoria::Class);
    }

    public function user(){
        return $this->belongsTo(User::Class);
    }

    public function reply(){
        return $this->HasOne(Reply::Class);
    }

    public function location(){
        return $this->belongsTo(Location::Class);
    }

    public function userList(){
    	$endereco = auth()->user()->endereco()->get()->first();
    	$user_id = auth()->user()->id;
    	$posts = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('categorias', 'posts.categoria_id', '=', 'categorias.id')
            ->join('locations', 'posts.location_id', '=', 'locations.id')
            ->leftJoin('replies', 'replies.post_id', '=', 'posts.id')
            ->select('users.name','users.email', 'enderecos.cidade','enderecos.uf','categorias.nome','posts.*','locations.address', 'locations.latitude','locations.longitude','users.avatar','replies.reply', 'replies.user_id as editor','replies.created_at as data_resposta', 'replies.id as reply_id')
            ->where('enderecos.cep', '=', $endereco->cep)
            ->where('enderecos.cidade', '=', $endereco->cidade)
            ->where('users.id', '=', $user_id)
            ->latest()
            ->get();
          
            return $posts;
    }


    public function list(){
    	$endereco = auth()->user()->endereco()->get()->first();
    	$posts = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('categorias', 'posts.categoria_id', '=', 'categorias.id')
            ->join('locations', 'posts.location_id', '=', 'locations.id')
            ->leftJoin('replies', 'replies.post_id', '=', 'posts.id')
            ->select('users.name','users.email', 'enderecos.cidade','enderecos.uf','categorias.nome','posts.*','locations.address', 'locations.latitude','locations.longitude','users.avatar', 'replies.reply', 'replies.user_id as editor','replies.created_at as data_resposta', 'replies.id as reply_id')
            ->where('enderecos.cep', '=', $endereco->cep)
            ->where('enderecos.cidade', '=', $endereco->cidade)
            ->latest()
            ->get();
            return $posts;

    }

    public function allPosts(){
        $posts = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('categorias', 'posts.categoria_id', '=', 'categorias.id')
            ->join('locations', 'posts.location_id', '=', 'locations.id')
            ->leftJoin('replies', 'replies.post_id', '=', 'posts.id')
            ->select('users.name','users.email', 'enderecos.cidade','enderecos.uf','categorias.nome','posts.*','locations.address', 'locations.latitude','locations.longitude','users.avatar','replies.reply', 'replies.user_id as editor','replies.created_at as data_resposta', 'replies.id as reply_id')
            ->latest()
            ->paginate(10);

            return $posts;

    }

    public function search(Array $data){
        $posts = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('categorias', 'posts.categoria_id', '=', 'categorias.id')
            ->select('users.name','users.email', 'enderecos.cidade','enderecos.uf','categorias.nome','posts.*','users.avatar')
            ->where( function($query) use ($data){
            if(isset($data['id']))
                $query->where('posts.id',$data['id']);
            if(isset($data['categoria']))
                $query->where('categorias.nome','like','%'.$data['categoria'].'%');
             if(isset($data['user']))
                $query->where('users.name','like','%'.$data['user'].'%');
            if(isset($data['cidade']))
                $query->where('enderecos.cidade','like','%'.$data['cidade'].'%');
        })->paginate(10);

        return $posts;
    }

}
