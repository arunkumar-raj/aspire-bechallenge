<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Include Controllers needed
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AdminController;

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


//API Version1
Route::group(['prefix'=>'v1/user'], function(){
    Route::apiResource('register',UserController::class,['only' => ['store']]);
    Route::post('login',[UserController::class,'login']);
    Route::post('logout',[ApiController::class,'logout']);
});
Route::group(['prefix'=>'v1/admin'], function(){
    Route::apiResource('register',AdminController::class,['only' => ['store']]);
    Route::post('login',[AdminController::class,'login']);
    Route::post('logout',[ApiController::class,'logout']);
});