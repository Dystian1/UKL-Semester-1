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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function() {
    
    //petugas
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('user', 'UserController@index');
    Route::put('user/{id}', 'UserController@update'); //di www
    Route::delete('user/{id}', 'UserController@delete');

    Route::get('siswa', 'SiswaController@index');
    Route::get('siswa/{id}', 'SiswaController@show');
    Route::post('siswa', 'SiswaController@store');
    Route::put('siswa/{id}', 'SiswaController@update');
    Route::delete('siswa/{id}', 'SiswaController@destroy');

    Route::get('poin_siswa', 'PoinSiswaController@index');
    Route::get('poin_siswa/siswa/{id}', 'PoinSiswaController@detail');
    Route::post('poin', 'PoinSiswaController@store');
    Route::put('poin_siswa/{id}', 'PoinSiswaController@update');
    Route::delete('poin_siswa/{id}', 'PoinSiswaController@destroy');

    Route::get('pelanggaran', 'PelanggaranController@index');
    Route::get('pelanggaran/{id}', 'PelanggaranController@show');
    Route::post('pelanggaran', 'PelanggaranController@store');
    Route::put('pelanggaran/{id}', 'PelanggaranController@update');
    Route::delete('pelanggaran/{id}', 'PelanggaranController@destroy');

    Route::post('poin_siswa', 'PoinSiswaController@find');
    Route::get('dashboard/statistik', 'PoinSiswaController@dashboard');
});
