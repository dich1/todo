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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::put('/home/{user_id}', 'HomeController@update')->name('home.update');

Route::resource('commits', 'CommitController');
Route::resource('commitGroups', 'CommitGroupController', [
  'only' => ['destroy']
]);

Route::get('new-mail', function () {
    return (new App\Notifications\CustomVerifyEmail())
                ->toMail('宛先');
});
