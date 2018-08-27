
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registre seu endereço!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}   
                        </div>
                    @endif
                    @if(isset($endereco->id))
                        <form method="POST" action="\endereco-create">
                    @else
                        <form method="POST" action="{{route('create.endereco')}}"> 
                    @endif

                        @csrf

                        <div class="form-group row">
                            <label for="logradouro" class="col-md-4 col-form-label text-md-right">Logradouro</label>

                            <div class="col-md-6">
                                <input id="logradouro" type="text" class="form-control" name="logradouro" value="{{ old('logradouro') }}" required autofocus> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bairro" class="col-md-4 col-form-label text-md-right">Bairro</label>

                            <div class="col-md-6">
                                <input id="bairro" type="text" class="form-control" name="bairro" value="{{ old('bairro') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cep" class="col-md-4 col-form-label text-md-right">CEP</label>

                            <div class="col-md-6">
                                <input id="cep" type="text" class="form-control" name="cep" value="{{ old('cep') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cidade" class="col-md-4 col-form-label text-md-right">Cidade</label>

                            <div class="col-md-6">
                                <input id="cidade" type="text" class="form-control" name="cidade" value="{{ old('cidade') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="uf" class="col-md-4 col-form-label text-md-right">UF</label>

                            <div class="col-md-6">
                                <input id="uf" type="text" class="form-control" name="uf" value="{{ old('estado') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Registra
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
