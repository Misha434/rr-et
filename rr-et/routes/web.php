<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Whoops\Run;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/login/guest', 'Auth\LoginController@guestLogin');

Route::group(['middleware' => ['auth', 'can:general-user']], function () {
  Route::resource('scripts', 'ScriptController');
  Route::resource('categories', 'CategoryController');
  Route::get('/users/{id}', 'UserController@show')->name('users.show');
  Route::get('/users/{id}/edit', 'UserController@edit')->name('users.edit');
  Route::put('/users/{id}', 'UserController@update')->name('users.update');
  Route::group(['prefix'=>'scripts/{id}'],function(){
    Route::get('/like/store','likeController@store');
    Route::post('/like/store','likeController@store')->name('likes.store');
    Route::get('/like/store','likeController@destroy');
    Route::delete('/like/destroy','likeController@destroy')->name('likes.destroy');
  });
});

Route::group(['middleware' => ['auth', 'can:admin']], function () {
  Route::resource('categories', 'CategoryController', ['only' => ['create','store', 'edit', 'update', 'destroy']]);
});