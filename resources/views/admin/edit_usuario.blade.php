@extends('layouts.app')

@section('title','Categorias')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                	<div class="row">
                		@if(isset($user))
	                		<div class="col-md-3">
	                			
					       		<div class="card" style="width: 180px;">
					       			@if($user->avatar == 'blank.png')
					       			<img class="img-fluid card-img-top" src="{{asset('img/blank.png')}}" style="width: 180px; height: 180px;">
					       			@else
					       			<img class="img-fluid card-img-top" src="{{asset('storage/users/'.$user->avatar)}}" style="width: 180px; height: 180px;">
					       			@endif
									
					       			<div class="card-body">
					       				<h5 class="card-title">{{$user->name}}</h5>
					       				<p class="card-text">{{$user->email}}</p>
					       			</div>
					       		</div>
				       	@endif
	                		</div>

	                		<div class="col-md-9">
				                @if(isset($user))
				               		<h4 class="text-danger">Editar Usuário</h4>
				               		<hr>
				                	@include('includes.alerts')
				                	<form class="form" method="POST" action="/admin/user/edit/{{$user->id}}" enctype="multipart/form-data" >
				                @else
					                <h4 class="text-danger">Criar Usuário</h4>
					               	<hr>
					               	@include('includes.alerts')
				                	<form class="form" method="POST" action="{{route('store.user')}}" enctype="multipart/form-data" >
				                @endif
						       		@csrf
						       		<div class="form-group">
						       			<label for="nome">Nível de acesso</label>
						       			@if(isset($user))
						       			<div class="form-group row">
						       				<div class="col-md-6">
						       					<input type="text" value="{{$nivel}}" class="form-control" disabled>
						       				</div>
						       				<div class="col-md-6">
							       				<select  name='nivel' class="selectpicker form-control" data-live-search="true" title="Nível">
								       				<option value="">Editar Nível</option>
			                                        <option value="editor">Editor</option> 
			                                        <option value="adm">Administrador</option> 
			                                        <option value="comum">Comum</option>   
		                                    	</select> 
						       				</div>
						       			</div>
						       			@else
						       			<select  name='nivel' class="selectpicker form-control" data-live-search="true" title="Nível">
						       				<option value="">Selecione</option>
	                                        <option value="editor">Editor</option> 
	                                        <option value="adm">Administrador</option> 
	                                        <option value="comum">Comum</option>   
	                                    </select>
						       			@endif
						       		</div>
						     
						       		<div class="form-group">
						       			<label for="nome">Nome</label>
						       			@if(isset($user))
						       				<input type="text" name="name" class="form-control" value="{{$user->name}}" placeholder="Nome de Usuário">
						       			@else
						       				<input type="text" name="name" class="form-control" placeholder="Nome de Usuário">
						       			@endif
						       		</div>
						       		@if(!isset($user))
						       		<div class="form-group">
						       			<label for="nome">Email</label>
						       			<input type="email" name="email" class="form-control" placeholder="Email">
						       		</div>
						       		@endif
						       		<div class="form-group">
						       			<label for="nome">Password</label>
						       			<input type="password" name="password" class="form-control" placeholder="Senha">
						       		</div>
						       		
						       		<div class="form-group">
						       			<label for="nome">Imagem</label>
						       			<input type="file" name="avatar" class="form-control">
						       		</div>

						       		<hr>

						       		<h5 class="text-danger">Endereço</h5>
						       		<hr>
						       		<div class="form-group">
						       			<label for="cep">CEP</label>
						       			@if(isset($endereco))
						       				<input type="text" name="cep" class="form-control" value="{{$endereco->cep}}" >
						       			@else
						       				<input type="text" name="cep" class="form-control" >	
						       			@endif	       			
						       		</div>
						       		<div class="form-group">
						       			<label for="cidade">Cidade</label>
						       			@if(isset($endereco))
						       				<input type="text" name="cidade" class="form-control" value="{{$endereco->cidade}}" >
						       			@else
						       				<input type="text" name="cidade" class="form-control" >	
						       			@endif	       			
						       		</div>
						       		<div class="form-group">
						       			<label for="uf">UF</label>
						       			@if(isset($endereco))
						       				<input type="text" name="uf" class="form-control" value="{{$endereco->uf}}" >
						       			@else
						       				<input type="text" name="uf" class="form-control" >	
						       			@endif	       			
						       		</div>
						       		
						       		<div>
						       			<button type="submit" class="btn btn-outline-danger"><i class="fas fa-save" style="font-size: 18px;"></i><b>  Salvar</b></button> 
						       			<a href="{{route('users')}}" class="btn btn-outline-danger"><i class="fas fa-th-list"></i> Voltar para lista</a>
						       		</div>
						       	</form>
                			</div>
            			</div>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection