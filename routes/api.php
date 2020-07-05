<?php

use Illuminate\Support\Facades\Route;

Route::post('/users', 'UsersController@store');
Route::post('/login', 'UsersController@login');
