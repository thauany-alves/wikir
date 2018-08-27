<?php

namespace App\Http\Controllers;

use Request;
use Mapper;
use App\Models\Post;

class MapController extends Controller
{
    

	public function index(){
	
		Mapper::map(-15.827033,-47.922090000000026, ['zoom' => 4, 'marker' => false]);



		//carrega a localização dos problemas cadastrados
		$post = new Post();
		$posts = $post->list();

		foreach ($posts as $p) {
			Mapper::informationWindow($p->latitude, $p->longitude, 
				"<i class='fas fa-tag'></i> {$p->nome} </br> </br>
				<i class='fas fa-map-marker-alt'></i> {$p->address}" );
		}
		
		return view('map');
	}

	

}
