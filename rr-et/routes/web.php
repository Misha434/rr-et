<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
  Route::get('/users/{id}/edit', 'UserController@edit')->name('users.edit');
  Route::patch('/users/{id}/edit', 'UserController@update')->name('users.update');
});

Route::group(['middleware' => ['auth', 'can:admin']], function () {
  Route::resource('categories', 'CategoryController', ['only' => ['create','store', 'edit', 'update', 'destroy']]);
});