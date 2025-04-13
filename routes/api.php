<?php
// khai báo API

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;

// CRUD () => REST API
Route::post('/register', [AuthenController::class, 'postRegister']);
Route::post('/login', [AuthenController::class, 'postLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $req) {
        return response()->json($req->user());
    });

    Route::delete('/logout', [AuthenController::class, 'logout']);
});
// Products API
// http://127.0.0.1:8000/api/products/
Route::prefix('products')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/add', [ProductController::class, 'store']);
    Route::patch('update/{id}', [ProductController::class, 'update']);
    Route::delete('delete/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('categories')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/add', [CategoryController::class, 'store']);
    Route::patch('update/{id}', [CategoryController::class, 'update']);
    Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
});
