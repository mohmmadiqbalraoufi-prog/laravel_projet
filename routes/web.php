<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productcontroller;
use App\Http\Controllers\networkingcontroller;
use App\Http\Controllers\pricingcontroller;
use App\Http\Controllers\Securitycontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\VirtualMachinescontroller;
use App\Http\Controllers\storagecontroller;
use App\Http\Controllers\userscontroller;


// Route::get('/', function () {
//     return view('welcome');


// });
// Route::get('auth/login', function () {
//            return view('auth.login');
// });

Route::get('layouts/app', function () {
           return view('layouts.app');
});
Route::get('/', function () {
           return view('home');
});
Route::get('layouts/homepage', function () {
           return view('layouts.homepage');
});
Route::get('layouts/dashboard', function () {
           return view('layouts.dashboard');
});
//Route::get('/post','postcontroller@index');
Route::get('layouts/products', function () {
           return view('layouts.products');
});
Route::get('layouts/createproduct', function () {
           return view('layouts.createproduct');
});
Route::get('layouts/Networking', function () {
           return view('layouts.Networking');
});
Route::get('layouts/pricing', function () {
           return view('layouts.pricing');
});
Route::get('layouts/Security', function () {
           return view('layouts.Security');
});
Route::get('layouts/VirtualMachines', function () {
           return view('layouts.VirtualMachines');
});
Route::get('layouts/Storage', function () {
           return view('layouts.Storage');
});

Route::get('layouts/users', function () {
           return view('layouts.users');
});

//Route::get('/studnt',[namof cont::class,'index']);
Route::get('/products',[productcontroller::class,'index']);
Route::get('/Networking',[networkingcontroller::class,'index']);
Route::get('/pricing',[pricingcontroller::class,'index']);
Route::get('/Security',[Securitycontroller::class,'index']);
Route::get('/dashboard',[dashboardcontroller::class,'index']);
Route::get('/vm',[VirtualMachinescontroller::class,'index']);
Route::get('/storage',[storagecontroller::class,'index']);
Route::get('/users',[userscontroller::class,'index']);