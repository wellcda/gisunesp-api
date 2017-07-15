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

Route::get('/problema', 'ProblemaController@show');
Route::post('/problema', 'ProblemaController@store');

Route::get('/tipoproblema', 'TipoProblemaController@show');
Route::post('/tipoproblema', 'TipoProblemaController@store');
