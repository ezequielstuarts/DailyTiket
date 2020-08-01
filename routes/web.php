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

Route::get('getTikets/{id}', 'TiketController@getTikets');
Route::delete('deleteTiket/{id}', 'TiketController@destroy');

// Route::get('home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
