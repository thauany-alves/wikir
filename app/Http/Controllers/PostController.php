<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\PostRequest;
use Request;

use App\Models\Categoria;
use App\Models\Post;
use Mapper;
use App\Models\Location;

class PostController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
   	}

   	public function getById($id){
   		$post = Post::find($id);
   		$categoria = $post->categoria;
   		return view('posts.posts', compact('post','categoria')) ;
   	}

   	/**
     * O metodo posts faz a listagem dos 
     * posts publicados na cidade do usuario logado.
     * 
     */
   	public function posts(){
   		$post = new Post();

   		if(Gate::allows('is_admin')){
			$posts = $post->allPosts();
		}else{
			$posts = $post->list();
		}
   		   		
   		$endereco = auth()->user()->endereco()->first();
  
   		$img = auth()->user()->avatar;
   		$message = 'Não há publicações! Publique algo e colabore com sua cidade!';

   		$info = 'Publicações em';

   		if(empty($posts[0]))
			return view('posts.posts',compact('message','endereco','img','info'));
				//->withMessage($message)
				//->withEndereco($endereco);


		return view('posts.posts',compact('posts','endereco','img','info'));
			//->withPosts($posts)
			//->withEndereco($endereco);
	}

	/**
     * O metodo postsUser faz a listagem apenas dos  
     * posts publicados pelo proprio usuario logado. 
     */
	public function postsUser(){

		$post = new Post();

		if(Gate::allows('is_admin')){
			$posts = $post->allPosts();
		}else{
			$posts = $post->userList();
		}
		$endereco = auth()->user()->endereco()->first();
		$message = 'Não há publicações! Publique algo!';
		$img = auth()->user()->avatar;

		if(empty($posts[0]))
			return view('posts.posts',compact('message','endereco','img','info'));

		return view('posts.posts',compact('posts','endereco','img','info'));

	}


	/**
     * O metodo allPosts faz a listagem de todos os posts independente de usuario e localização. 
     */
	public function allPosts(){
		$post = new Post();
		$posts = $post->allPosts();

		return view('admin.g_posts',compact('posts'));
	}


	/**
     * O metodo search faz um filtro de posts. 
     */
	public function search(Post $post){
   		$dataForm = Request::except('_token');

   		$posts = $post->search($dataForm);
   		if(Gate::allows('is_editor'))
   			return view('admin.g_posts',compact('posts','dataForm'));

   		return view('posts.posts',compact('posts','dataForm'));
   	}


	//metodo responsavel por direcionar a pagina de edição de post
	public function newPost(){
		$categorias = Categoria::all();
		
		return view('posts.new-post', compact('categorias'));
	}


	public function postStore(PostRequest $request){
		$data = $request->all();
		$date = date('ymd_H_i');
		//tratar a validação e o upload da foto
		if($request->hasFile('image') && $request->file('image')->isValid()){
			$name = $date.'-img';
			$extenstion = $request->image->extension();
			$nameFile = "{$name}.{$extenstion}";
			$data['image'] =  $nameFile;
			$upload = $request->image->storeAs('posts',$nameFile);

			if (!$upload)
					return redirect()
							->back()
							->with('error','Falha ao fazer upload da imagem');
		}else{
			$data['image'] = null;
		}

		//validar localização e salvar no banco
		$search_location = Mapper::location($request->location);
    	$longitude = str_replace(',','.', $search_location->getLongitude());
		$latitude = str_replace(',','.', $search_location->getLatitude());
		
		//salva no banco
		$location =  new Location();
		$location->address = $search_location->getAddress();
		$location->latitude = $latitude;
		$location->longitude = $longitude;
		$location->save(); 

		$post = auth()->user()->posts()->create([
			'descricao' => $data['descricao'],
			'categoria_id' => $data['categoria_id'],
			'image' => $data['image'],
			'user_id' => auth()->user()->id,
			'location_id' => $location->id,
		]);

		if($post)
			return redirect()
				->route('posts')
				->withSuccess('Sucesso ao publicar');

		return redirect()
				->back()
				->withError('Problema ao publicar');

	}

	public function delete($id){
		$post = Post::find($id);

		$delete = $post->delete();		
			
		if($delete)
			return redirect()
					->back();
		
		return redirect()
				->back()
				->withError('Erro ao excluir publicação');
	}

	public function editPost($id){

		$post = Post::Where('id', $id)->get()->first();
		$categoria = $post->categoria;
		$categorias = Categoria::all();

		if(Gate::denies('update_post',$post->user_id)){

			abort('403', 'Sem autorização');
		}
		return view('posts.new-post', compact('post','categoria', 'categorias'));
	}

	public function editPostStore (PostRequest $req, $id){
		$request = $req->all();
		$post = Post::Where('id',$id)->get()->first();

		if(Gate::denies('update_post',$post->user_id)){

			abort('403', 'Sem autorização');
		}

		$date = date('ymd_H_i');
		//tratar a validação e o upload da foto
		if($req->hasFile('image') && $req->file('image')->isValid()){
			$name = $date.'-img';
			$extenstion = $req->image->extension();
			$nameFile = "{$name}.{$extenstion}";
			$request['image'] =  $nameFile;
			$upload = $req->image->storeAs('posts',$nameFile);

			$post->image = $request['image'];
			if (!$upload)
					return redirect()
							->back()
							->with('error','Falha ao fazer upload da imagem');

		}
		if($req->location !== $post->location->address){
			//validar localização e salvar no banco
			$search_location = Mapper::location($req->location);
	    	$longitude = str_replace(',','.', $location->getLongitude());
			$latitude = str_replace(',','.', $location->getLatitude());
			

			//salva no banco
			$location =  new Location();
			$location->address = $search_location->getAddress();
			$location->latitude = $latitude;
			$location->longitude = $longitude;
			$location->save();
		}
		
		
		$post->descricao = $req->descricao;
		$post->categoria_id = $req->categoria_id;

		$post->save();

		return redirect()
			->route('posts')
			->withSuccess('Sucesso ao editar');



	}


}
