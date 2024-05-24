<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.home_page');
});

Route::get("/login", function(){
    return view("login.login_page");
});

Route::get("/register", function(){
    return view("register.register_page");
});

Route::get("/admin", function(){
    return view("admin.index");
});