<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostCommentController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Admin\UserController;

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

    // Quản lý user
    Route::group([
        'prefix' => 'users',
        'as' => 'users.'
    ], function () {
        Route::get('/', [UserController::class, 'listUser'])->name('listUser');
        Route::get('/detail-user/{idUser}', [UserController::class, 'detailUser'])->name('detailUser');
        Route::get('/update-user/{idUser}', [UserController::class, 'updateUser'])->name('updateUser');
        Route::patch('/update-user/{idUser}', [UserController::class, 'updatePatchUser'])->name('updatePatchUser');
        Route::patch('/toggle-status/{idUser}', [UserController::class, 'toggleStatus'])->name('toggleStatus');
    });

    // Quản lý quyền Admin
    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.'
    ], function () {
        Route::get('/', [RoleController::class, 'listRole'])->name('listRole');
        Route::get('/add-role', [RoleController::class, 'addRole'])->name('addRole');
        Route::post('/add-role', [RoleController::class, 'addPostRole'])->name('addPostRole');
        Route::get('/detail-role/{idRole}', [RoleController::class, 'detailRole'])->name('detailRole');
        Route::get('/update-role/{idRole}', [RoleController::class, 'updateRole'])->name('updateRole');
        Route::patch('/update-role/{idRole}', [RoleController::class, 'updatePatchRole'])->name('updatePatchRole');
        Route::delete('/delete-role', [RoleController::class, 'deleteRole'])->name('deleteRole');
    });

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

    Route::group([
        'prefix' => 'categories',
        'as' => 'categories.'
    ], function () {
        Route::get('/', [CategoryController::class, 'listCategory'])->name('listCategory');
        Route::get('/add-category', [CategoryController::class, 'addCategory'])->name('addCategory');
        Route::post('/add-category', [CategoryController::class, 'addPostCategory'])->name('addPostCategory');
        Route::get('/detail-category/{idCategory}', [CategoryController::class, 'detailCategory'])->name('detailCategory');
        Route::delete('/delete-category', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
        Route::get('update-category/{idCategory}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
        Route::patch('update-category/{idCategory}', [CategoryController::class, 'updatePatchCategory'])->name('updatePatchCategory');
    });

    Route::group([
        'prefix' => 'posts',
        'as' => 'posts.'
    ], function () {
        Route::get('/', [PostController::class, 'listPost'])->name('listPost');
        Route::get('/add-post', [PostController::class, 'addPost'])->name('addPost');
        Route::post('/add-post', [PostController::class, 'addPostPost'])->name('addPostPost');
        Route::get('/detail-post/{idPost}', [PostController::class, 'detailPost'])->name('detailPost');
        Route::delete('/delete-post', [PostController::class, 'deletePost'])->name('deletePost');
        Route::get('update-post/{idPost}', [PostController::class, 'updatePost'])->name('updatePost');
        Route::patch('update-post/{idPost}', [PostController::class, 'updatePatchPost'])->name('updatePatchPost');
    });

    // Quản lý PostComment
    Route::group([
        'prefix' => 'postcomments',
        'as' => 'postcomments.'
    ], function () {
        Route::get('/', [PostCommentController::class, 'listPostComment'])->name('listPostComment');
        Route::get('/detail-postcomment/{idPostComment}', [PostCommentController::class, 'detailPostComment'])->name('detailPostComment');
        Route::delete('/delete-postcomment', [PostCommentController::class, 'deletePostComment'])->name('deletePostComment');
    });
});
