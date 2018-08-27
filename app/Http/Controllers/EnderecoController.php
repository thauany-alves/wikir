<?php

namespace App\Http\Controllers;

use Request;
use App\Models\Endereco;
use App\Http\Requests\EnderecoRequest;

class EnderecoController extends Controller
{
    
    public function __construct(){
        
        $this->middleware('auth');
   	}

   	public function index(){
   		//verificar se o usuario já tem endereco cadastrado
   		$endereco = new Endereco();
   		$result = $endereco->verifica_endereco();
   		
   		if (!$result) 
   			return view('user.endereco');
   		// se existir
   		return redirect()
   			->route('home')
   			->withMessage('Já há endereço cadastrado na base de dados');
	}

	
	public function create(){
		//verificar se o usuario já tem endereco cadastrado

		$endereco = new Endereco(Request::all());
		$endereco->user_id = auth()->user()->id;
		$result = $endereco->save();

		return redirect('home');
	}

	public function update(EnderecoRequest $request){

		$endereco = auth()->user()->endereco()->first();

		$update = $endereco->update($request->all());

		return redirect()->back();
	}

}
