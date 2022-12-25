<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController1;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\Usercontroller;

// login , register
Route::middleware(['admin_auth'])->group(function(){

    //admin
    Route::redirect('/', 'loginPage');

    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

//user

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // admin
    // Route::group(['middleware'=>'admin_auth'], function(){});
    Route::middleware(['admin_auth'])->group(function(){

        // category
        Route::group(['prefix'=>'category'], function(){
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function(){
            // profile
            Route::get('details', [AdminController::class, 'details'])->name('admin#details');
            Route::get('editDetails', [AdminController::class, 'edit'])->name('admin#edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('admin#update');

            // admin list
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');
            Route::get('ajax/changeRole', [AdminController::class, 'ajaxChangeRole'])->name('admin#ajaxChangeRole');
            Route::get('changeRole/{id}', [AdminController::class, 'changeRole'])->name('admin#changeRole');
            Route::post('change/role/{id}', [AdminController::class, 'change'])->name('admin#change');

            // password
            Route::get('password/changePage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password', [AdminController::class, 'changePassword'])->name('admin#changePassword');

        });

        //products
        Route::prefix('products')->group(function(){
            Route::get('list', [ProductController::class, 'list'])->name('products#list');
            Route::get('create', [ProductController::class, 'createPage'])->name('products#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('products#create');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('products#delete');
            Route::get('details/{id}', [ProductController::class, 'details'])->name('products#details');
            Route::get('editPage/{id}', [ProductController::class, 'editPage'])->name('products#editPage');
            Route::post('update', [ProductController::class, 'update'])->name('products#update');
        });

        // order list
        Route::prefix('order')->group(function(){
            Route::get('list', [OrderController::class, 'orderList'])->name('order#list');
            Route::get('change/status', [OrderController::class, 'changeStatus'])->name('admin#changeStatus');
            Route::get('ajax/change/status', [OrderController::class, 'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}', [OrderController::class, 'listInfo'])->name('admin#listInfo');
        });

        // user
        Route::prefix('admin/user')->group(function(){
            Route::get('list', [AdminUserController::class, 'userList'])->name('admin#userList');
            Route::get('changeRole', [AdminUserController::class, 'changeRole'])->name('admin#userChangeRole');
            Route::get('delete/{id}', [AdminUserController::class, 'deleteUser'])->name('admin#userDelete');
            Route::get('contact', [AdminUserController::class, 'contact'])->name('admin#userContact');
            Route::get('contactInfo/{id}', [AdminUserController::class, 'contactInfo'])->name('admin#userContactInfo');
        });
    });


    // user
    Route::group(['prefix'=>'user', 'middleware'=>'user_auth'], function(){
        Route::get('homePage', [Usercontroller::class, 'home'])->name('user#home');
        Route::get('contactPage', [Usercontroller::class, 'contact'])->name('user#contact');
        Route::post('contactSend', [Usercontroller::class, 'contactSend'])->name('user#contactSend');
        Route::get('filter/{id}', [Usercontroller::class, 'filter'])->name('user#filter');
        Route::get('history', [Usercontroller::class, 'history'])->name('user#history');

        // pizza list & details
        Route::prefix('pizza')->group(function(){
            Route::get('details/{id}', [Usercontroller::class, 'pizzaDetails'])->name('user#pizzaDetails');
        });

        // cart list & details
        Route::prefix('cart')->group(function(){
            Route::get('list', [Usercontroller::class, 'cartList'])->name('user#cartList');
        });

        // profile
        Route::prefix('account')->group(function(){
            Route::get('details', [Usercontroller::class, 'details'])->name('user#AccountDetails');
            Route::get('edit', [Usercontroller::class, 'edit'])->name('user#edit');
            Route::post('update/{id}', [Usercontroller::class, 'update'])->name('user#update');
        });

        // password
        Route::prefix('password')->group(function(){
            Route::get('change', [Usercontroller::class, 'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('change', [Usercontroller::class, 'changePassword'])->name('user#changePassword');
        });

        // ajax
        Route::prefix('ajax')->group(function(){
            Route::get('pizza/list', [AjaxController::class, 'pizzaList'])->name('ajax#pizzaList');
            Route::get('cart', [AjaxController::class, 'addToCart'])->name('ajax#addToCart');
            Route::get('order', [AjaxController::class, 'order'])->name('ajax#order');
            Route::get('clear/currentProduct', [AjaxController::class, 'clearCurrentProduct'])->name('ajax#clearCurrentProduct');
            Route::get('clear/cart', [AjaxController::class, 'clearCart'])->name('ajax#clearCart');
            Route::get('increase/viewCount', [AjaxController::class, 'increaseViewCount'])->name('ajax#increaseViewCount');
        });
    });
});
