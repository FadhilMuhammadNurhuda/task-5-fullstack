<?php

use App\Http\Controllers\API\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/category', [CategoryController::class, 'index'])->middleware('auth:api');
    Route::post('/category/store', [CategoryController::class, 'store'])->middleware('auth:api');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->middleware('auth:api');
    Route::resource('category.posts', PostsController::class)->middleware('auth:api');
});
