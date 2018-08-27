@extends('layouts.app')
@section('content')
        
<div class="content">
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4"><b>Colabore!</b><h1></br>
            <p class="lead">Ajude a fiscalizar! Informe problemas acerca da cidade. </p>
            <hr class="my-4">
            <p class="lead">Ajude a tornar sua cidade melhor informando problemas sobre pavimentações de ruas, rede de distribuição elétrica, saneamento básico e outros. </p>
            <p>
                @auth
                    <a class="btn btn-primary btn-lg" role="button" href="{{ url('/home') }}">Home</a>
                @else
                    <a class="btn btn-success btn-lg" role="button" href="{{ route('login') }}">Login</a>
                    <a  class="btn btn-success btn-lg" role="button" href="{{ route('register') }}">Cadastre-se</a>
                @endauth
            </p>
        </div>    
    </div>
</div>

<style type="text/css">
    .jumbotron{
        /*background-image: url({{asset('storage/jumbotron.png')}});

        */
    }
</style>

@endsection
