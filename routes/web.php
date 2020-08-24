<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Auth::routes();

Route::get('/', 'ClientController@index')->name('/');
Route::get('home', 'ClientController@index')->name('home');

Route::get('getClient/{id}', 'ClientController@getClient');

Route::get('getClients', 'ClientController@getClients')->name('getClients');

Route::post('clients', 'ClientController@store')->name('clients');

Route::delete('deleteClient/{id}', 'ClientController@destroy');

Route::get('getTikets/{id}', 'TiketController@getTikets');

Route::post('tikets', 'TiketController@store')->name('tikets');

Route::put('tikets/{id}', 'TiketController@update')->name('tikets');

Route::delete('deleteTiket/{id}', 'TiketController@destroy');

Route::delete('deleteAllTikets/{clientId}', 'TiketController@deleteAllTikets');

// Route::get('home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/imprimir/{id}', 'ClientController@print')->name('print');

Route::get('/pdf', function() {
$pdf = PDF::loadView('impresion.tiket');
return $pdf->stream();
});


