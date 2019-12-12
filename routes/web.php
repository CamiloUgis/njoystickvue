<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido/contenido');
});

Route::get('/nuevoreferido', 'SocioController@agregar');
Route::get('/puntos', 'TransaccionController@viewPuntos');
Route::get('/listatransacciones', 'TransaccionController@lista');
Route::get('/listasocios','SocioController@lista');
Route::get('/equipo/{idSocios}', 'SocioController@equipo');
Route::post('/equipo/{idSocios}', 'SocioController@team');

Route::post('/nuevoreferido','SocioController@store');
Route::post('/puntos', 'TransaccionController@asignapuntos') ;
Route::get('/actualizareferido/{idSocios}','SocioController@actualizar');
Route::post('/actualizareferido/{idSocios}','SocioController@update');

Route::get('/generos','GeneroController@index');
Route::post('generos/registrar', 'GeneroController@store');
Route::put('generos/actualizar','GeneroController@update');

Route::get('/plataformas','PlataformaController@index');
Route::post('/plataformas/registrar', 'PlataformaController@store');
Route::put('/plataformas/actualizar','PlataformaController@update');
Route::get('/plataformas/selectPlataformas','PlataformaController@selectPlataformas');


Route::get('/productos','ProductoController@index');
Route::post('/productos/registrar', 'ProductoController@store');
Route::put('/productos/actualizar','ProductoController@update');

Route::get('/listaclientes','ClienteController@lista');
Route::get('/nuevocliente', 'ClienteController@agregar');
Route::post('/nuevocliente','ClienteController@store');
Route::get('/cliente/{idClientes}', 'ClienteController@datos');


Route::get('/inicio', function () {
    return view('main');
});