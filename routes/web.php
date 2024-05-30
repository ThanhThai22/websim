<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\LoginUserController;



Route::get('/', function () {
    return view('index');
});

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login'); //trang login co middleware

Route::post('admin/users/login/store', [LoginController::class, 'store']);


//kiem tra middleware login truoc khi dang nhap neu khong dang nhap thi tra ve trang login
Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function(){
        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);

        Route::prefix('menus')->group(function(){
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            //xu ly thong tin CRUD voi menu
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::DELETE('destroy', [MenuController::class, 'destroy']);
        });

        #Route Products
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']); //danh sach san pham
            Route::get('edit/{product}', [ProductController::class, 'show']); //chinh sua danh muc san pham theo id
            Route::post('edit/{product}', [ProductController::class, 'update']); //post thong tin da chinh sua
            Route::DELETE('destroy', [ProductController::class, 'destroy']); //xoa san pham
        });

        #slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SlideController::class, 'create']);
            Route::post('add', [SlideController::class, 'store']);
            Route::get('list', [SlideController::class, 'index']); //danh sach slider
            Route::get('edit/{slider}', [SlideController::class, 'show']); //chinh sua danh muc san pham theo id
            Route::post('edit/{slider}', [SlideController::class, 'update']); //post thong tin da chinh sua
            Route::DELETE('destroy', [SlideController::class, 'destroy']); //xoa san pham
        });

        #upload img len website
        Route::post('upload/services', [UploadController::class, 'store']);

        // #Cart
        Route::get('customers', [CartController::class, 'index']);
        Route::get('customers/view/{customer}', [CartController::class, 'show']);
        Route::DELETE('customers/destroy', [CartController::class, 'destroy']);

    });


    Route::prefix('users')->group(function(){
        Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('index');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });



});

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);

Route::get('/register', [LoginController::class, 'indexRegister']);

Route::post('/register', [LoginController::class, 'registerPost']);
// Route::get('customer-login', [LoginUserController::class, 'customerLogin']);





