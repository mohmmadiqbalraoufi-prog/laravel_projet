<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');


// });
Route::get('auth/login', function () {
           return view('auth.login');
});