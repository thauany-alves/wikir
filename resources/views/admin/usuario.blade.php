@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                	@can('is_editor')
                	<h5>Gestão de {{$nivel}}</h5>
                	<hr>
	                    <div class="row">
	                        <div class="col-md-10">
	                        	@if($nivel == 'Habitantes')
	                            	<form method="GET" action="{{route('search.users')}}" class="form form-inline">
	                            @else
	                            	@if($nivel == 'Editores')
	                            	<form method="GET" action="{{route('search.editores')}}" class="form form-inline">
	                            	@endif
	                            	@if($nivel == 'Administradores')
	                            	<form method="GET" action="{{route('search.admins')}}" class="form form-inline">
	                            	@endif
	                            @endif  
	                                @if(isset($dataForm['name']))
	                                 <input type="text" name="name" class="form-control" value="{{$dataForm['name']}}">
	                                @else
	                                 <input type="text" name="name" class="form-control" placeholder="Nome">
	                                @endif
	                                
	                                @if(isset($dataForm['email']))
	                                 <input type="text" name="email" class="form-control" value="{{$dataForm['email']}}">
	                                @else
	                                 <input type="text" name="email" class="form-control" placeholder="Email">
	                                @endif
	                                
	                                @can('is_admin')
		                                @if(isset($dataForm['cidade']))
		                                 <input type="text" name="cidade" class="form-control" value="{{$dataForm['cidade']}}">
		                                @else
		                                 <input type="text" name="cidade" class="form-control" placeholder="Cidade">
		                                @endif
		                            @endcan
	                                <button type="submit" class="btn btn-danger">Pesquisar</button>
	                            </form>
	                            @if(isset($dataForm))
	                     			@if($nivel == 'Administradores')
	                                	<a role="button" href="{{route('admins')}}" class="btn pull-left">Limpar filtros</a>
	                                @endif
	                                @if($nivel == 'Editores')
	                                	<a role="button" href="{{route('editores')}}" class="btn pull-left">Limpar filtros</a>
	                                @endif
	                                @if($nivel == 'Habitantes')
	                                	<a role="button" href="{{route('users')}}" class="btn pull-left">Limpar filtros</a>
	                                @endif
	                            @endif
	                        </div>
	                     
	                        <div class="col-md-1">
	                            <a href="{{route('new.user')}}" class="btn btn-danger"><i class="fas fa-plus-square" style="size: 5x;"></i> Novo Usuário</a>
	                        </div>
	                        
	                    </div>
     					</br>
                    	@include('includes.alerts')
	                    <table class="table">
	                        <thead class="bg-danger text-white">
	                            <tr>
	                                <th scope="col">Avatar</th>
	                                <th scope="col">Nome</th>
	                                <th scope="col">Email</th>
	                                <th scope="col">Cidade</th>
	                                <th scope="col">UF</th>
	                                <th scope="col">Ação</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            @foreach($users as $u)
	                            <tr>
	                                <td>
	                                	@if($u->avatar == 'blank.png')
	                                	<img class="img-fluid" src="{{asset('img/blank.png')}}" style="width: 40px; height: 40px;">
	                                	@else
	                                	<img class="img-fluid" src="{{asset('storage/users/'.$u->avatar)}}" style="width: 40px; height: 40px;">
	                                	@endif
	                                </td>
	                                <td>{{$u->name}}</td>
	                                <td>{{$u->email}}</td>
	                                <td>{{$u->cidade}}</td>
	                                <td>{{$u->uf}}</td>
	                                <td>
	                                    <a href="{{ action('UserController@edit', $u->id) }}" class="btn btn-sm text-danger"> <i class="fas fa-pen-square" ></i> Editar</a>
	                                    <a href="{{action('UserController@delete',$u->id)}}" class="btn btn-sm text-danger"> <i class="fas fa-minus-square"></i> Remover</a>
	                                </td>
	                            </tr>    
	                            @endforeach
	                        </tbody>
	                    </table>
	                    @if(isset($dataForm))
							{{ $users->appends($dataForm)->links()}}
						@else
							{{$users->links()}}
						@endif
		            @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection