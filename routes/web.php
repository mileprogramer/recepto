<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
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

Route::get("/add-recipe", [RecipeController::class, "create"]);
Route::post("/add-recipe", [RecipeController::class, "store"]);

// REGISTER 
Route::get("/register",[RegisterController::class, 'create']);
Route::post("/register",[RegisterController::class, 'store']);

// LOGIN 
Route::get("/login", [LoginController::class, 'loginView']);
Route::post("/login", [LoginController::class, 'login']);

// LOGOUT
Route::get("/logout", [LoginController::class, 'logout']);

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
    Route::get('/admin/not-approved-recipes', function () {
        return view('admin.index');
    });
    Route::get('/admin/approved-recipes', function () {
        return view('admin.index');
    });
});


// ADMIN
Route::get("/admin", function(){
    return view("admin.index");
});

Route::get("/admin/not-approved-recipes", function(){
    return view("admin.index");
});

Route::get("/admin/approved-recipes", function(){
    return view("admin.index");
});