<?php

use Modules\Products\Http\Controllers\ProductCatelogeController;
use Modules\Products\Http\Controllers\ProductsController;
use Modules\Products\Http\Controllers\AttributeController;
use Modules\Products\Http\Controllers\BrandController;

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

Route::prefix('private/system')->as('private-system.')->middleware(['auth','isAdmin'])->group(function() {
    Route::get('/product',[ProductsController::class,'index'])->name('product');
    Route::get('/product/get-data',[ProductsController::class,'getData'])->name('product.getdata'); 
    Route::get('/product/create',[ProductsController::class,'form'])->name('product.create'); 
    Route::get('/product/edit/{id}',[ProductsController::class,'form'])->name('product.edit'); 
    Route::post('/product/save',[ProductsController::class,'save'])->name('product.save'); 
    Route::post('/product/remove',[ProductsController::class,'remove'])->name('product.remove'); 
    Route::post('/product/remove_variant',[ProductsController::class,'remove_variant'])->name('product.remove_variant'); 

    //  ---- Danh mục sản phẩm
    Route::get('/product/categories',[ProductCatelogeController::class,'index'])->name('product-cateloge');
    Route::get('/product/categories/get-data',[ProductCatelogeController::class,'getData'])->name('product-cateloge.getdata'); 
    Route::post('/product/categories/remove',[ProductCatelogeController::class,'remove'])->name('product-cateloge.remove'); 
    Route::post('/product/categories/save',[ProductCatelogeController::class,'save'])->name('product-cateloge.save');       
    Route::get('/product/categories/edit',[ProductCatelogeController::class,'form'])->name('product-cateloge.edit');    
    Route::get('/product/categories/create',[ProductCatelogeController::class,'form'])->name('product-cateloge.create');    
    Route::post('/product/categories/change-status',[ProductCatelogeController::class,'changeStatus'])->name('product-cateloge.change.status');
    Route::post('/product/categories/remove',[ProductCatelogeController::class,'remove'])->name('product-cateloge.remove');
    Route::post('/product/categories/removeSelectAll',[ProductCatelogeController::class,'removeSelectAll'])->name('product-cateloge.remove.select');
    
     //  ---- Attribute sản phẩm
     Route::get('/product/attribute',[AttributeController::class,'index'])->name('product-attribute');
     Route::get('/product/attribute/get-data',[AttributeController::class,'getData'])->name('product-attribute.getdata'); 
     Route::post('/product/attribute/remove',[AttributeController::class,'remove'])->name('product-attribute.remove'); 
     Route::post('/product/attribute/save',[AttributeController::class,'save'])->name('product-attribute.save');       
     Route::get('/product/attribute/edit',[AttributeController::class,'form'])->name('product-attribute.edit');    
     Route::get('/product/attribute/create',[AttributeController::class,'form'])->name('product-attribute.create');    
     Route::post('/product/attribute/change-status',[AttributeController::class,'changeStatus'])->name('product-attribute.change.status');
     Route::post('/product/attribute/remove',[AttributeController::class,'remove'])->name('product-attribute.remove');
     Route::post('/product/attribute/removeSelectAll',[AttributeController::class,'removeSelectAll'])->name('product-attribute.remove.select');

      //  ---- Brand sản phẩm
      Route::get('/product/brand',[BrandController::class,'index'])->name('product-brand');
      Route::get('/product/brand/get-data',[BrandController::class,'getData'])->name('product-brand.getdata'); 
      Route::post('/product/brand/remove',[BrandController::class,'remove'])->name('product-brand.remove'); 
      Route::post('/product/brand/save',[BrandController::class,'save'])->name('product-brand.save');       
      Route::get('/product/brand/edit',[BrandController::class,'form'])->name('product-brand.edit');    
      Route::get('/product/brand/create',[BrandController::class,'form'])->name('product-brand.create');    
      Route::post('/product/brand/change-status',[BrandController::class,'changeStatus'])->name('product-brand.change.status');
      Route::post('/product/brand/remove',[BrandController::class,'remove'])->name('product-brand.remove');
      Route::post('/product/brand/removeSelectAll',[BrandController::class,'removeSelectAll'])->name('product-brand.remove.select');
});

