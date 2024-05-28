<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Auth\Recaller;
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

Route::get('/', [RecipeController::class, "index"]);

Route::get("/add-recipe", [RecipeController::class, "create"]);
Route::post("/add-recipe", [RecipeController::class, "store"]);

Route::post("/search", [RecipeController::class, 'search']);

// REGISTER 
Route::get("/register",[RegisterController::class, 'create']);
Route::post("/register",[RegisterController::class, 'store']);

// LOGIN 
Route::get("/login", [LoginController::class, 'loginView']);
Route::post("/login", [LoginController::class, 'login']);

// LOGOUT
Route::get("/logout", [LoginController::class, 'logout']);

// ADMIN
Route::get("/admin", function(){
    return view("admin.index");
});

Route::get('/admin/approved-recipes', [RecipeController::class, "approvedRecipes"]);
Route::get('/admin/not-approved-recipes', [RecipeController::class, "notApprovedRecipes"]);
Route::get('/admin/not-approved-recipes/approve/{id}', [RecipeController::class, "approve"]);
Route::get('/admin/recipe/delete/{id}', [RecipeController::class, "destroy"]);
Route::get('/admin/recipe/edit/{id}', [RecipeController::class, "edit"]);
Route::post('/admin/recipe/edit/', [RecipeController::class, "update"]);
/* 
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
    Route::get('/admin/not-approved-recipes', function () {
        return view('admin.approved-recipes');
    });

}); */




