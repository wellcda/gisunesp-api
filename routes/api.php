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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/teste', function (Request $request) {
    return '<img src="https://ffxiv.consolegameswiki.com/mediawiki/images/thumb/c/ca/Lalafell_plainsfolk.jpg/300px-Lalafell_plainsfolk.jpg">';
});

Route::get('/problema/{id}', 				'ProblemaController@showProblema');
Route::get('/problemas', 					'ProblemaController@showProblemas');
Route::get('/problemas/usuario/{id}',		'ProblemaController@showProblemasPorUsuario');
Route::post('/problema', 					'ProblemaController@storeProblema');
Route::get('/problema/{id}/confirmacoes', 	'ConfirmacaoController@showConfirmacaoPorProblema');
Route::post('/problema/{id}/confirmacao', 	'ConfirmacaoController@storeConfirmacao');

Route::get('/tipoproblema/{id}', 	'TipoProblemaController@show');
Route::get('/tiposproblema', 		'TipoProblemaController@index');
Route::post('/tipoproblema', 		'TipoProblemaController@store');
