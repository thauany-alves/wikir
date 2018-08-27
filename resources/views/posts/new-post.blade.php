
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-body">
                    
                    <div class="col-md-12 ">
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb bg-light">
                            <li class="breadcrumb-item"><a href="{{route('home')}}" >Painel</a></li>
                            <li class="breadcrumb-item"><a href="{{route('posts')}} ">Publicações</a></li>
                            <li class="breadcrumb-item active " aria-current="page">Editar</li>
                          </ol>
                        </nav>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}   
                        </div>
                    @endif


                    <div class="col-md-12">
                        @include('includes.alerts')

                        @if(isset($post->id))
                            <form method="POST" action="/post/edit/{{$post->id}}" enctype="multipart/form-data" > 
                        @else
                            <form method="POST" action="{{route('post.store')}}" enctype="multipart/form-data">
                        @endif
                            @csrf

                            <div class="form-group row">
                                <label for="location" class="col-md-2 col-form-label text-md-right">Localização do problema</label>

                                <div class="col-md-10"> 
                                    @if(isset($post->location))    
                                     <input type="text"  class="form-control" name="location" value="{{$post->location->address}}">
                                    @else
                                    <input type="text"  class="form-control" name="location" placeholder="Ex: Rua, Cidade, Estado">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Categoria" class="col-md-2 col-form-label text-md-right">Categoria</label>

                                <div class="col-md-10">
                                @if(isset($post->categoria->id))    
                                    <select  name="categoria_id" class="selectpicker form-control" data-live-search="true" title="Categoria">
                                        <option value="{{$post->categoria->id}}">{{$post->categoria->nome}}</option>
                                        @foreach($categorias as $c)
                                            <option value="{{$c->id}}">{{$c->nome}}</option>
                                        @endforeach    
                                    </select> 
                                @else
                                    <select name="categoria_id" class="selectpicker form-control" data-live-search="true" title="Categoria">
                                        <option value="">Selecione</option>
                                        @foreach($categorias as $c)
                                            <option value="{{$c->id}}">{{$c->nome}}</option>
                                        @endforeach
                                           
                                    </select> 
                                @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descricao" class="col-md-2 col-form-label text-md-right">Descrição</label>

                                <div class="col-md-10">
                                    <textarea id="descricao" type="text" class="form-control" name="descricao">{{isset($post->descricao) ? $post->descricao : ''}}</textarea> 
                                </div>
                            </div>

                            @can('is_editor')
                            <div class="form-group row">
                                <label for="status" class="col-md-2 col-form-label text-md-right">Status</label>

                                <div class="col-md-10">
                                    <select  name="status" class="selectpicker form-control" data-live-search="true" title="Status">
                                        <option value="{{isset($post->status) ? $post->status : '' }}"> 
                                            {{isset($post->status) ? $post->status : 'Selecione' }}
                                        </option>
                                        <option value="Aguardando resposta">Aguardando resposta</option>
                                        <option value="Respondido">Respondido</option>
                                        <option value="Fechado">Fechado</option> 
                                        <option value="Solucionado">Solucionado</option>     
                                    </select> 
                                </div>
                            </div>
                            @else
                            <div class="form-group row">
                                <label for="status" class="col-md-2 col-form-label text-md-right">Status</label>

                                <div class="col-md-10">
                                    <input id="status" type="text" class="form-control" name="status" value="{{isset($post->status) ? $post->status : 'Aguardando resposta'}}" disabled>
                                </div>
                            </div>
                            @endcan
                            
                            <div class="form-group row">
                                <label for="image" class="col-md-2 col-form-label text-md-right">Foto</label>

                                <div class="col-md-10">
                                     <input id="image" type="file" class="form-control" name="image">                         
                                </div>
                            </div>

                            @if(isset($post->image) && ($post->image != null) )
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-right">Imagem</label>
                                <div class="col-md-6">
                                    <img id='img-post' class="img-fluid" src="{{asset('storage/posts/'.$post->image)}}"> 
                                </div>
                            </div>
                                
                            @endif 


                            <div class=" row mb-0">
                                <div class="col-md-5 offset-md-2">
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i><b>  Publicar</b>
                                    </button>  
                                </div>
                                <a href="{{route('posts')}}" class="btn btn-outline-secondary" style="margin-right: 20px;"><i class="fas fa-th-list"></i> Publicações
                                </a>
                                @can('is_editor')
                                <a href="{{route('g.posts')}}" class="btn btn-outline-secondary "><i class="fas fa-th-list"></i> Voltar
                                </a>
                                @endcan
                            </div>
                    </form>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<style type="text/css">
    #img-post{
        width: 286;
        height: 180;
    }


    #map{
        height: 60%;
        width: 100%;
    }

</style>



