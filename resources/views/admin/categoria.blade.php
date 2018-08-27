@extends('layouts.app')

@section('title','Categorias')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                	
                	<div class="row">
                		<div class="col-md-6">
                			<form method="GET" action="{{route('search.categoria')}}" class="form form-inline">
                			
	   							@if(isset($dataForm['id']))
		                			<input type="text" name="id" class="form-control col-2" placeholder="ID" value="{{$dataForm['id']}}">
		                		@else
		                			<input type="text" name="id" class="form-control col-2" placeholder="ID">
		                		@endif
		                		@if(isset($dataForm['categoria']))
		                			<input type="text" name="categoria" class="form-control col-6" placeholder="Categoria" value="{{$dataForm['categoria']}}">
		                		@else
		                			<input type="text" name="categoria" class="form-control col-6" placeholder="Categoria">
		                		@endif
	                			<button type="submit" class="btn btn-danger col-4">Pesquisar</button>
	                		</form>
	                		
                		</div>
                		<div class="col-md-2">
                			@if(isset($dataForm))
                				<a role="button" href="{{route('categoria')}}" class="btn pull-left">Limpar filtros</a>
                			@endif
                		</div>
                		<div class="col-md-4 mr-auto">
                			<a href="{{route('form.categoria')}}" class="btn btn-danger pull-right col-12"><i class="fas fa-plus" style="size: 5x;"></i> Nova categoria</a>

                		</div>
                		</br>
                	</div>
     
                	@include('includes.alerts')
                	<table class="table">
						<thead class="bg-danger text-white">
						    <tr>
						    	<th scope="col">#</th>
						    	<th scope="col">Categoria</th>
						    	<th scope="col">Ações</th>
						    </tr>
						</thead>
					    <tbody>
					    	@foreach($categorias as $c)
						    <tr>
						    	<th scope="row">{{$c->id}}</th>
						    	<td>{{$c->nome}}</td>
						    	<td>
						    		<a href="{{ action('CategoriaController@edit', $c->id) }}" class="btn btn-sm text-danger"> <i class="fas fa-pen-square" ></i> Editar</a>
						    		<a href="{{action('CategoriaController@delete', $c->id)}}" class="btn btn-sm text-danger"> <i class="fas fa-minus-square"></i> Remover</a>
						    	</td>
						    </tr>
						    	
						    @endforeach
					    </tbody>
					</table>
					@if(isset($dataForm))
						{{ $categorias->appends($dataForm)->links()}}
					@else
						{{ $categorias->links()}}
					@endif
					
               
                </div><!--Fim do card-body principal-->
            </div><!--Fim do card principal-->
        </div><!--Fim da coluna principal-->
    </div><!--Fim da row central principal-->
</div>	<!--Fim do container principal-->



@endsection

<style type="text/css">
    .buttons{
        float: right;
    }
    .buttons button{
        margin: 5px;
    }

    .btn-default{
        margin-top: 10px;
        margin-right: 5px;
    }

</style>
