<?php

use App\Http\Controllers\API\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// GET
Route::get('product/list', [RouteController::class, 'productList']);
Route::get('category/list', [RouteController::class, 'categoryList']);
Route::get('orderLists', [RouteController::class, 'orderLists']);

// POST
Route::post('category/create', [RouteController::class, 'categoryCreate']);
Route::post('contact/create', [RouteController::class, 'contactCreate']);

Route::get('category/delete/{id}', [RouteController::class, 'deleteCategory']);
Route::get('category/details/{id}', [RouteController::class, 'categoryDetails']);
Route::post('category/update', [RouteController::class, 'updateCategory']);
