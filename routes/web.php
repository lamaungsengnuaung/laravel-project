<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Laravel\Jetstream\Rules\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\User\UserContoller;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\AjaxController;
use Symfony\Component\Routing\RouteCompiler;

// login , register
Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

// Route::permanentRedirect('/here', '/there');

Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function () {

        // category
        Route::prefix('category')->group(function () {

            // list
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            // createPage
            Route::get('createPage', [CategoryController::class, 'createPage'])->name('category#createPage');
            // create
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            // delete
            Route::delete('delete/{id}', [CategoryController::class, 'categoryDelete'])->name('category#delete');
            // serach
            // Route::post('category/list/search', [CategoryController::class, 'search'])->name('category#search');
            //edit
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });
        //admin account
        Route::prefix('admin')->group(function () {
            Route::get('password/changePage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password', [AdminController::class, 'changePassword'])->name('admin#changePassword');
            Route::get('info/detail', [AdminController::class, 'detailpage'])->name('admin#info');
            Route::get('info/edit', [AdminController::class, 'editpage'])->name('admin#editpage');
            Route::post('info/update/{id}', [AdminController::class, 'update'])->name('admin#update');
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');
            Route::delete('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');
            Route::get('role/{id}', [AdminController::class, 'changeRollpage'])->name('admin#changeRole');
            Route::post('role/convert', [AdminController::class, 'convert'])->name('adminRole#convert');
            Route::get('role/ajax/change', [AdminController::class, 'change'])->name('ajax#changeRole');
        });
        // customer
        Route::prefix('customer')->group(function () {
            Route::get('list', [AdminController::class, 'customerlist'])->name('customer#list');
            Route::delete('delete/{id}', [AdminController::class, 'customerdelete'])->name('customer#delete');
            Route::get('ajax/changeRole', [AdminController::class, 'customerRole'])->name('customer#role');
        });
        // product
        Route::prefix('products')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name('products#list');
            Route::get('createPage', [ProductController::class, 'createPage'])->name('products#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('products#create');
            Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('products#delete');
            Route::get('edit/{id}', [ProductController::class, 'editPage'])->name('products#editPage');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('products#update');
            Route::get('detail/{id}', [ProductController::class, 'detail'])->name('products#detailPage');
        });
        // order
        Route::prefix('orders')->group(function () {
            Route::get('list', [OrderController::class, 'list'])->name('orders#list');
            Route::post('list/search', [OrderController::class, 'filter'])->name('orders#search');
            Route::get('ajax/changeStatus', [OrderController::class, 'ajaxStatus'])->name('orders#ajaxStatus');
            Route::get('ajax/filterStatus', [OrderController::class, 'ajaxFilter']);
            Route::get('list/detail/{orderCode}', [OrderController::class, 'listInfo'])->name('orders#listInfo');
        });
        // contact
        Route::prefix('contact')->group(function () {
            Route::get('message/list', [ContactController::class, 'list'])->name('contact#list');
            Route::get('ajax/detail', [ContactController::class, 'detail'])->name('contact#detail');
        });
    });
});

// user
Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
    // home
    Route::get('homePage', [UserContoller::class, 'home'])->name('user#home');
    Route::get('mycart', [CartController::class, 'mycart'])->name('user#cart');
    Route::get('history', [UserContoller::class, 'previousOrder'])->name('user#history');
    Route::get('filter/{id}', [UserContoller::class, 'filter'])->name('user#filter');
    Route::get('contact', [ContactController::class, 'contactPage'])->name('user#contact');
    Route::post('contact/message', [ContactController::class, 'message'])->name('user#message');
    // pizza
    Route::prefix('pizza')->group(function () {
        Route::get('detail/{id}', [UserContoller::class, 'detail'])->name('pizza#detail');
    });
    // Account
    Route::prefix('profile/account')->group(function () {
        Route::get('detail/', [AccountController::class, 'detail'])->name('user#account');
        Route::get('edit', [AccountController::class, 'editpage'])->name('user#editpage');
        Route::post('update/{id}', [AccountController::class, 'update'])->name('user#update');
        Route::get('password/changePage', [AccountController::class, 'changePasswordPage'])->name('user#changePasswordPage');
        Route::post('changepassword', [AccountController::class, 'changePassword'])->name('user#changePassword');
    });
    // jquery ajax
    Route::prefix('ajax')->group(function () {
        Route::get('pizzaList', [AjaxController::class, 'pizzaLists'])->name('ajax#pizzaList');
        Route::get('Cart', [AjaxController::class, 'addcart']);
        Route::get('order', [AjaxController::class, 'order']);
        Route::get('clear/cart', [AjaxController::class, 'clearCart']);
        Route::get('clear/currentProduct', [AjaxController::class, 'clearProduct']);
        Route::get('increase/viewCount', [AjaxController::class, 'viewCount']);
    });
});
