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
    return view('auth.login');
});
Route::group(['middleware' => ['auth']], function() { 
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
});
Route::group(['middleware' => ['auth', 'role:manajer']], function() { 
    // Route::get('/dashboard/myprofile', 'App\Http\Controllers\DashboardController@myprofile')->name('dashboard.myprofile');
    Route::resource('/kriteria','App\Http\Controllers\KriteriaController')->except(['show','create']);
    Route::get('/kriteria/create', 'App\Http\Controllers\KriteriaController@create')->name('kriteria.create');


    Route::resource('/karyawan','App\Http\Controllers\KaryawanController')->except(['show','create']);
    Route::get('/karyawan/create', 'App\Http\Controllers\KaryawanController@create')->name('karyawan.create');

});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
