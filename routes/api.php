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

Route::get('/tours', 'ToursController@readAll'); 
Route::get('/tours/{id}', 'ToursController@readById'); 
Route::post('/tours', 'ToursController@create');  
Route::put('/tours/{id}', 'ToursController@update'); 
Route::delete('/delete/{id}', 'ToursController@delete'); 