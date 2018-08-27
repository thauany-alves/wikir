@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">{{$endereco->cidade}} - {{$endereco->uf}}</li>
                              </ol>
                            </nav>
                        </div>

                        <div class="col-md-3">
                            <a href="{{route('map')}}" class="btn btn-danger btn-lg col-12"><i class="fas fa-map-marked-alt" style="size: 5x;"></i> Mapa </a>
                            </br>
                        </div> 

                        <div class="col-md-3">
                            <a href="{{route('new.post')}}" class="btn btn-danger btn-lg col-12"><i class="fas fa-plus-square" style="size: 5x;"></i> Publicar</a>
                            </br>
                        </div>   
                    </div>
                    <hr>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    </br>

                    <div><!-- cards -->
                        @can('is_editor')
                        <div class="row">

                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-warning">
                                    <div class="card-header"><b><a href="" class="card-link" style="color: white;"> Publicações </a></b></div>
                                    <div class="card-body">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="card-text">Publicações em {{auth()->user()->endereco->cidade}}.</p>
                                        
                                    </div>
                                    <div class="card-footer"><a href="{{route('posts')}}" class="card-link" style="color: white;" > <b>Visualizar</b> <i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>
                            
                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-primary" >
                                    <div class="card-header"><b><a href="" class="card-link" style="color: white;"> Gestão de Publicações </a></b></div>
                                    <div class="card-body">
                                        <i class="fas fa-th-list"></i>
                                        <p class="card-text">Gestão de publicações.</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('g.posts')}}" class="card-link" style="color: white;" > <b>Gerenciar</b> <i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>

                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-success">
                                    <div class="card-header"><a><b>Categorias</b></a></div>
                                    <div class="card-body">
                                        <i class="fas fa-archive"></i>
                                        <p class="card-text">Gestão de categorias</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('categoria')}}" class="card-link" style="color: white;"><b>Visualizar </b> <i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>
                        </div>
                        </br>
                           
                        <div class="row">
                            
                            @can('is_admin')
                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-danger">
                                    <div class="card-header"><a > <b> Usuários </b> </a></div>
                                    <div class="card-body">
                                        <i class="fas fa-users"></i>
                                       <p class="card-text">Gestão de Usuarios</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('users')}}" class="card-link" style="color: white;"><b>Visualizar </b><i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>
                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-info">
                                    <div class="card-header"><a > <b> Editores </b> </a></div>
                                    <div class="card-body">
                                        <i class="fas fa-users"></i>
                                       <p class="card-text">Gestão de Editores </p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('editores')}}" class="card-link" style="color: white;"><b>Visualizar </b><i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>

                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-secondary">
                                    <div class="card-header"><a > <b> Administradores </b> </a></div>
                                    <div class="card-body">
                                        <i class="fas fa-users"></i>
                                       <p class="card-text">Gestão de Administradores</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('admins')}}" class="card-link" style="color: white;"><b>Visualizar </b><i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>
                            @endcan
                        </div>  
                            
                        @else
                        <div class="row">
                           <div class="col-md-4" id="cards">
                                <div class="card text-white bg-primary">
                                    <div class="card-header"><b>Meus Posts</b></div>
                                    <div class="card-body">
                                        <p class="card-text">Visualize suas publicações e respostas do editor.</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('posts.user')}}" class="card-link" style="color: white;"> <b>Visualizar</b> <i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>
                            
                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-success">
                                    <div class="card-header"><b>Posts de {{$endereco->cidade}}</b></div>
                                    <div class="card-body">
                                        <p class="card-text">Veja os problemas a cerca {{$endereco->cidade}} e ajude fiscalizando!</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('posts')}}" class="card-link" style="color: white;"><b>Visualizar </b> <i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div>
                            
                            <div class="col-md-4" id="cards">
                                <div class="card text-white bg-danger">
                                    <div class="card-header"><b>Meu perfil</b></div>
                                    <div class="card-body">
                                       <p class="card-text">Verificar informações de perfil e editar informações</p>
                                    </div>
                                    <div class="card-footer"><a href="{{route('perfil')}}" class="card-link" style="color: white;"><b>Visualizar </b><i class="fas fa-angle-double-right"></i></a></div>
                                </div>
                            </div> 
                        </div>
                            
                        @endcan
                    </div><!-- cards -->
                    
                    
                 </div>   
            </div>
        </div>
    </div><!--fim linha principal-->
</div><!-- fim container-->
@endsection

<style type="text/css">
    i{
        position: relative;
        float: right;
        font-size: 20px;
    }

    #cards{
        margin-bottom: 15px;
    }
</style>
