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
                                        @if($img == 'blank.png')
                                            <img class="img-fluid" src="{{asset('img/blank.png')}}" style="width: 160px; height: 160px;"></br>
                                        @else
                                            <img class="img-fluid" src="{{asset('storage/users/'.$img)}}" style="width: 160px; height: 160px;"></br>
                                        @endif
                                    @endif
                                </div>  
                            </div>

                        </div>
                        
                        
                        <div class="col-md-9"> 
                        </br> 
                            @include('includes.alerts')
                                
                            @if(isset($posts))
                                @foreach($posts as $p)
                                <div class="card">
                                    <div class="card-header"><!--card header-->
                                       <div class="container">
                                            @can('update_post', $p->user_id)
                                                <div class="dropdown" id="links">
                                                    <a role="button" class="btn text-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuLink">
                                                     Ação </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a id="a-editar" href="{{ action('PostController@editPost', $p->id) }}" class="dropdown-item">Editar </a> 
                                                        <a id="a-remover" href="{{ action('PostController@delete',$p->id) }}" class="dropdown-item"> Remover </a> 
                                                    </div>   
                                                </div>
                                            @endcan
                                            <div class="row"><!-- row header-->
                                                @if($p->avatar == 'blank.png')
                                                    <img class="img-fluid" id="img_user_sm" src="{{asset('img/blank.png')}}">
                                                @else
                                                    <img id="img_user_sm" class="img-fluid" src="{{asset('storage/users/'.$p->avatar)}}">
                                                @endif
                                                    <p> 
                                                        <b> {{$p->name}}</b> notificou <b>{{$p->nome}} </b></br> 
                                                        <small>
                                                            <i id="i_time" class="far fa-clock"></i> {{\Carbon\Carbon::parse($p->updated_at)->format('d M y')}} em   
                                                            <i id="i_local" class="fas fa-map-marker-alt"></i>  {{$p->address}}
                                                        </small>
                                                    </p>  
                                            </div> <!--fim row header-->  
                                        </div> <!--fim container card-->
                                    </div><!--fim card header-->
                                    <div class="card-body">
                                        
                                        
                                        <p class="card-text">{{$p->descricao}}</p>
                                        @if($p->image != null)
                                            <img id="img-post" src="{{asset('storage/posts/'.$p->image)}}" alt="Imagem do post" class="img-fluid"></br>
                                        @endif
                                        <p class="card-text"><small class="text-muted">{{$p->status}}</small></p>
                                        <hr>
                                        @if(isset($p->reply))
                                            @can('is_editor')
                                            <div id="links">
                                                <a id="a-editar" href="{{ action('ReplyController@formEdit', $p->reply_id) }}" class="btn btn-sm">Editar </a> 
                                                <a id="a-remover" href="{{ action('ReplyController@delete',$p->reply_id) }}" class=" btn btn-sm"> Remover </a>    
                                            </div>
                                            @endcan 
                                            <div class="col-md-9 ">
                                               <small><b class="text-info">Editor </b> em <b class="text-info">{{ \Carbon\Carbon::parse($p->data_resposta)->format('d M y')}}</b> </br> {{$p->reply}} </small>
                                            </div>
                                        @else
                                            @can('is_editor')
                                              <form action="/admin/reply/{{$p->id}}" method="POST" class="form">
                                                @csrf
                                                    <input type="hidden" name="post_id" value="{{$p->id}}">
                                                    <div class="input-group col-12">
                                                        <input name="reply" class="form-control" placeholder="Resposta...">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-outline-info btn-sm">Responder</button>
                                                        </div> 
                                                    </div>
                                              </form>
                                            @endcan
                                        @endif
                                        
                                    </div> 
                                </div>
                                </br>
                                @endforeach
                            @else
                                @if(isset($post))
                                    <div class="card">
                                        <div class="card-header"><!--card header-->
                                           <div class="container">
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
                                                <div class="row"><!-- row header-->
                                                    @if($post->user->avatar == 'blank.png')
                                                    <img id="img_user_sm" class="img-fluid" src="{{asset('img/blank.png')}}">
                                                    @else
                                                    <img id="img_user_sm" class="img-fluid" src="{{asset('storage/users/'.$post->user->avatar)}}">
                                                    @endif
                                                        <p> 
                                                            <b> {{$post->user->name}}</b> notificou <b>{{$post->categoria->nome}} </b></br> 
                                                            <small>
                                                                <i id="i_time" class="far fa-clock"></i> {{\Carbon\Carbon::parse($post->updated_at)->format('d M y')}} em   
                                                                <i id="i_local" class="fas fa-map-marker-alt"></i>  {{$post->location->address}}
                                                            </small>
                                                        </p>  
                                                </div> <!--fim row header-->  
                                            </div> <!--fim container card-->
                                        </div><!--fim card header-->
                                        
                                        <div class="card-body">
                                            <p class="card-text">{{$post->descricao}}</p>

                                            @if($post->image != null)
                                                <img id="img-post" src="{{asset('storage/posts/'.$post->image)}}" alt="Imagem do post" class="img-fluid">
                                            @endif

                                            <p class="card-text"><small class="text-muted">{{$post->status}}</small></p>
                                             <hr> 
                                            @if(isset($post->reply->id))
                                                @can('is_editor')
                                                    <div id="links">
                                                        <a id="a-editar" href="{{ action('ReplyController@formEdit', $post->reply->id)}}" class="btn btn-sm">Editar </a> 
                                                        <a id="a-remover" href="{{ action('ReplyController@delete',$post->reply->id)}}" class=" btn btn-sm"> Remover </a>    
                                                    </div>
                                                @endcan
                                                <div class="col-md-9">
                                                  <small><b class="text-info">{{$post->reply->user->name}}</b> em <b> {{\Carbon\Carbon::parse($post->reply->created_at)->format('d-m-y')}}</b> </br> {{ $post->reply->reply }} </small>  
                                                </div>
                                            @else
                                                @can('is_editor')
                                                  <form action="/admin/reply/{{$post->id}}" method="POST" class="form form-inline">
                                                    @csrf
                                                      <input type="hidden" name="post_id" value="{{$post->id}}">
                                                      <div class="input-group col-12">
                                                         <input type="text" name="reply" class="form-control" placeholder="Resposta...">
                                                         <div class="input-group-append">
                                                             <button type="submit" class="btn btn-outline-info btn-sm">Responder</button>
                                                         </div> 
                                                      </div>
                                                  </form>
                                                @endcan
                                            @endif
                                        </div> <!-- fim card body -- >
                                    </div><!-- fim card -- >
                                @else
                                    <span class="alert bg-info text-white"><b>Não há publicações. Publique algo!</b></span
                                @endif
                            @endif
                            
                        </div>                      
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection

<style type="text/css">
    #img-post{
        width: 720px;
        height: 312px;
        position: relative;
    } 

    #links{
        position:relative;
        float: right;
    }

    #img_user_sm{
        width: 50px;
        height: 50px;
        margin-right: 5px;
    }

    #i_time, #i_local {
        margin-left: 5px;
        margin-right: 2px;
    }





</style>
