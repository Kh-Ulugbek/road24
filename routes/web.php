<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test/{num}', [\App\Http\Controllers\TestController::class, 'test']);
Route::get('test-check', [\App\Http\Controllers\TestController::class, 'testCheck']);
