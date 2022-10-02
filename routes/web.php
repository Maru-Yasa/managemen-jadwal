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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'guru'], function(){
        Route::get('/', 'App\Http\Controllers\GuruController@view');
        Route::get('/{id}/delete', 'App\Http\Controllers\GuruController@delete')->name('delete_guru');
        Route::post('/edit', 'App\Http\Controllers\GuruController@edit')->name('edit_guru');
        Route::get('/get', 'App\Http\Controllers\GuruController@getAll')->name('get_guru');
        Route::post('/tambah', 'App\Http\Controllers\GuruController@tambah')->name("tambah_guru");
    });

    Route::group(['prefix' => 'jurusan'], function(){
        Route::get('/', 'App\Http\Controllers\JurusanController@view');
    });

});