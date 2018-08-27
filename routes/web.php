<?php



Route::get('/', function () {
    return view('welcome');
});




Auth::routes();

Route::middleware(['auth'])->group( function (){

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/home/map', 'MapController@index')->name('map');
	Route::get('/search_location', 'MapController@search')->name('search.mapa');

	//endereco
	Route::get('/endereco', 'EnderecoController@index')->name('endereco');
	Route::post('/endereco-create', 'EnderecoController@create')->name('create.endereco');
	Route::post('/endereco', 'EnderecoController@update')->name('update.endereco');
	//perfil
	Route::get('/perfil','UserController@perfil')->name('perfil');
	Route::post('/perfil','UserController@updateUser')->name('edit.perfil');

	//listagem de posts
	Route::get('/posts','PostController@posts')->name('posts');
	Route::get('/posts-user','PostController@postsUser')->name('posts.user');
	
	//criacao de post

	Route::get('/newpost','PostController@newPost')->name('new.post');
	Route::post('/newpost_store','PostController@postStore')->name('post.store');

	//edição de post
	Route::get('/post/edit/{id}','PostController@editPost')->name('postedit');
	Route::post('/post/edit/{id}','PostController@editPostStore')->name('postedit.store');

	//deleção de post
	Route::get('/posts/delete/{id}','PostController@delete')->name('del.post');
});

Route::middleware(['auth','can:is_editor'])->prefix('/admin')->group( function(){
	//gestão de categorias
	Route::get('categoria','CategoriaController@index')->name('categoria');
	Route::get('categoria/search','CategoriaController@search')->name('search.categoria');
	Route::get('categoria/new','CategoriaController@form')->name('form.categoria');
	Route::post('categoria/new','CategoriaController@create')->name('new.categoria');
	Route::get('categoria/update/{id}','CategoriaController@edit');
	Route::post('categoria/update/{id}','CategoriaController@update');
	Route::get('categoria/delete/{id}','CategoriaController@delete');

	//gestão de posts
	Route::get('/posts','PostController@allPosts')->name('g.posts');
	Route::get('/posts/search','PostController@search')->name('search.posts');
	Route::get('/post/details/{id}','PostController@getById');

	//respostas
	Route::post('/reply/{id}','ReplyController@store')->name('store.reply');
	Route::get('/reply/delete/{id}','ReplyController@delete');
	Route::get('/reply/edit/{id}','ReplyController@formEdit');
	Route::post('/reply/update/{id}','ReplyController@update');

});




Route::middleware(['auth','can:is_admin'])->prefix('/admin')->group( function(){
	//gestão de usuarios
	Route::get('/users','UserController@users')->name('users');
	Route::get('/users/search','UserController@search')->name('search.users');
	Route::get('/user/delete/{id}','UserController@delete')->name('del.user');
	Route::get('/user/new','UserController@formNew')->name('new.user');
	Route::post('/user/new','UserController@store')->name('store.user');
	Route::get('/user/edit/{id}','UserController@edit');
	Route::post('/user/edit/{id}','UserController@update');

	//gestão de editores 
	Route::get('/editores','UserController@editores')->name('editores');
	Route::get('/editores/search','UserController@searchEditor')->name('search.editores');
	//gestão de admins
	Route::get('/adms','UserController@admins')->name('admins');
	Route::get('/adms/search','UserController@searchAdm')->name('search.admins');
});

