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
                            <nav aria-label="breadcrumb ">
                              <ol class="breadcrumb ">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item active " aria-current="page">Mapa</li>
                              </ol>
                            </nav>
                        </div>

                        <div class="col-md-3">
                            <a href="{{route('home')}}" class="btn btn-danger btn-lg col-12"><i class="fas fa-map-marked-alt" style="size: 5x;"></i> Home </a>
                        </div> 
                        </br>
                        <div class="col-md-3">
                            <a href="{{route('new.post')}}" class="btn btn-danger btn-lg col-12"><i class="fas fa-plus-square" style="size: 5x;"></i> Publicar</a>
                        </div>   
                    </div>
                    <hr>

                    <div class="row">
                                
                        <div id="map" class="container">
                            {!! Mapper::render() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>     
    </div>
</div>
@endsection
<style type="text/css">
    #map{
        height: 55%;
    }

</style>
