<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthenticationController;

// Route::get('/', function () {
//     $usersXuong1 = DB::connection('mysql')->table('users')->get();

//     $usersXuong2 = DB::connection('mysql2_connection')->table('users')->get();
//     dd($usersXuong1, $usersXuong2);
// });
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/post-login', [AuthenticationController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('/post-register', [AuthenticationController::class, 'postRegister'])->name('postRegister');


// http://127.0.0.1:8000/admin/products/update-products
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth' // Bảo vệ route admin, yêu cầu đăng nhập
],  function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Quản lý brand
    Route::group([
        'prefix' => 'brands',
        'as' => 'brands.'
    ], function () {
        Route::get('/', [BrandController::class, 'listBrand'])->name('listBrand');
        Route::get('/add-brand', [BrandController::class, 'addBrand'])->name('addBrand');
        Route::post('/add-brand', [BrandController::class, 'addPostBrand'])->name('addPostBrand');
        Route::get('/update-brand/{id}', [BrandController::class, 'updateBrand'])->name('updateBrand');
        Route::patch('/update-brand/{idBrand}', [BrandController::class, 'updatePatchBrand'])->name('updatePatchBrand');
        Route::delete('/delete-brand', [BrandController::class, 'deleteBrand'])->name('deleteBrand');
        Route::get('/detail-brand/{idBrand}', [BrandController::class, 'detailBrand'])->name('detailBrand');
    });

    // Quản lý sản phẩm
    Route::group([
        'prefix' => 'products',
        'as' => 'products.'
    ], function () {
        Route::get('/', [ProductController::class, 'listProduct'])->name('listProduct');
        Route::get('/add-product', [ProductController::class, 'addProduct'])->name('addProduct');
        Route::post('/add-product', [ProductController::class, 'addPostProduct'])->name('addPostProduct');
        Route::get('/detail-product/{idProduct}', [ProductController::class, 'detailProduct'])->name('detailProduct');
        Route::delete('/delete-product', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
        Route::get('update-product/{idProduct}', [ProductController::class, 'updateProduct'])->name('updateProduct');
        Route::patch('update-product/{idProduct}', [ProductController::class, 'updatePatchProduct'])->name('updatePatchProduct');
    });
});
