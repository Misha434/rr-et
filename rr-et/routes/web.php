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
  Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy');
  Route::get('/users/{id}/drafts', 'DraftController@index')->name('drafts.index');

  Route::group(['prefix'=>'scripts/{id}'],function(){
    Route::get('/like/store','LikeController@store');
    Route::post('/like/store','LikeController@store')->name('likes.store');
    Route::get('/like/store','LikeController@destroy');
    Route::delete('/like/destroy','LikeController@destroy')->name('likes.destroy');

    Route::get('/comments/store','CommentController@store');
    Route::post('/comments/store','CommentController@store')->name('comments.store');
    Route::get('/comments/destroy','CommentController@destroy');
    Route::delete('/comments/destroy','CommentController@destroy')->name('comments.destroy');
  });
});

Route::group(['middleware' => ['auth', 'can:admin']], function () {
  Route::resource('categories', 'CategoryController', ['only' => ['create','store', 'edit', 'update', 'destroy']]);
});