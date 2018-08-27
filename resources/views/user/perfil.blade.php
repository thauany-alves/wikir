
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">

                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Perfil</li>
                      </ol>
                    </nav>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}   
                        </div>
                    @endif
                    @include('includes.alerts')

                    <div id="info_user" class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label id="nome_user"><b>{{auth()->user()->name}}</b></label></br>
                                    <label id="email_user">{{auth()->user()->email}}</label></br></br></br> 
                                </div>
                                <div class="col-md-6">
                                    @if($img != 'blank.png')
                                        <img src="{{asset('storage/users/'.$img)}}"></br>
                                    @else
                                        <img src="{{asset('img/blank.png')}}"></br>
                                    @endif
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#editProfileModal">Editar perfil</button>
                                </div>
                            </div>
                            
                        </div>                        
                    </div>

                    </br>

                    <div id="endereco_user" class="card">
                        <div class="card-body">
                            <h4 class="card-title">Endereço</h4>
                            <label id="logradouro">{{$endereco->logradouro}}</label></br>
                            <label id="Bairro">{{$endereco->bairro}}</label></br>
                            <label id="cidade">{{$endereco->cep}}  {{$endereco->cidade}} - {{$endereco->uf}}</label></br>
                            <button data-toggle="modal" data-target="#editEnderecoModal" class="btn btn-default"> Editar endereço</button> 
                        </div>
                        
                    </div> 
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editProfileModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edição de perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('edit.perfil')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="nome" class="col-md-2 col-form-label text-md-right">Nome</label>

                <div class="col-md-10">
                    <input class="form-control" type="text" name="name" value="{{auth()->user()->name}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="imagem" class="col-md-2 col-form-label text-md-right">Imagem</label>

                <div class="col-md-10">
                    <input class="form-control" type="file" name="avatar" required>
                </div>
            </div>
            <div class="buttons">
                <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div id="editEnderecoModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edição de endereço</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('update.endereco')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="logradouro" class="col-md-2 col-form-label text-md-right">Endereco</label>

                <div class="col-md-10">
                    <input class="form-control" type="text" name="logradouro" value="{{$endereco->logradouro}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="bairro" class="col-md-2 col-form-label text-md-right">Bairro</label>

                <div class="col-md-10">
                    <input class="form-control" type="text" name="bairro" value="{{$endereco->bairro}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="cep" class="col-md-2 col-form-label text-md-right">CEP</label>

                <div class="col-md-10">
                    <input class="form-control" type="text" name="cep"  value="{{$endereco->cep}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="cidade" class="col-md-2 col-form-label text-md-right">Cidade</label>

                <div class="col-md-10">
                    <input class="form-control" type="text" name="cidade"  value="{{$endereco->cidade}}" required>
                </div>
            </div>
             <div class="form-group row">
                <label for="cidade" class="col-md-2 col-form-label text-md-right">UF</label>

                <div class="col-md-10">
                    <input class="form-control" type="text" name="uf"  value="{{$endereco->uf}}" required>
                </div>
            </div>
            <div class="buttons">
                <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </form>  
        
      </div>
    </div>
  </div>
</div>

@endsection

<style type="text/css">
    .buttons{
        float: right;
    }
    .buttons button{
        margin: 5px;
    }

    img{
        width: 180px;
        height: 180px;
    }
    .btn-default{
        margin-top: 10px;
        margin-right: 5px;
    }
</style>
