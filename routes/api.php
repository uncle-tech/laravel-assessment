<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/tours', 'TourController@index')->name('all_tours');

Route::get('/tours/{id}', 'TourController@show')->name('get_tours');

Route::post('/tours', 'TourController@store')->name('create_tours');

Route::delete('/tours/{id}', 'TourController@destroy')->name('destroy_tours');

Route::put('/tours/{id}', 'TourController@update')->name('update_tours');
