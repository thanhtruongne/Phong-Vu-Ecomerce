<?php

use Modules\Menus\Http\Controllers\MenusCatelogeController;
use Modules\Menus\Http\Controllers\MenusController;
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

Route::prefix('private/system')->as('private-system.')->middleware(['web','auth','isAdmin'])->group(function() {
    
    Route::get('/menus/create',[MenusController::class,'create'])->name('menus.create');
    Route::post('/menus/save',[MenusController::class,'save'])->name('menus.save');
    Route::post('/menus/child/save',[MenusController::class,'childSave'])->name('menus.child.save');


    Route::prefix('/menus')->group(function(){
        //cateloge
        Route::group(['prefix' => '/cateloge'],function(){
            Route::get('/',[MenusCatelogeController::class,'index'])->name('menus.cateloge.index');
            Route::get('/getData',[MenusCatelogeController::class,'getData'])->name('menus.cateloge.getData');
            Route::post('/remove',[MenusCatelogeController::class,'remove'])->name('menus.cateloge.remove');
            Route::post('/save',[MenusCatelogeController::class,'save'])->name('menus.cateloge.save');
            Route::get('/child/{id}',[MenusCatelogeController::class,'children'])
            ->name('menus.cateloge.children')
            ->where('id', '[0-9]+');

            Route::post('/child/attemps',[MenusCatelogeController::class,'attemps_child'])
            ->name('menus.cateloge.attemps_child');
        });
    });
   
});
