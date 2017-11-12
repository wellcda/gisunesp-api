<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/teste', function (Request $request) {
    return '<img src="https://ffxiv.consolegameswiki.com/mediawiki/images/thumb/c/ca/Lalafell_plainsfolk.jpg/300px-Lalafell_plainsfolk.jpg">';
});

Route::middleware(['auth:api'])->group(function () {
	Route::post('/problema', 'ProblemaController@storeProblema');
	Route::post('/problema/{id}/confirmacao', 'ConfirmacaoController@storeConfirmacao');
	Route::get('/problema/{id}',  'ProblemaController@showProblema');
	Route::get('/problemas/usuario/{id}', 'ProblemaController@showProblemasPorUsuario');
	Route::delete('/problema/{id}', 'ProblemaController@destroy');
	Route::patch('/problema/{id}', 'ProblemaController@update');

	Route::post('/tipoproblema', 'TipoProblemaController@store');

	Route::get('/usuarios', 'UserController@index');
	Route::get('/usuarios/{id}', 'UserController@show');
	Route::delete('/usuarios/{id}', 'UserController@destroy');
	Route::patch('/usuarios/{id}', 'UserController@update');

	Route::get('/usuario/notificacoes', 'UserController@getNotificacoesNaoLidas');
});

Route::post('/usuarios', 'UserController@store');
Route::post('/login', 'LoginController@login');

Route::get('/problema/{id}', 'ProblemaController@showProblema');
Route::get('/problemas', 'ProblemaController@showProblemas');
Route::get('/problema/{id}/confirmacoes', 'ConfirmacaoController@showConfirmacaoPorProblema');

Route::get('/tipoproblema/{id}', 'TipoProblemaController@show');
Route::get('/tiposproblema', 'TipoProblemaController@index');