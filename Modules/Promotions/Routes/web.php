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

use Modules\Promotions\Http\Controllers\PromotionsController;

Route::prefix('private/system/promotions')->as('private-system.')->middleware(['web','auth','isAdmin'])->group(function() {
    Route::post('/save',[PromotionsController::class,'save'])->name('promotions.save');
    Route::get('/',[PromotionsController::class,'index'])->name('promotions.index');
    Route::get('/getData',[PromotionsController::class,'getData'])->name('promotions.getData');
    Route::post('/remove',[PromotionsController::class,'remove'])->name('promotions.remove');
    Route::get('/create',[PromotionsController::class,'form'])->name('promotions.create');

    Route::get('/edit/{id}',[PromotionsController::class,'form'])->name('promotions.edit')
    ->where('id', '[0-9]+');


    Route::get('/getDataByPromotions',[PromotionsController::class,'getDataByPromotion'])->name('promotions.getData.promtions');
});
