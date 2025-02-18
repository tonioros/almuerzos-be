<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeIngredientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/order', [OrderController::class, 'index']);
Route::get('/recipe', [RecipeController::class, 'index']);
Route::get('/recipe-ingredient', [RecipeIngredientController::class, 'index']);
Route::post('/order', [OrderController::class, 'startANewOrder']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
