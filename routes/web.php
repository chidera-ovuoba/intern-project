<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
Route::post('/orders','App\Http\Controllers\OrderController@store');
