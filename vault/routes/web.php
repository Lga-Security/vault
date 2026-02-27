<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcomeblade', function () {
    return view('welcome');
});
