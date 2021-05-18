<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('auth/login', [AuthController::class,"login"]);
Route::post('auth/register', [AuthController::class,"register"]);

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'
], function ($router) {
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
});

Route::group([
    'middleware' => 'jwt.verify'
], function ($router) {
    Route::apiResource('products', ProductController::class);
});

