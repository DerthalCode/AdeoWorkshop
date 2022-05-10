<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::prefix('auth')->group(function (){
    Route::post('register',[AuthController::class, 'postRegister']);
    Route::post('login',[AuthController::class, 'postLogin']);
});
Route::prefix('auth')->middleware('auth:sanctum')->group(function (){
    Route::post('logout',[AuthController::class, 'postLogout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
