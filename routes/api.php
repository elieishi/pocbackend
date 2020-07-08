<?php

use Illuminate\Support\Facades\Route;

Route::post('/users', 'UsersController@store');
Route::post('/login', 'UsersController@login');

Route::middleware('auth:api')->group(function(){
    Route::post('/listings', 'ListingsController@store');
    Route::get('/listings/me', 'ListingsController@me');
});

Route::get('/listings', 'ListingsController@index');
