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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/manage', [App\Http\Controllers\ManageController::class, 'index']);

Route::get('/manageEdit/{id}', [App\Http\Controllers\ManageController::class, 'edit']);
Route::get('/manageUpdate', [App\Http\Controllers\ManageController::class, 'update']);

Route::get('/manageAdd', [App\Http\Controllers\ManageController::class,'create']);
Route::get('/manageStore', [App\Http\Controllers\ManageController::class,'store']);

// Route::post('/manageAdd', [App\Http\Controllers\ManageController::class, 'create'])->name('create'); 

Route::get('/manageRemove/{id}', [App\Http\Controllers\ManageController::class, 'destroy']);