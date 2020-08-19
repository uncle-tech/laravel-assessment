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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function (Request $request) {
    return ['pong' => true];
});

Route::get('/tours', 'TourController@all');
Route::get('/tours/?{key}{[operator]}={value}', 'TourController@all');
Route::get('/tours/?limit={limit}&offset={offset}', 'TourController@all');
Route::get('/tours/{id}', 'TourController@one');
Route::post('/tours', 'TourController@new');
Route::put('/tours/{id}', 'TourController@edit');
Route::delete('/tours/{id}', 'TourController@delete');
