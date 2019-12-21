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

Route::middleware('verified')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::put('/home/{user_id}', 'HomeController@update')->name('home.update');
    Route::delete('/unsubscribe/{user_id}', 'HomeController@unsubscribe')->name('home.unsubscribe');

    Route::resource('commits', 'CommitController', [
      'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']
    ]);

    Route::resource('commitGroups', 'CommitGroupController', [
      'only' => ['destroy']
    ]);
});

Route::resource('commits', 'CommitController', [
  'only' => ['show']
]);
