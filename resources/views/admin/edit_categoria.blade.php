@extends('layouts.app')

@section('title','Categorias')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body text-danger">
                @if(isset($categoria))
               		<h4>Editar Categoria</h4>
               		<hr>
                	@include('includes.alerts')
                	<form class="form" method="POST" action="/admin/categoria/update/{{$categoria->id}}">
                @else
	                <h4>Criar Categoria</h4>
	               	<hr>
	               	@include('includes.alerts')
                	<form class="form" method="POST" action="{{route('new.categoria')}}">
                @endif
		       		@csrf
		       		<div class="form-group">
		       			<label for="nome">Categoria</label>
		       			@if(isset($categoria))
		       				<input type="text" name="nome" class="form-control" value="{{$categoria->nome}}" placeholder="Nome da categoria. Ex: Buracos em vias">
		       			@else
		       				<input type="text" name="nome" class="form-control" placeholder="Nome da categoria. Ex: Buracos em vias">
		       			@endif
		       		</div>

		       		
		       		<div>
		       			<button type="submit" class="btn btn-outline-danger"><i class="fas fa-save" style="font-size: 18px;"></i><b>  Salvar</b></button> 
		       			<a href="{{route('categoria')}}" class="btn btn-outline-danger"><i class="fas fa-th-list"></i> Voltar para lista</a>
		       		</div>
		        	
		       	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection