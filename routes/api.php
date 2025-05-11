<?php

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

Route::middleware('jwt:api')->group(function (){
    Route::get('products-list', [\App\Http\Controllers\Api\ItemsController::class, 'ProductsList']);

    Route::post('update-product', [\App\Http\Controllers\Api\ItemsController::class, 'UpdateProduct']);

    Route::delete('remove-product', [\App\Http\Controllers\Api\ItemsController::class, 'RemoveProduct']);
});
