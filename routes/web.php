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
// Route::resource('/sub_kriteria','App\Http\Controllers\SubKriteriaController');




Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => ['auth']], function() { 
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
});

Route::group(['middleware' => ['auth', 'role:user']], function() { 
    
    Route::resource('/penilaian','App\Http\Controllers\PenilaianController');
    Route::get('/penilaian/index/{id}','App\Http\Controllers\PenilaianController@index')->name('penilaian.index');
    Route::get('/penilaian/{id}/create','App\Http\Controllers\PenilaianController@create')->name('penilaian.create');
    Route::put('/penilaian/store/{id}','App\Http\Controllers\PenilaianController@store')->name('penilaian.store');
});


Route::group(['middleware' => ['auth', 'role:manajer']], function() { 
    // Route::get('/dashboard/myprofile', 'App\Http\Controllers\DashboardController@myprofile')->name('dashboard.myprofile');

    
    Route::resource('/kriteria','App\Http\Controllers\KriteriaController');
    Route::get('/kriteria/create', 'App\Http\Controllers\KriteriaController@create')->name('kriteria.create');
    // Route::put('/kriteria/show/{$id_kriteria}', 'App\Http\Controllers\KriteriaController@show')->name('kriteria.show');
    // Route::get('/kriteria/show/{$id_kriteria}', function($id_kriteria){
    //     return "dsadas";
    // })->name('kriteria.show');
    Route::resource('/kontrak','App\Http\Controllers\KontrakController');
    Route::get('/kontrak/{id}/create','App\Http\Controllers\KontrakController@create')->name('kontrak.create');
    Route::put('/kontrak/{id}/store','App\Http\Controllers\KontrakController@store')->name('kontrak.store');

    Route::resource('/pekerjaan_karyawan','App\Http\Controllers\PekerjaanController');
    Route::get('/pekerjaan_karyawan/create/{id}','App\Http\Controllers\PekerjaanController@create')->name('pekerjaan_karyawan.create');
    Route::post('/pekerjaan_karyawan/store/{id}','App\Http\Controllers\PekerjaanController@store')->name('pekerjaan_karyawan.store');
 
    Route::resource('/perusahaan','App\Http\Controllers\PerusahaanController');

    Route::resource('/karyawan','App\Http\Controllers\KaryawanController');
    Route::get('/karyawan/create', 'App\Http\Controllers\KaryawanController@create')->name('karyawan.create');

    // Route::get('/pekerjaankaryawan/create', 'App\Http\Controllers\PekerjaanKaryawanController@create')->name('pekerjaan_karyawan.create');

    Route::resource('/user','App\Http\Controllers\UserController')->except(['show','create']);
    Route::get('/user/create', 'App\Http\Controllers\UserController@create')->name('user.create');

    Route::resource('/sub_kriteria','App\Http\Controllers\SubKriteriaController');
    Route::get('/sub_kriteria/{id}','App\Http\Controllers\SubKriteriaController@show')->name('sub_kriteria.show');
    Route::get('/sub_kriteria/create/{id}','App\Http\Controllers\SubKriteriaController@create')->name('sub_kriteria.create');
    Route::put('/sub_kriteria/masukan/{id}','App\Http\Controllers\SubKriteriaController@masukandata')->name('sub_kriteria.masukandata');
    // Route::get('/sub_kriteria','App\Http\Controllers\SubKriteriaController@show');
    
    // Route::get('/sub_kriteria/create/{$id}','App\Http\Controllers\SubKriteriaController@create')->name('sub_kriteria.create');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
