<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/test', function () {
    return view('test');
});

Route::middleware('guest')->group(function () {
    Route::get('/welcome',function(){
        return view('welcome');
    });
});

Route::middleware('auth')->group(function () {

});
