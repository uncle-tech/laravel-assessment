<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::apiResource('tours', 'api\ToursController');

Route::get('tours', 'api\ToursController@index');
Route::post('tours', 'api\ToursController@store');
Route::get('tours/{tour}', 'api\ToursController@show');
Route::put('tours/{tour}', 'api\ToursController@update');
Route::delete('tours/{tour}', 'api\ToursController@destroy');

// Route::get('tours/price[{operator}]={value}', 'api\ToursController@filter');
