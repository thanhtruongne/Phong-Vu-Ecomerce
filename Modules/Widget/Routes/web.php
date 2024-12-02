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

use Modules\Widget\Http\Controllers\WidgetController;

Route::prefix('private/system/promotions')->as('private-system.')->middleware(['auth','isAdmin'])->group(function() {
    Route::get('/widget',[WidgetController::class,'index'])->name('widget');
    Route::post('/widget/create',[WidgetController::class,'form'])->name('widget.create');
    Route::get('/widget/getData',[WidgetController::class,'getData'])->name('widget.getData');
    Route::post('/widget/remove',[WidgetController::class,'remove'])->name('widget.remove');
    Route::get('/widget/edit/{id}',[WidgetController::class,'form'])->name('widget.edit');
    Route::post('/widget/save',[WidgetController::class,'save'])->name('widget.save');
    Route::get('/widget/create',[WidgetController::class,'form'])->name('widget.form');
    Route::get('/widget/getDataProduct',[WidgetController::class,'getDataProduct'])->name('widget.getDataProduct');
    Route::get('/widget/changeStatus',[WidgetController::class,'changeStatus'])->name('widget.change_status');
});