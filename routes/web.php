<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/orders','App\Http\Controllers\OrderController@store');
