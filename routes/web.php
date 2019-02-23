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
    return view('welcome');
});

Route::get('/login', function () {
    return view('paginas.login');
});

Route::get('/backend', function () {
    return view('paginas.backend');
});

Route::get('/donantes', function () {
    return view('paginas.donantes');
});

Route::get('/donantes', 'donantesController@indexDonantes')->name('donantes');