<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

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


// api
Route::get('products/list', [RouteController::class, 'productList']);
Route::get('category/list', [RouteController::class, 'categoryList']);
Route::get('order/delete/{id}', [RouteController::class, 'deleteOrder']);
Route::get('category/list/{id}', [RouteController::class, 'detail']);
Route::post('create/category', [RouteController::class, 'createCategory']);
Route::post('update/category', [RouteController::class, 'updateCategory']);
Route::post('create/product', [RouteController::class, 'createProduct']);
