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

Route::get('/main', function () {
    return view('contenido/contenido');
})->name('main');

// Route::get('/nuevoreferido', 'SocioController@agregar');
// Route::get('/puntos', 'TransaccionController@viewPuntos');
// Route::get('/listatransacciones', 'TransaccionController@lista');
// Route::get('/listasocios','SocioController@lista');
// Route::get('/equipo/{idSocios}', 'SocioController@equipo');
// Route::post('/equipo/{idSocios}', 'SocioController@team');

// Route::post('/nuevoreferido','SocioController@store');
// Route::post('/puntos', 'TransaccionController@asignapuntos') ;
// Route::get('/actualizareferido/{idSocios}','SocioController@actualizar');
// Route::post('/actualizareferido/{idSocios}','SocioController@update');

Route::get('/generos','GeneroController@index');
Route::post('generos/registrar', 'GeneroController@store');
Route::put('generos/actualizar','GeneroController@update');
Route::get('/generos/selectGeneros','GeneroController@selectGeneros');

Route::get('/plataformas','PlataformaController@index');
Route::post('/plataformas/registrar', 'PlataformaController@store');
Route::put('/plataformas/actualizar','PlataformaController@update');
Route::get('/plataformas/selectPlataformas','PlataformaController@selectPlataformas');
Route::get('/plataformas/countJuegos','PlataformaController@countJuegos');


Route::get('/productos','ProductoController@index');
Route::post('/productos/registrar', 'ProductoController@store');
Route::put('/productos/actualizar','ProductoController@update');
Route::post('/productos/asociarGenero','ProductoController@asociar');
Route::get('/productos/buscarProducto','ProductoController@buscarProducto');
Route::get('/productos/transaccionProducto','ProductoController@transaccionProducto');
Route::get('/productos/selectProducto','ProductoController@selectProducto');
Route::get('/productos/muestraGeneros','ProductoController@muestraGeneros');




Route::get('/clientes','ClienteController@index');
Route::post('/clientes/registrar','ClienteController@store');
Route::put('/clientes/actualizar', 'ClienteController@update');
Route::get('/clientes/selectClientes','ClienteController@selectClientes');
Route::get('/clientes/transaccionClientes','ClienteController@transaccionClientes');
Route::get('/clientes/selectCliente2','ClienteController@selectCliente2');




Route::get('/socios','SocioController@index');
Route::post('/socios/registrar','SocioController@store');
Route::put('/socios/actualizar', 'SocioController@update');
Route::get('/socios/equipo','SocioController@equipo');
Route::get('/socios/selectSocio','SocioController@selectSocio');
Route::get('/socios/verSocio','SocioController@verSocio');
Route::get('/socios/obtenerTransacciones','SocioController@obtenerTransacciones');


Route::get('/roles','RolController@index');
Route::get('/roles/selectRoles','RolController@selectRoles');


Route::get('/transacciones','TransaccionController@index');
Route::post('/transacciones/registrar','TransaccionController@store');
Route::put('/transacciones/actualizar', 'TransaccionController@update');
Route::get('/transacciones/selectTransaccion','TransaccionController@selectTransaccion');
Route::get('/transacciones/obtenerCabecera','TransaccionController@obtenerCabecera');
Route::get('/transacciones/obtenerDetalles','TransaccionController@obtenerDetalles');
Route::get('/transaccionesVentas','TransaccionController@indexVentas');
Route::get('/transaccionesArriendos','TransaccionController@indexArriendos');
Route::get('/transaccionesCanjes','TransaccionController@indexCanjes');
Route::get('/transaccionesReservas','TransaccionController@indexReservas');
Route::get('/transaccionesVentas/recomendar','TransaccionController@recomendar');




Route::get('/usuarios','UserController@index');
Route::post('/usuarios/registrar','UserController@store');


/*Route::get('/inicio', function () {
    return view('main');
});*/



Route::get('/', 'Auth\LoginController@showLoginForm')->name('/');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');




Route::get('/home', 'HomeController@index')->name('home');
