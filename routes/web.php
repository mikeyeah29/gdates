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

Route::get('/gigs', 'GigsController@index')->name('gigs');
Route::post('/gigs', 'GigsController@store')->name('gigs.store');
Route::get('/gigs/add', 'GigsController@create')->name('gigs.create');
Route::delete('/gigs/{id}', 'GigsController@destroy')->name('gigs.destroy');

Route::get('/unavailable', 'UnavailableController@index')->name('unavailable');
Route::post('/unavailable', 'UnavailableController@store')->name('unavailable.store');
Route::get('/unavailable/add', 'UnavailableController@create')->name('unavailable.create');
Route::delete('/unavailable/{id}', 'UnavailableController@destroy')->name('unavailable.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');