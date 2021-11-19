<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("/register", [UserController::class,"register"]);
Route::post("/login", [UserController::class,"login"]);
Route::post("/logout", [UserController::class,"logout"]);


Route::group(['middleware'=>'auth:sanctum'], function(){
    // Route::get('/todos', [TodoController::class,"index"]);
    // Route::post('/todos', [TodoController::class,"store"]);
    // Route::get('/todos/{id}', [TodoController::class,"show"]);
    // Route::put('/todos/{id}', [TodoController::class,"update"]);
    // Route::delete('/todos/{id}', [TodoController::class,"destroy"]);

    Route::resource('/todos', TodoController::class);
    Route::put('/update_completion/{id}', [TodoController::class,"toggleTaskCompletion"]);
});
