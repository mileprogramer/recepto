<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;

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

Route::get("/search", [RecipeController::class, 'search']);

// REGISTER 
Route::get("/register",[RegisterController::class, 'create']);
Route::post("/register",[RegisterController::class, 'store']);

// LOGIN 
Route::get("/login", [LoginController::class, 'loginView'])->name("login");
Route::post("/login", [LoginController::class, 'login']);

// LOGOUT
Route::get("/logout", [LoginController::class, 'logout']);

Route::middleware(['admin'])->group(function () {
    Route::view('/admin', 'admin.index');
    Route::get('/admin/approved-recipes', [RecipeController::class, "approvedRecipes"]);
    Route::get('/admin/not-approved-recipes', [RecipeController::class, "notApprovedRecipes"]);
    Route::get('/admin/not-approved-recipes/approve/{id}', [RecipeController::class, "approve"]);
    Route::get('/admin/recipe/delete/{id}', [RecipeController::class, "destroy"]);
    Route::get('/admin/recipe/edit/{id}', [RecipeController::class, "edit"]);
    Route::post('/admin/edit-recipe', [RecipeController::class, "update"]);
    Route::get("/add-recipe", [RecipeController::class, "create"]);
    Route::post("/add-recipe", [RecipeController::class, "store"]);
});




