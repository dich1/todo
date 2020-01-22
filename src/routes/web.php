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
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('index');
});

Route::get('/verify', function(){
    return view('auth.verify');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::put('/home/{user_id}', 'HomeController@update')->name('home.update');
Route::delete('/unsubscribe/{user_id}', 'HomeController@unsubscribe')->name('home.unsubscribe');
Route::post('/home/get-more-commit', 'HomeController@getMoreCommit');

Route::resource('commits', 'CommitController', [
  'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']
]);

Route::resource('commitGroups', 'CommitGroupController', [
  'only' => ['destroy']
]);

Route::resource('commits', 'CommitController', [
  'only' => ['show']
]);

Route::get('/terms', function(){
    return view('terms');
});

Route::get('/privacy', function(){
    return view('privacy');
});