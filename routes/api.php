<?php
// khai báo API

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostCommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
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

Route::prefix('brands')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::get('/{id}', [BrandController::class, 'show']);
    Route::post('/add', [BrandController::class, 'store']);
    Route::patch('update/{id}', [BrandController::class, 'update']);
    Route::delete('delete/{id}', [BrandController::class, 'destroy']);
});

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::patch('update/{id}', [UserController::class, 'update']);
    Route::patch('toggle/{id}', [UserController::class, 'toggle']);
});

Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::post('/', [PostController::class, 'store']);
    Route::put('/{id}', [PostController::class, 'update']);
    Route::patch('/{id}', [PostController::class, 'update']);
    Route::delete('/{id}', [PostController::class, 'destroy']);
});

Route::prefix('postcomments')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PostCommentController::class, 'index']);
    Route::get('/{id}', [PostCommentController::class, 'show']);
    Route::post('/', [PostCommentController::class, 'store']);
    Route::put('/{id}', [PostCommentController::class, 'update']);
    Route::patch('/{id}', [PostCommentController::class, 'update']);
    Route::delete('/{id}', [PostCommentController::class, 'destroy']);
});
