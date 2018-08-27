<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mapper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $endereco = auth()->user()->endereco()->first();

        /*$aux = $endereco->cidade.' '.$endereco->uf;

        $location = Mapper::location($aux);
        $longitude = str_replace(',','.', $location->getLongitude());
        $latitude = str_replace(',','.', $location->getLatitude());
        Mapper::map($latitude, $longitude, ['zoom' => 13, 'maker' =>false]);*/
        return view('home', compact('endereco')); 
    }
}
