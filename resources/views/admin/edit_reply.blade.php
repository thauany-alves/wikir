@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Posts</li>
                              </ol>
                            </nav>
                        </div>

                        <div class="col-md-4">
                            <a href="{{route('new.post')}}" class="btn btn-danger btn-lg col-12"><i class="fas fa-plus-square" style="size: 5x;"></i> Novo Post</a>
                            </br>
                        </div>
                    </div>
                

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                  
                    <div class="row">
                        <div class="col-md-3">  
                            </br>
                            <div class="card">
                                <div class="card-body">
                                    @if(isset($endereco))
                                    <h4 class="card-title">{{$endereco->cidade}} - {{$endereco->uf }}</h4>
                                    @endif
                                    <p class="card-text"><b>{{ auth()->user()->name }} </b></br>{{ auth()->user()->email }}</p>
                                    @if(isset($img))
                                        @if($img != null)
                                            <img class="img-fluid" src="{{asset('storage/users/'.$img)}}" style="width: 160px; height: 160px;"></br>
                                        @else
                                            <img class="img-fluid" src="{{asset('storage/users/blank.png')}}" style="width: 160px; height: 160px;"></br>
                                        @endif
                                    @endif
                                </div>  
                            </div>
                        </div>
                        
                        
                        <div class="col-md-9"> 
                        </br> 
                            @include('includes.alerts')
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                    @can('update_post', $post->user_id)
                                        <div class="dropdown" id="links">
                                            <a role="button" class="btn text-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuLink">
                                             Ação </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a id="a-editar" href="{{ action('PostController@editPost', $post->id) }}" class="dropdown-item">Editar </a> 
                                                <a id="a-remover" href="{{ action('PostController@delete',$post->id) }}" class="dropdown-item"> Remover </a>  
                                            </div>   
                                        </div>
                                    @endcan
                                        <p class="card-title">
                                            <img class="img-fluid" src="{{asset('storage/users/'.$post->user->avatar)}}" style="width: 40px; height: 40px;">
                                        
                                            <b> {{$post->user->name}}</b> notificou <b>{{$post->categoria->nome}} </b> em {{\Carbon\Carbon::parse($post->created_at)->format('d-m-y')}}
                                            
                                        </p>   
                                    </div>
                                    
                                    <p class="card-text">{{$post->descricao}}</p>

                                    @if($post->image != null)
                                        <img id="img-post" src="{{asset('storage/posts/'.$post->image)}}" alt="Imagem do post" class="img-fluid">
                                    @endif
                                    <small class="text-muted">{{$post->status}}</small>
                                     <hr> 
                                    @can('is_editor')
                                      <form action="/admin/reply/update/{{$reply->id}}" method="POST" class="form form-inline">
                                        @csrf
                                          <input type="hidden" name="post_id" value="{{$post->id}}">
                                          <div class="input-group col-12">
                                             <input type="text" name="reply" class="form-control" value="{{$reply->reply}}" autofocus>
                                             <div class="input-group-append">
                                                 <button type="submit" class="btn btn-outline-info btn-sm">Responder</button>
                                             </div> 
                                          </div>
                                      </form>
                                    @endcan
                                </div> 
                            </div>                            
                        </div>                      
                    </div>
                </div><!--fim card corpo central-->
            </div>
        </div>
    </div>
</div>


@endsection

<style type="text/css">
    #img-post{
        width: 820px;
        height: 312px;
        position: relative;
    } 

    #links{
        position:relative;
        float: right;
    }





</style>
