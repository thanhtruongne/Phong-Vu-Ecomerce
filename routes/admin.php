<?php

use App\Http\Controllers\Backend\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Backend\Ajax\AttributeController as  AjaxAttributeController;
use App\Http\Controllers\Backend\Ajax\MenuController as AjaxMenuController;
use App\Http\Controllers\Backend\Ajax\LocationController;
use App\Http\Controllers\Backend\Ajax\AjaxPromotionController;
use App\Http\Controllers\Backend\Auth\AuthencateController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GenerateModuleController;
use App\Http\Controllers\Backend\LanguagesController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PostCatalogeController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserCatalogeController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\ProductCatelogeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\AttributeCatelogeController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\CustomerCatelogeController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\MenuCatelogeController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PromotionController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SourceController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Backend\WidgetController;

//@@route-plugin@@


//Ajax Api
Route::get('ajax/get-location',[LocationController::class,'getLocation'])->name('get-location-ajax');
//global change status
Route::get('ajax/dashboard/changestatus',[AjaxDashboardController::class,'changeStatus'])->name('changestatus-ajax');
Route::get('ajax/dashboard/change-all-status',[AjaxDashboardController::class,'changeStatusAll'])->name('changestatus-all-ajax');

//Choose_variant_attribute select2
Route::get('/ajax/attribute/getAttributeCateloge',[AjaxAttributeController::class,'getAttribute'])->name('attribute.getAttribute');
Route::get('/ajax/attribute/GetAttribute',[AjaxAttributeController::class,'findAttributeVariants'])->name('attribute.FindAttribute');

//menu
Route::get('/ajax/menu/getMenu',[AjaxMenuController::class,'getMenu'])->name('menu.ajax.getMenu');
//widget
Route::get('/ajax/dashboard/widget/model',[AjaxDashboardController::class,'getModelWidgetSearch'])->name('widget.ajax.dashboard.model');

//promotion
Route::get('/ajax/dashboard/promotion/product',[AjaxPromotionController::class,'loadPromotion'])->name('promotion.loadPromotion');

Route::get('/ajax/dashboard/promotion/product/getInterview',[AjaxPromotionController::class,'getInterview'])->name('promotion.getInterview');

//dashboard promotion 
Route::get('/ajax/dashboard/promotion/source',[AjaxDashboardController::class,'makeDataGetByClassPromotion'])->name('promotion.product.source');
//dashboard promotion customer cateloge
Route::get('/ajax/dashboard/promotion/customer/cateloge',[AjaxDashboardController::class,'makePromotionCustomerCateloge'])->name('promotion.customer.cateloge');


Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('/logout',[AuthencateController::class,'logout'])->name('logout');

//Management User
Route::get('/user/table-user',[UserController::class,'index'])->name('management.table-user');
Route::get('/user/table-user/create',[UserController::class,'create'])->name('management.table-user.create');

Route::post('/user/post/store/user',[UserController::class,'store'])->name('management.table-user.store');
Route::get('/user/table-user/edit/{id}',[UserController::class,'edit'])->name('management.table-user.edit');
Route::put('/user/table-user/update/{id}',[UserController::class,'update'])->name('management.table-user.update');
Route::delete('/user/table-user/remove/{id}',[UserController::class,'delete'])->name('management.table-user.delete');

// Trashed User
Route::get('/user/table-user/trashed',[UserController::class,'trashed'])->name('management.table-user.trashed');
Route::delete('/user/table-user/trashed/delete-force/{id}',[UserController::class,'deleteForce'])->name('management.table-user.trahsed.force');
Route::get('/user/table-user/trashed/restore/{id}',[UserController::class,'restore'])->name('management.table-user.trahsed.restore');

//Management User Cataloge
Route::get('/user/cataloge-user',[UserCatalogeController::class,'index'])->name('management.cataloge.index');
Route::get('/user/cataloge-user/create',[UserCatalogeController::class,'create'])->name('management.cataloge.create');
Route::post('/user/cataloge-user/post',[UserCatalogeController::class,'store'])->name('management.cataloge.store');
Route::get('/user/cataloge-user/edit/{id}',[UserCatalogeController::class,'edit'])->name('management.cataloge.edit');
Route::put('/user/cataloge-user/update/{id}',[UserCatalogeController::class,'update'])->name('management.cataloge.update');

Route::delete('/user/cataloge-user/remove/{id}',[UserCatalogeController::class,'delete'])->name('management.cataloge.delete');

// Management Language
Route::get('configuration/language',[LanguagesController::class,'index'])->name('management.configuration.language.index');
Route::get('configuration/language/edit/{id}',[LanguagesController::class,'edit'])->name('management.configuration.language.edit');
Route::post('configuration/language/store',[LanguagesController::class,'store'])->name('management.configuration.language.store');
Route::get('configuration/language/create',[LanguagesController::class,'create'])->name('management.configuration.language.create');
Route::put('configuration/language/update/{id}',[LanguagesController::class,'update'])->name('management.configuration.language.update');
Route::delete('configuration/language/remove/{id}',[LanguagesController::class,'destroy'])->name('management.configuration.language.remove');
//Change Language Global
Route::get('configuration/language/change/{id}',[LanguagesController::class,'ChangeLanguageTemplate'])->name('management.configuration.language.change');
//Thay đổi bản dịch dynamic
Route::get('configuration/{model}/{id}/{languages_id}/translate',[LanguagesController::class,'translateDynamic'])->name('management.configuration.language.translate');
Route::post('configuration/language/translate/dynamic',[LanguagesController::class,'translate'])->name('management.configuration.language.translate.dynamic');
// Management Post-Cataloge
Route::get('post/post-cataloge',[PostCatalogeController::class,'index'])->name('management.post.cataloge.index');
Route::get('post/post-cataloge/edit/{id}',[PostCatalogeController::class,'edit'])->name('management.post-cataloge.edit');
Route::post('post/post-cataloge/store',[PostCatalogeController::class,'store'])->name('management.post-cataloge.store');
Route::get('post/post-cataloge/create',[PostCatalogeController::class,'create'])->name('management.post-cataloge.create');
Route::put('post/post-cataloge/update/{id}',[PostCatalogeController::class,'update'])->name('management.post-cataloge.update');
Route::delete('post/post-cataloge/remove/{id}',[PostCatalogeController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.post-cataloge.remove');

//Trashed  Post-Cataloge
Route::get('post/post-cataloge/trashed',[PostCatalogeController::class,'trashed'])->name('management.post.cataloge.trashed');
Route::get('post/post-cataloge/restore/{id}',[PostCatalogeController::class,'restore'])->name('management.post.cataloge.restore');  
Route::delete('post/post-cataloge/delete-force/{id}',[PostCatalogeController::class,'deleteForce'])->name('management.post.cataloge.delete-force');  

//Management Post
Route::get('post/index',[PostController::class,'index'])->name('management.post.index');
Route::get('post/edit/{id}',[PostController::class,'edit'])->name('management.post.edit');
Route::post('post/store',[PostController::class,'store'])->name('management.post.store');
Route::get('post/create',[PostController::class,'create'])->name('management.post.create');
Route::put('post/update/{id}',[PostController::class,'update'])->name('management.post.update');
Route::delete('post/remove/{id}',[PostController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.post.remove');
Route::get('post/trashed',[PostController::class,'trashed'])->name('management.post.trashed');
Route::get('post/restore/{id}',[PostController::class,'restore'])->name('management.post.restore');  
Route::delete('post/delete-force/{id}',[PostController::class,'deleteForce'])->name('management.post.delete-force');  


//permission
Route::get('configuration/permissions',[PermissionController::class,'index'])->name('management.configuration.permissions.index');
Route::get('configuration/permissions/create',[PermissionController::class,'create'])->name('management.configuration.permissions.create');
Route::get('configuration/permissions/edit/{id}',[PermissionController::class,'edit'])->name('management.configuration.permissions.edit');
Route::post('configuration/permissions/store',[PermissionController::class,'store'])->name('management.configuration.permissions.store');
Route::put('configuration/permissions/update/{id}',[PermissionController::class,'update'])->name('management.configuration.permissions.update');
Route::put('configuration/permissions/change',[PermissionController::class,'changePermision'])->name('management.configuration.permissions.change');


//promotion
Route::get('promotion',[PromotionController::class,'index'])->name('management.promotion');
Route::get('promotion/create',[PromotionController::class,'create'])->name('management.promotion.create');
Route::get('promotion/edit/{id}',[PromotionController::class,'edit'])->name('management.promotion.edit');
Route::post('promotion/store',[PromotionController::class,'store'])->name('management.promotion.store');
Route::put('promotion/update/{id}',[PromotionController::class,'update'])->name('management.promotion.update');
Route::delete('promotion/remove/{id}',[PromotionController::class,'remove'])->name('management.promotion.remove');

//nguồn khách hàng
Route::get('source',[SourceController::class,'index'])->name('management.source');
Route::get('source/create',[SourceController::class,'create'])->name('management.source.create');
Route::get('source/edit/{id}',[SourceController::class,'edit'])->name('management.source.edit');
Route::post('source/store',[SourceController::class,'store'])->name('management.source.store');
Route::put('source/update/{id}',[SourceController::class,'update'])->name('management.source.update');
Route::delete('source/remove/{id}',[SourceController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.source.remove');

// khách hàng
Route::get('customer',[CustomerController::class,'index'])->name('management.customer');
Route::get('customer/create',[CustomerController::class,'create'])->name('management.customer.create');
Route::get('customer/edit/{id}',[CustomerController::class,'edit'])->name('management.customer.edit');
Route::post('customer/store',[CustomerController::class,'store'])->name('management.customer.store');
Route::put('customer/update/{id}',[CustomerController::class,'update'])->name('management.customer.update');
Route::delete('customer/remove/{id}',[CustomerController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.customer.remove');

// nhóm khách hàng
Route::get('customer/cateloge',[CustomerCatelogeController::class,'index'])->name('management.customer.cateloge');
Route::get('customer/cateloge/create',[CustomerCatelogeController::class,'create'])->name('management.customer.cateloge.create');
Route::get('customer/cateloge/edit/{id}',[CustomerCatelogeController::class,'edit'])->name('management.customer.cateloge.edit');
Route::post('customer/cateloge/store',[CustomerCatelogeController::class,'store'])->name('management.customer.cateloge.store');
Route::put('customer/cateloge/update/{id}',[CustomerCatelogeController::class,'update'])->name('management.customer.cateloge.update');
Route::delete('customer/cateloge/remove/{id}',[CustomerCatelogeController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.customer.cateloge.remove');


// menu
// Route::get('menu',[MenuCatelogeController::class,'index'])->name('management.menu.index');
// Route::get('menu-cateloge/create',[MenuCatelogeController::class,'create'])->name('management.menu.cateloge.create');
// Route::get('menu/edit/{id}',[MenuCatelogeController::class,'edit'])->name('management.menu.edit');
Route::post('menu-cateloge/store',[MenuCatelogeController::class,'store'])->name('management.menu.cateloge.store');
Route::get('menu/{id}/children',[MenuController::class,'children'])->name('management.menu.children');
Route::get('menu/ajax/nested-table',[MenuController::class,'nestedTable'])->name('management.menu.nested-table');
Route::post('menu/save/children',[MenuController::class,'saveChildren'])->name('management.menu.save.children');
// Route::put('menu/update',[MenuCatelogeController::class,'update'])->name('management.menu.update');

Route::get('menu',[MenuController::class,'index'])->name('management.menu.index');
Route::get('menu/create',[MenuController::class,'create'])->name('management.menu.create');
Route::get('menu/edit/{id}',[MenuController::class,'edit'])->name('management.menu.edit');
Route::post('menu/store',[MenuController::class,'store'])->name('management.menu.store');
Route::put('menu/update',[MenuController::class,'update'])->name('management.menu.update');
Route::put('menu/remove/{id}',[MenuController::class,'remove'])->name('management.menu.remove');


//Slider
Route::get('slider',[SliderController::class,'index'])->name('management.slider.index');
Route::get('slider/create',[SliderController::class,'create'])->name('management.slider.create');
Route::get('slider/edit/{id}',[SliderController::class,'edit'])->name('management.slider.edit');
Route::post('slider/store',[SliderController::class,'store'])->name('management.slider.store');
Route::put('slider/update/{id}',[SliderController::class,'update'])->name('management.slider.update');
Route::put('slider/remove/{id}',[SliderController::class,'remove'])->name('management.slider.remove');

//Widget
Route::get('widget/',[WidgetController::class,'index'])->name('management.widget.index');
Route::get('widget/create',[WidgetController::class,'create'])->name('management.widget.create');
Route::get('widget/edit/{id}',[WidgetController::class,'edit'])->name('management.widget.edit');
Route::post('widget/store',[WidgetController::class,'store'])->name('management.widget.store');
Route::put('widget/update/{id}',[WidgetController::class,'update'])->name('management.widget.update');
Route::put('widget/remove/{id}',[WidgetController::class,'remove'])->name('management.widget.remove');


//Cấu hình hệ thống
Route::get('configuration/setting',[SystemController::class,'index'])->name('management.configuration.setting.index');
Route::get('configuration/setting/create',[SystemController::class,'create'])->name('management.configuration.setting.create');
Route::get('configuration/setting/edit/{id}',[SystemController::class,'edit'])->name('management.configuration.setting.edit');
Route::post('configuration/setting/store',[SystemController::class,'store'])->name('management.configuration.setting.store');
Route::put('configuration/setting/update',[SystemController::class,'update'])->name('management.configuration.setting.update');
Route::get('configuration/setting/translate/{language_id}',[SystemController::class,'translate'])->name('management.configuration.setting.translate');
Route::post('configuration/setting/Savetranslate/{language_id}',[SystemController::class,'Savetranslate'])->name('management.configuration.setting.save.translate');

//Module generate (Tạo ra các module sẵn có như controller,repositories,services...)
Route::get('configuration/module',[GenerateModuleController::class,'index'])->name('management.module.index');
Route::get('configuration/module/edit/{id}',[GenerateModuleController::class,'edit'])->name('management.module.edit');
Route::post('configuration/module/store',[GenerateModuleController::class,'store'])->name('management.module.store');
Route::get('configuration/module/create',[GenerateModuleController::class,'create'])->name('management.module.create');
Route::put('configuration/module/update/{id}',[GenerateModuleController::class,'update'])->name('management.module.update');
Route::delete('configuration/module/remove/{id}',[GenerateModuleController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.module.remove');


Route::get('product/cateloge',[ProductCatelogeController::class,'index'])->name('management.product.cateloge.index');
Route::get('product/cateloge/edit/{id}',[ProductCatelogeController::class,'edit'])->name('management.product.cateloge.edit');
Route::post('product/cateloge/store',[ProductCatelogeController::class,'store'])->name('management.product.cateloge.store');
Route::get('product/cateloge/create',[ProductCatelogeController::class,'create'])->name('management.product.cateloge.create');
Route::put('product/cateloge/update/{id}',[ProductCatelogeController::class,'update'])->name('management.product.cateloge.update');
Route::delete('product/cateloge/remove/{id}',[ProductCatelogeController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.product.cateloge.remove'); 


Route::get('product',[ProductController::class,'index'])->name('management.product.index');
Route::get('product/edit/{id}',[ProductController::class,'edit'])->name('management.product.edit');
Route::post('product/store',[ProductController::class,'store'])->name('management.product.store');
Route::get('product/create',[ProductController::class,'create'])->name('management.product.create');
Route::put('product/update/{id}',[ProductController::class,'update'])->name('management.product.update');
Route::delete('product/remove/{id}',[ProductController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.product.remove'); 


Route::get('attribute/cateloge',[AttributeCatelogeController::class,'index'])->name('management.attribute.cateloge.index');
Route::get('attribute/cateloge/edit/{id}',[AttributeCatelogeController::class,'edit'])->name('management.attribute.cateloge.edit');
Route::post('attribute/cateloge/store',[AttributeCatelogeController::class,'store'])->name('management.attribute.cateloge.store');
Route::get('attribute/cateloge/create',[AttributeCatelogeController::class,'create'])->name('management.attribute.cateloge.create');
Route::put('attribute/cateloge/update/{id}',[AttributeCatelogeController::class,'update'])->name('management.attribute.cateloge.update');
Route::delete('attribute/cateloge/remove/{id}',[AttributeCatelogeController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.attribute.cateloge.remove'); 




Route::get('attribute',[AttributeController::class,'index'])->name('management.attribute.index');
Route::get('attribute/edit/{id}',[AttributeController::class,'edit'])->name('management.attribute.edit');
Route::post('attribute/store',[AttributeController::class,'store'])->name('management.attribute.store');
Route::get('attribute/create',[AttributeController::class,'create'])->name('management.attribute.create');
Route::put('attribute/update/{id}',[AttributeController::class,'update'])->name('management.attribute.update');
Route::delete('attribute/remove/{id}',[AttributeController::class,'destroy'])
->where(['id' => '[0-9]+'])
->name('management.attribute.remove'); 
//@!new-controller-module







