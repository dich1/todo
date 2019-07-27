<?php

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
    return view('index');
});

Route::get('/mypage', function () {
    return view('auth/mypage');
});

Route::get('/create', function () {
    return view('create');
});

Route::get('/edit', function () {
    return view('edit');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/password-reset-complete', function () {
    return view('password-reset-complete');
});

Route::get('/signup-complete', function () {
    return view('signup-complete');
});

Route::get('/signup-confirmation', function () {
    return view('signup-confirmation');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::put('/home/{user_id}', 'HomeController@update')->name('home.update');

Route::resource('commits', 'CommitController');
Route::resource('commitGroups', 'CommitGroupController', [
  'only' => ['destroy']
]);
