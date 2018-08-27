<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Endereco extends Model
{
    protected $table = 'enderecos';
	
	public $timestamps = false;
    
    protected $fillable = array('logradouro','bairro','cep','cidade','uf','user_id');

    public function verifica_endereco(){
    	$user_id = auth()->user()->id;
    	$endereco = DB::table('enderecos')
            ->join('users', 'users.id', '=', 'enderecos.user_id')
            ->select('enderecos.*')
            ->where('users.id', '=', $user_id)
            ->get()->first();

        $existe = true;

        if(empty($endereco->id)){
        	$existe = false;
        }


        return $existe;
    }
}
