<?php
// khai báo API

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenController;
use Illuminate\Http\Request;

// CRUD () => REST API

// Products API

Route::prefix('products')->middleware('auth:sanctum')->group(function () {
    // http://127.0.0.1:8000/api/products/
    Route::get('/', [ProductController::class, 'index']);
    // http://127.0.0.1:8000/api/products/1
    Route::get('/{id}', [ProductController::class, 'show']);
    // http://127.0.0.1:8000/api/products/add
    Route::post('/add', [ProductController::class, 'store']);
    // http://127.0.0.1:8000/api/products/update/1
    Route::patch('update/{id}', [ProductController::class, 'update']);
    // http://127.0.0.1:8000/api/products/delete/1
    Route::delete('delete/{id}', [ProductController::class, 'destroy']);
});

Route::post('/register', [AuthenController::class, 'postRegister']);
Route::post('/login', [AuthenController::class, 'postLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $req) {
        return response()->json($req->user());
    });

    Route::delete('/logout', [AuthenController::class, 'logout']);
});
