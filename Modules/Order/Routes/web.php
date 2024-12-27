<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Order\Http\Controllers\OrderController;

// Route::group(function() {
// Route::prefix('isNotAdmin')->group(function () {
    Route::post('/store/order',[OrderController::class,'createOrder'])->name('order.store');
// });

// });
