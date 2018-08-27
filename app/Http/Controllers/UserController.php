<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\UpdatePerfilRequest;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use App\Models\ImageUser;
use App\User;

class UserController extends Controller
{
     public function __construct(){
        
        $this->middleware('auth');
   	}


   	public function users(){
   		$user = new User();
   		$users = $user->users();
      $nivel = 'Habitantes';
   		return view('admin.usuario', compact('users','nivel'));
   	}

    public function editores(){
      $user = new User();
      $users = $user->editores();
      $nivel = 'Editores';
      return view('admin.usuario', compact('users','nivel'));
    }

    public function admins(){
      $user = new User();
      $users = $user->admins();
      $nivel = 'Administradores';
      return view('admin.usuario', compact('users','nivel'));
    }

   	public function search(User $user){
   		$dataForm = Request::except('_token');
   		$users = $user->search($dataForm);
      $nivel = 'Habitantes';
   		return view('admin.usuario', compact('users','dataForm','nivel'));
   	}

    public function searchEditor(User $user){
      $dataForm = Request::except('_token');
      $users = $user->searchEditor($dataForm);
      $nivel = 'Editores';
      return view('admin.usuario', compact('users','dataForm','nivel'));
    }

    public function searchAdm(User $user){
      $dataForm = Request::except('_token');
      $users = $user->searchAdm($dataForm);
      $nivel = 'Administradores';
      return view('admin.usuario', compact('users','dataForm','nivel'));
    }

   	public function delete($id){
        $user = User::find($id);
        if($user->id == auth()->user()->id)
          return redirect()->back()->withError('O sistema não permite essa exclusão!');
        
        $del = $user->delete();
        return redirect()->back();
   	}

   	public function formNew(){
        return view('admin.edit_usuario');
   	}

   	public function store(NewUserRequest $user_request, EnderecoRequest $end_request){
        $user = new User();
        $endereco = new Endereco();

        $dataUser = $user_request->only('name','email','password','avatar','nivel');
        $dataEnd = $end_request->only('cep','cidade','uf');
        $dataUser['password'] = bcrypt($dataUser['password']);
        $dataUser['avatar'] = isset($dataUser['avatar']) ? $dataUser['avatar'] : 'blank.png';
        if($user_request->hasFile('avatar') && $user_request->file('avatar')->isValid()){
          $name = date().'-img';
          $extenstion = $user_request->avatar->extension();
          $nameFile = "{$name}.{$extenstion}";
          $dataUser['avatar'] =  $nameFile;
          $upload = $user_request->avatar->storeAs('users',$nameFile);
          if (!$upload){
            $dataUser['avatar'] = 'blank.png';
          }
        }
        
        $editor = 'N'; $admin = 'N'; $route = 'users';
        if(isset($dataUser['nivel'])){
          
          if($dataUser['nivel'] == 'editor'){
            $editor = 'S';
            $route = 'editores';
          }

          if ($dataUser['nivel'] == 'adm') {
            $admin = 'S';
            $route = 'admins';
          }

          if ($dataUser['nivel'] == 'comum'){
            $editor = 'N'; $admin = 'N'; $route = 'users';
          }  
        }
        
        $new = $user->create([
          'name'    => $dataUser['name'],
          'email'    => $dataUser['email'],
          'password'    => $dataUser['password'],
          'avatar'    => $dataUser['avatar'],
          'editor'    => $editor,
          'admin'    => $admin,
        ]);

        $newEnd = $endereco->create([
            'cidade'    => $dataEnd['cidade'],
            'cep'       => $dataEnd['cep'],
            'uf'        => $dataEnd['uf'],
            'user_id'   => $new->id,
        ]);
        if ($new && $newEnd) 
          return redirect()->route($route);   
        
        return redirect()->back()->withError('Erro ao criar usuário! Tente novamente');
   	}

   	public function edit($id){
   		$user = User::find($id); 
   		$endereco = Endereco::where('user_id',$id)->first();
      $nivel = 'Comum';
      if($user->editor == 'S'){
        $nivel = 'Editor';
      }
      if ($user->admin == 'S') {
        $nivel = 'Administrador';
      }
      
   		return view('admin.edit_usuario', compact('user','endereco','nivel'));
   	}


   	public function update($id, EnderecoRequest $end_request, EditUserRequest $user_request){
      $user = User::find($id);
      
      $dataUser = $user_request->only('name','password','avatar','nivel');
      $dataEnd = $end_request->only('cep','cidade','uf');
      $dataUser['password'] = isset($dataUser['password']) ? bcrypt($dataUser['password']) : $user->password;
      $dataUser['avatar'] = isset($dataUser['avatar']) ? $dataUser['avatar'] : $user->avatar;
      
      if($user_request->hasFile('avatar') && $user_request->file('avatar')->isValid()){
        $name = $user->id.'-img';
        $extenstion = $user_request->avatar->extension();
        $nameFile = "{$name}.{$extenstion}";
        $dataUser['avatar'] =  $nameFile;
        $upload = $user_request->avatar->storeAs('users',$nameFile);
        if (!$upload)
            return redirect()
                ->back()
                ->with('error','Falha ao fazer upload da imagem');
      }
      
      $editor = $user->editor ; $admin = $user->admin; 
      $route = 'users';
      if(isset($dataUser['nivel'])){
        if($dataUser['nivel'] == 'editor'){
          $editor = 'S';  $admin = 'N';
          $route = 'editores';
        }
        if ($dataUser['nivel'] == 'adm') {
          $admin = 'S';   $editor = 'N';
          $route = 'admins';
        }  
        if ($dataUser['nivel'] == 'comum'){
            $editor = 'N'; $admin = 'N'; $route = 'users';
        } 
      }

      $updateUser = $user->update([
            'name'    => $dataUser['name'],
            'password'    => $dataUser['password'],
            'avatar'    => $dataUser['avatar'],
            'editor'    => $editor,
            'admin'    => $admin,
      ]);
      $endereco = Endereco::where('user_id',$id)->first();
      $updateEnd = $endereco->update($dataEnd);

      if($updateUser && $updateEnd)
        return redirect()
          ->route($route)
          ->withSuccess('Sucesso ao editar usuário');

      return redirect()
        ->back()
        ->withError('Erro ao editar usuário');
   	}



   	public function perfil(){
   		$img = auth()->user()->avatar;
      $endereco = auth()->user()->endereco()->first();

  		return view('user.perfil')
  			->withEndereco($endereco)
  			->withImg($img);
	}

	public function updateUser(UpdatePerfilRequest $request){
		$data = $request->only('name','avatar');
    $id = auth()->user()->id;
    
    if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
  			$name = $id.'-img';
  			$extenstion = $request->avatar->extension();
  			$nameFile = "{$name}.{$extenstion}";
  			$data['avatar'] =  $nameFile;
  			$upload = $request->avatar->storeAs('users',$nameFile);
  			if (!$upload){
          $data['avatar']='blank.png';
        }		
		}
		
		$update = auth()->user()->update($data);

		if($update)
			return redirect()
				->route('perfil')
				->withSuccess('Sucesso ao editar perfil');

		return redirect()
			->back()
			->withErro('Erro ao editar perfil');
	}

}
