<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Request;
use App\Http\Requests\CategoriaRequest;

class CategoriaController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
   	}

   	public function index(){
   		$categorias = Categoria::paginate(10);
   		return view('admin.categoria', compact('categorias'));
   	}

   	public function search(Categoria $categoria){
   		$dataForm = Request::except('_token');

   		$categorias = $categoria->search($dataForm);

   		return view('admin.categoria', compact('categorias','dataForm'));
   	}

   	public function list(){

   		$categorias = Categoria::all();

   		return view('post.new-post')->withCategorias($categorias); 
   	}

   	public function form(){
   		return view('admin.edit_categoria');
   	}

   	public function create(CategoriaRequest $req){
   		
   		$request = $req->all();
   		$save = Categoria::create($request);
   		$nome = $req->nome;

   		if($save)
   			return redirect()
   				->back()
   				->withSuccess('Categoria '.$nome.' salva com sucesso!' );
   		
   		return redirect()
   				->back()
   				->withError('Não foi possível salvar categoria '.$nome);
   	}

   	public function edit($id){
   		
   		$categoria = Categoria::find($id);
   		return view('admin.edit_categoria')
   			->withCategoria($categoria);

   		//find the categoria
   	}

   	public function update(CategoriaRequest $req, $id){
   		$categoria = Categoria::find($id);
   		$categoria->nome = $req->nome;

   		$save = $categoria->save();

   		if($save)
   			return redirect()
   				->route('categoria');

   		return redirect()
   				->back()
   				->withError('Problema ao salvar');

   		//find the categoria
   	}

   	public function delete($id){
   		$categoria = Categoria::find($id);
   		$nome = $categoria->nome;
   		$delete = $categoria->delete();

   		if(!$delete)
   			return redirect()->back()->withError('Erro ao tentar remover categoria '.$categoria->nome);

   		return redirect()->back();
   	}


}
