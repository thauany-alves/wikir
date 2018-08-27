<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Endereco;
use App\Models\Post;
use App\Models\ImageUser;
use App\Models\Reply;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','editor','admin','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function endereco(){
        return $this->HasOne(Endereco::Class);
    }

    public function posts(){
        return $this->HasMany(Post::Class);
    }

    public function reply(){
        return $this->HasOne(Reply::Class);
    }

    public function users(){
        if(Gate::allows('is_admin')){
             $users = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->select('users.*','enderecos.cidade','enderecos.uf','enderecos.cep')
            ->where('users.editor', '=','N' )
            ->where('users.admin', '=', 'N')
            ->paginate(10);
        }else {
            $endereco = auth()->user()->endereco()->get()->first();
             $users = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->select('users.*','enderecos.cidade','enderecos.uf','enderecos.cep')
            ->where('users.editor', '=','N' )
            ->where('users.admin', '=', 'N')
            ->where('enderecos.cidade', '=',$endereco->cidade)
            ->where('enderecos.uf', '=',$endereco->uf)
            ->paginate(10);
        }
            return $users;
    }

    public function editores(){
        $users = DB::table('users')
        ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
        ->select('users.*','enderecos.cidade','enderecos.uf','enderecos.cep')
        ->where('users.editor', '=','S' )
        ->paginate(10);
        return $users;
    }

    public function admins(){
        $users = DB::table('users')
        ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
        ->select('users.*','enderecos.cidade','enderecos.uf','enderecos.cep')
        ->where('users.admin', '=', 'S')
        ->paginate(10);

        return $users;
    }
 
    public function search($data){
        $users = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->select('users.*', 'enderecos.cidade','enderecos.uf','enderecos.cep')
            ->where('users.editor', '=','N' )
            ->where('users.admin', '=', 'N')
            ->where( function($query) use ($data){
            if(isset($data['name']))
                $query->where('users.name','like','%'.$data['name'].'%');
            if(isset($data['email']))
                $query->where('users.email','like','%'.$data['email'].'%');
            if(isset($data['cidade']))
                $query->where('enderecos.cidade','like','%'.$data['cidade'].'%');
        })->paginate(10);

        return $users;
    }

    public function searchEditor($data){
        $users = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->select('users.*', 'enderecos.cidade','enderecos.uf','enderecos.cep')
            ->where('users.editor', '=','S' )
            ->where( function($query) use ($data){
            if(isset($data['name']))
                $query->where('users.name','like','%'.$data['name'].'%');
            if(isset($data['email']))
                $query->where('users.email','like','%'.$data['email'].'%');
            if(isset($data['cidade']))
                $query->where('enderecos.cidade','like','%'.$data['cidade'].'%');
        })->paginate(10);

        return $users;
    }

    public function searchAdm($data){
        $users = DB::table('users')
            ->join('enderecos', 'users.id', '=', 'enderecos.user_id')
            ->select('users.*', 'enderecos.cidade','enderecos.uf','enderecos.cep')
            ->where('users.admin', '=', 'S')
            ->where( function($query) use ($data){
            if(isset($data['name']))
                $query->where('users.name','like','%'.$data['name'].'%');
            if(isset($data['email']))
                $query->where('users.email','like','%'.$data['email'].'%');
            if(isset($data['cidade']))
                $query->where('enderecos.cidade','like','%'.$data['cidade'].'%');
        })->paginate(10);

        return $users;
    }
}
