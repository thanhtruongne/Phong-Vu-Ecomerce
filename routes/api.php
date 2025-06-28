<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Frontend\HomeController;
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

Route::group([
    'middleware' => ['auth:sanctum'],
    'controller' => AuthController::class
], function () {
    Route::get('/user', 'getCurrentUser');

    //address
    Route::post('/user/save-address', 'saveAddress');
    Route::get('/address/edit/{id}', 'getAddressCurrent');
    Route::post('/user/save-user-info', 'saveUserInfo');
    Route::delete('/remove-address/{address}', 'removeAddress');
    Route::get('/get-address-code', 'getAddressCode');
    Route::get('/get-address-detail-code/{address}', 'getCodeDetailAddress');
    Route::get('/get-district-code', 'getDistrictCode');
});



Route::get('/get-data-layout', [GeneralController::class, 'getDataLayout'])->name('home');
Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});


Route::get('/sign-google-login', [GeneralController::class, 'callBackGoogle'])->name('fe.login-sign-callback-google');
Route::get('/google/callback', [GeneralController::class, 'handleLoginCallbackGoogle'])->name('fe.handle-callback-google');


// Route::post('/pay',[ZaloPayController::class,'pay'])->name('pay');

// Route::post('/callback',[ZaloPayController::class,'callback'])->name('callback');
