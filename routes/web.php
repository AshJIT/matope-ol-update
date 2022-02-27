<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/kin/view/{slug}', 'App\Http\Controllers\KinController@show');
Route::get('/owner/{slug}', 'App\Http\Controllers\OwnerController@index');
Route::get('/colorist/{slug}', 'App\Http\Controllers\ColoristController@index');
Route::get('/', 'App\Http\Controllers\SearchController@index');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', function() {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('admin/kin/create', 'App\Http\Controllers\KinController@create')->name('admin.kin.create');
    Route::get('admin/kin/edit/{id}', 'App\Http\Controllers\KinController@edit')->name('admin.kin.edit');

    Route::get('admin/familiar/create', 'App\Http\Controllers\FamiliarController@create')->name('admin.familiar.create');

    Route::get('admin/kin/list', 'App\Http\Controllers\KinController@list')->name('admin.kin.list');
    Route::post('admin/kin/store', 'App\Http\Controllers\KinController@store')->name('admin.kin.store');
    Route::put('admin/kin/update/{kin}', 'App\Http\Controllers\KinController@update')->name('admin.kin.update');

    Route::post('admin/familiar/store', 'App\Http\Controllers\FamiliarController@store')->name('admin.familiar.store');
});
    

