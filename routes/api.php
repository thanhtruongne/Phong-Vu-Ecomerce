<?php

use App\Http\Controllers\Frontend\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Payments\ZaloPayController;
use App\Http\Controllers\testController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/pay',[ZaloPayController::class,'pay'])->name('pay');

Route::post('/callback',[ZaloPayController::class,'callback'])->name('callback');
