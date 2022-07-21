<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentTypesCRUDController;
use App\Http\Controllers\ComponentsCRUDController;
use App\Http\Controllers\CaliperFamiliesCRUDController;
use App\Http\Controllers\CalipersCRUDController;

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
Route::resource('componentTypes', App\Http\Controllers\ComponentTypesCRUDController::class);
Route::resource('components', App\Http\Controllers\ComponentsCRUDController::class);
Route::resource('caliperFamilies', App\Http\Controllers\CaliperFamiliesCRUDController::class);
Route::resource('calipers', App\Http\Controllers\CalipersCRUDController::class);