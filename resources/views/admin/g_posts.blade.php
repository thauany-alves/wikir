@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                	@can('is_editor')
	                    <div class="row">
	                        <div class="col-md-10">
	                            <form method="GET" action="{{route('search.posts')}}" class="form form-inline">
	                            
	                                @if(isset($dataForm['id']))
	                                 <input type="text" name="id" class="form-control col-2" value="{{$dataForm['id']}}">
	                                @else
	                                 <input type="text" name="id" class="form-control col-2" placeholder="ID">
	                                @endif
	                               
	                                @if(isset($dataForm['categoria']))
	                                 <input type="text" name="categoria" class="form-control" value="{{$dataForm['categoria']}}">
	                                @else
	                                 <input type="text" name="categoria" class="form-control" placeholder="Categoria">
	                                @endif
	                                
	                                @if(isset($dataForm['user']))
	                                 <input type="text" name="user" class="form-control" value="{{$dataForm['user']}}">
	                                @else
	                                 <input type="text" name="user" class="form-control" placeholder="Usuário">
	                                @endif
	                                
	                                @if(isset($dataForm['cidade']))
	                                 <input type="text" name="cidade" class="form-control" value="{{$dataForm['cidade']}}">
	                                @else
	                                 <input type="text" name="cidade" class="form-control" placeholder="Cidade">
	                                @endif
	                                <button type="submit" class="btn btn-danger">Pesquisar</button>
	                            </form>
	                            @if(isset($dataForm))
	                                <a role="button" href="{{route('g.posts')}}" class="btn pull-left">Limpar filtros</a>
	                            @endif
	                        </div>
	                     
	                        <div class="col-md-1">
	                            <a href="{{route('new.post')}}" class="btn btn-danger"><i class="fas fa-plus-square" style="size: 5x;"></i> Novo Post</a>
	                        </div>
	                        
	                    </div>
     					</br>
                    	@include('includes.alerts')
	                    <table class="table">
	                        <thead class="bg-danger text-white">
	                            <tr>
	                                <th scope="col">#</th>
	                                <th scope="col">Categoria</th>
	                                <th scope="col">Descrição</th>
	                                <th scope="col">Status</th>
	                                <th scope="col">Data</th>
	                                <th scope="col">Cidade</th>
	                                <th scope="col">Usuário</th>
	                                <th scope="col">Ação</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            @foreach($posts as $p)
	                            <tr>
	                                <th scope="row">{{$p->id}}</th>
	                                <td>{{$p->nome}}</td>
	                                <td>{{$p->descricao}}</td>
	                                <td>{{$p->status}}</td>
	                                <td>{{\Carbon\Carbon::parse($p->created_at)->format('d/m/y')}}</td>
	                                <td>{{$p->cidade}}</td>
	                                <td>{{$p->name}}</td>
	                                <td>
	                                    <a href="/post/edit/{{$p->id}}" class="btn btn-sm text-danger"> <i class="fas fa-pen-square" ></i> Editar</a>
	                                    <a href="/posts/delete/{{$p->id}}" class="btn btn-sm text-danger"> <i class="fas fa-minus-square"></i> Remover</a>
	                                    <a href="/admin/post/details/{{$p->id}}" class="btn btn-sm text-danger"><i class="fas fa-search-plus"></i> Detalhes</a>
	                                </td>
	                            </tr>
	                                
	                            @endforeach
	                        </tbody>
	                    </table>
	                    @if(isset($dataForm))
							{{ $posts->appends($dataForm)->links()}}
						@else
							{{ $posts->links()}}
						@endif
		            @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection