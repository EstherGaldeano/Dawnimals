<?php

//////////////////////////// PAGS FRONTEND ///////////////////////////////////
Route::redirect('/', 'landing');

Route::get('/landing', function () {
    return view('frontend.paginas.landing');
})->name("landing");
//////////////////////////// PAGS FRONTEND ///////////////////////////////////


// Route::get('backend/chgIdioma/{locale}', function ($locale) {
//     App::setLocale($locale);
// });


//////////////////////////// PAGS BACKEND ////////////////////////////////////
Route::get('/backend/login', 'Backend\AccountController@index');
Route::post('/backend/login', 'Backend\AccountController@login')->name("login");
Route::get('/backend/logout', 'Backend\AccountController@logout')->name("logout");

//Route::group(['middleware' => ['auth']], function () {
    Route::get('/backend', function () {
        return view('backend.paginas.backend');
    });

    Route::resource('/backend/donantes', 'Backend\DonanteController');
    Route::resource('/backend/donaciones', 'Backend\DonacionController');


    Route::resource("backend/mantenimientos/usuarios", "Backend\Mantenimientos\UsuariosController");

    Route::resource("backend/mantenimientos/perfiles", "Backend\Mantenimientos\PerfilesController");


//});
//////////////////////////// PAGS BACKEND ////////////////////////////////////
