<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
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

class HelloWorld {

    public function __construct(Hello $hello)
    {

        $this->hello = $hello;

    }

};


class Hello{
    
    public function __construct(HelloWorld $helloWorld)
    {

        $this->hello = $helloWorld;

    }


}

// app()->bind('Hello', function(){

//     return new Hello(new HelloWorld);

// });

dd(resolve('HelloWorld'));


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/manage/{sort?}/{column?}', [App\Http\Controllers\ManageController::class, 'index']);

Route::get('/manageEdit/{id}/{sort?}/{column?}', [App\Http\Controllers\ManageController::class, 'edit'])->name('manageEdit');
Route::get('/manageUpdate', [App\Http\Controllers\ManageController::class, 'update']);

Route::get('/manageAdd', [App\Http\Controllers\ManageController::class,'create']);
Route::get('/manageStore', [App\Http\Controllers\ManageController::class,'store']);

// Route::post('/manageAdd', [App\Http\Controllers\ManageController::class, 'create'])->name('create'); 

Route::get('/manageRemove/{id}', [App\Http\Controllers\ManageController::class, 'destroy']);

// Posts

Route::get('/managePosts/{id}', [App\Http\Controllers\PostsController::class, 'create']);

Route::get('/createPost', [App\Http\Controllers\PostsController::class, 'store']);

// Route::get('/managePostsDestroy/{id}', [App\Http\Controllers\PostsController::class, 'destroy']);

Route::get('/managePostsDestroy/{id}/{id2}',[App\Http\Controllers\PostsController::class,'destroy']);

Route::get('/managePostsRestore/{id}/{id2}',[App\Http\Controllers\PostsController::class,'restore']);

Route::get('/managePostsEdit/{id}',[App\Http\Controllers\PostsController::class,'edit']);

Route::get('/updatePost',[App\Http\Controllers\PostsController::class,'update']);

Route::get('/manageRestore/{id}',[App\Http\Controllers\ManageController::class,'restore']);


// Posts Module
Route::get('/posts/{sort?}/{column?}',[App\Http\Controllers\AllPostsController::class,'index']);
Route::get('/allPostEdit/{id}/', [App\Http\Controllers\AllPostsController::class, 'edit'])->name('allPostEdit');

Route::get('/createAllPost',[App\Http\Controllers\AllPostsController::class,'create']);

Route::get('/storeAllPost',[App\Http\Controllers\AllPostsController::class,'store']);

Route::get('/updateAllPost',[App\Http\Controllers\AllPostsController::class,'update']);

Route::get('/allPostDestroy/{id}',[App\Http\Controllers\AllPostsController::class,'destroy']);

// Route::get('/sortDataEdit/{id}/{sort}/{column}',[App\Http\Controllers\ManageController::class,'edit'])->name('sortDataEdit');