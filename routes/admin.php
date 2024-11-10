<?php

use App\Http\Controllers\Backend\Ajax\AjaxLoaderController;
use App\Http\Controllers\Backend\Auth\AuthencateController;
use App\Http\Controllers\Backend\DashboardController;

use App\Http\Controllers\Backend\CategoriesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\Shipping\ShippingGHTK;
use Modules\Products\Http\Controllers\AttributeController;
use Modules\Products\Http\Controllers\ProductCatelogeController;
use Modules\Products\Http\Controllers\ProductsController;
use Modules\Products\Http\Controllers\AttributeCatelogeController;



//admin login

    Route::get('/login',[AuthencateController::class,'index'])->name('be.login.template');
    Route::post('/login',[AuthencateController::class,'login'])->name('be.login');
    Route::middleware(['auth','isAdmin'])->group(function(){

        Route::match(['get', 'post'], 'logout',[AuthencateController::class,'logout'] )->name('logout');
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

        //categories boa gồm các danh mcu5 sản phẩm
        Route::get('/categories',[CategoriesController::class,'index'])->name('categories');
        Route::get('/categories/get-data',[CategoriesController::class,'getData'])->name('categories.getdata'); 
        Route::post('/categories/remove',[CategoriesController::class,'remove'])->name('categories.remove'); 
        Route::post('/categories/save',[CategoriesController::class,'save'])->name('categories.save');       
        Route::get('/categories/edit',[CategoriesController::class,'form'])->name('categories.edit');    
        Route::get('/categories/create',[CategoriesController::class,'form'])->name('categories.create');    
        Route::post('/categories/change-status',[CategoriesController::class,'changeStatus'])->name('categories.change.status');
        Route::post('/categories/remove',[CategoriesController::class,'remove'])->name('categories.remove');
        Route::post('/categories/removeSelectAll',[CategoriesController::class,'removeSelectAll'])->name('categories.remove.select');
        
        //Sản phẩm

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
        
        //  Route::get('/product/categories/attribute',[AttributeCatelogeController::class,'index'])->name('product-attribute-catgories');
        //  Route::get('/product/categories/attribute/get-data',[AttributeCatelogeController::class,'getData'])->name('product-attribute-catgories.getdata'); 
        //  Route::post('/product/categories/attribute/remove',[AttributeCatelogeController::class,'remove'])->name('product-attribute-catgories.remove'); 
        //  Route::post('/product/categories/attribute/save',[AttributeCatelogeController::class,'save'])->name('product-attribute-catgories.save');       
        //  Route::get('/product/categories/attribute/edit',[AttributeCatelogeController::class,'form'])->name('product-attribute-catgories.edit');    
        //  Route::get('/product/categories/attribute/create',[AttributeCatelogeController::class,'form'])->name('product-attribute-catgories.create');    
        //  Route::post('/product/categories/attribute/change-status',[AttributeCatelogeController::class,'changeStatus'])->name('product-attribute-catgories.change.status');
        //  Route::post('/product/categories/attribute/remove',[AttributeCatelogeController::class,'remove'])->name('product-attribute-catgories.remove');
        //  Route::post('/product/categories/attribute/removeSelectAll',[AttributeCatelogeController::class,'removeSelectAll'])->name('product-attribute-catgories.remove.select');
        
        
        
        // sản  phẩm item
        Route::get('/product',[ProductsController::class,'index'])->name('product');
        Route::get('/product/get-data',[ProductsController::class,'getData'])->name('product.getdata'); 
        Route::get('/product/create',[ProductsController::class,'form'])->name('product.create'); 
        Route::get('/product/edit/{id}',[ProductsController::class,'form'])->name('product.edit'); 
        Route::post('/product/save',[ProductsController::class,'save'])->name('product.save'); 
        Route::post('/product/remove',[ProductsController::class,'remove'])->name('product.remove'); 
        Route::post('/product/remove_variant',[ProductsController::class,'remove_variant'])->name('product.remove_variant'); 
      
        
        
        Route::get('load-ajax/{func}',[AjaxLoaderController::class,'load_ajax'])->name('load_ajax');
        
        
        
        
         //Ajax Api
        // Route::get('ajax/get-location',[LocationController::class,'getLocation'])->name('get-location-ajax');
        // //global change status
        // Route::get('ajax/dashboard/changestatus',[AjaxDashboardController::class,'changeStatus'])->name('changestatus-ajax');
        // Route::get('ajax/dashboard/change-all-status',[AjaxDashboardController::class,'changeStatusAll'])->name('changestatus-all-ajax');
        
        // //Choose_variant_attribute select2
        // Route::get('/ajax/attribute/getAttributeCateloge',[AjaxAttributeController::class,'getAttribute'])->name('attribute.getAttribute');
        // Route::get('/ajax/attribute/GetAttribute',[AjaxAttributeController::class,'findAttributeVariants'])->name('attribute.FindAttribute');
        
        // //menu
        // Route::get('/ajax/menu/getMenu',[AjaxMenuController::class,'getMenu'])->name('menu.ajax.getMenu');
        // //widget
        // Route::get('/ajax/dashboard/widget/model',[AjaxDashboardController::class,'getModelWidgetSearch'])->name('widget.ajax.dashboard.model');
        
        // //promotion
        // Route::get('/ajax/dashboard/promotion/product',[AjaxPromotionController::class,'loadPromotion'])->name('promotion.loadPromotion');
        
        // Route::get('/ajax/dashboard/promotion/product/getInterview',[AjaxPromotionController::class,'getInterview'])->name('promotion.getInterview');
        
        // //dashboard promotion 
        // Route::get('/ajax/dashboard/promotion/source',[AjaxDashboardController::class,'makeDataGetByClassPromotion'])->name('promotion.product.source');
        // //dashboard promotion customer cateloge
        // Route::get('/ajax/dashboard/promotion/customer/cateloge',[AjaxDashboardController::class,'makePromotionCustomerCateloge'])->name('promotion.customer.cateloge');
        
        // Route::get('/ajax/order/change',[AjaxCartController::class,'ChangeAjaxOrder'])->name('ajax.order.change');

        // Route::post('/ajax/order/sendInvoice/payment',[AjaxCartController::class,'paymentsendInvoice'])->name('ajax.order.payment.send.invoice');




        // //Management User
        // Route::get('/user/table-user',[UserController::class,'index'])->name('management.table-user');
        // Route::get('/user/table-user/create',[UserController::class,'create'])->name('management.table-user.create');
        
        // Route::post('/user/post/store/user',[UserController::class,'store'])->name('management.table-user.store');
        // Route::get('/user/table-user/edit/{id}',[UserController::class,'edit'])->name('management.table-user.edit');
        // Route::put('/user/table-user/update/{id}',[UserController::class,'update'])->name('management.table-user.update');
        // Route::delete('/user/table-user/remove/{id}',[UserController::class,'delete'])->name('management.table-user.delete');
        
        // // Trashed User
        // Route::get('/user/table-user/trashed',[UserController::class,'trashed'])->name('management.table-user.trashed');
        // Route::delete('/user/table-user/trashed/delete-force/{id}',[UserController::class,'deleteForce'])->name('management.table-user.trahsed.force');
        // Route::get('/user/table-user/trashed/restore/{id}',[UserController::class,'restore'])->name('management.table-user.trahsed.restore');
        
        // //Management User Cataloge
        // Route::get('/user/cataloge-user',[UserCatalogeController::class,'index'])->name('management.cataloge.index');
        // Route::get('/user/cataloge-user/create',[UserCatalogeController::class,'create'])->name('management.cataloge.create');
        // Route::post('/user/cataloge-user/post',[UserCatalogeController::class,'store'])->name('management.cataloge.store');
        // Route::get('/user/cataloge-user/edit/{id}',[UserCatalogeController::class,'edit'])->name('management.cataloge.edit');
        // Route::put('/user/cataloge-user/update/{id}',[UserCatalogeController::class,'update'])->name('management.cataloge.update');
        
        // Route::delete('/user/cataloge-user/remove/{id}',[UserCatalogeController::class,'delete'])->name('management.cataloge.delete');
    
        // // Management Post-Cataloge
        // Route::get('post/post-cataloge',[PostCatalogeController::class,'index'])->name('management.post.cataloge.index');
        // Route::get('post/post-cataloge/edit/{id}',[PostCatalogeController::class,'edit'])->name('management.post-cataloge.edit');
        // Route::post('post/post-cataloge/store',[PostCatalogeController::class,'store'])->name('management.post-cataloge.store');
        // Route::get('post/post-cataloge/create',[PostCatalogeController::class,'create'])->name('management.post-cataloge.create');
        // Route::put('post/post-cataloge/update/{id}',[PostCatalogeController::class,'update'])->name('management.post-cataloge.update');
        // Route::delete('post/post-cataloge/remove/{id}',[PostCatalogeController::class,'destroy'])
        // ->where(['id' => '[0-9]+'])
        // ->name('management.post-cataloge.remove');
        
        // //Trashed  Post-Cataloge
        // Route::get('post/post-cataloge/trashed',[PostCatalogeController::class,'trashed'])->name('management.post.cataloge.trashed');
        // Route::get('post/post-cataloge/restore/{id}',[PostCatalogeController::class,'restore'])->name('management.post.cataloge.restore');  
        // Route::delete('post/post-cataloge/delete-force/{id}',[PostCatalogeController::class,'deleteForce'])->name('management.post.cataloge.delete-force');  
        
        // //Management Post
        // Route::get('post/index',[PostController::class,'index'])->name('management.post.index');
        // Route::get('post/edit/{id}',[PostController::class,'edit'])->name('management.post.edit');
        // Route::post('post/store',[PostController::class,'store'])->name('management.post.store');
        // Route::get('post/create',[PostController::class,'create'])->name('management.post.create');
        // Route::put('post/update/{id}',[PostController::class,'update'])->name('management.post.update');
        // Route::delete('post/remove/{id}',[PostController::class,'destroy'])
        // ->where(['id' => '[0-9]+'])
        // ->name('management.post.remove');
        // Route::get('post/trashed',[PostController::class,'trashed'])->name('management.post.trashed');
        // Route::get('post/restore/{id}',[PostController::class,'restore'])->name('management.post.restore');  
        // Route::delete('post/delete-force/{id}',[PostController::class,'deleteForce'])->name('management.post.delete-force');  
        
        
        // //permission
        // Route::get('configuration/permissions',[PermissionController::class,'index'])->name('management.configuration.permissions.index');
        // Route::get('configuration/permissions/create',[PermissionController::class,'create'])->name('management.configuration.permissions.create');
        // Route::get('configuration/permissions/edit/{id}',[PermissionController::class,'edit'])->name('management.configuration.permissions.edit');
        // Route::post('configuration/permissions/store',[PermissionController::class,'store'])->name('management.configuration.permissions.store');
        // Route::put('configuration/permissions/update/{id}',[PermissionController::class,'update'])->name('management.configuration.permissions.update');
        // Route::put('configuration/permissions/change',[PermissionController::class,'changePermision'])->name('management.configuration.permissions.change');
        
        
        // //promotion
        // Route::get('promotion',[PromotionController::class,'index'])->name('management.promotion');
        // Route::get('promotion/create',[PromotionController::class,'create'])->name('management.promotion.create');
        // Route::get('promotion/edit/{id}',[PromotionController::class,'edit'])->name('management.promotion.edit');
        // Route::post('promotion/store',[PromotionController::class,'store'])->name('management.promotion.store');
        // Route::put('promotion/update/{id}',[PromotionController::class,'update'])->name('management.promotion.update');
        // Route::delete('promotion/remove/{id}',[PromotionController::class,'remove'])->name('management.promotion.remove');
        

        // // menu
        // // Route::get('menu',[MenuCatelogeController::class,'index'])->name('management.menu.index');
        // // Route::get('menu-cateloge/create',[MenuCatelogeController::class,'create'])->name('management.menu.cateloge.create');
        // // Route::get('menu/edit/{id}',[MenuCatelogeController::class,'edit'])->name('management.menu.edit');
        // Route::post('menu-cateloge/store',[MenuCatelogeController::class,'store'])->name('management.menu.cateloge.store');
        // Route::get('menu/{id}/children',[MenuController::class,'children'])->name('management.menu.children');
        // Route::get('menu/ajax/nested-table',[MenuController::class,'nestedTable'])->name('management.menu.nested-table');
        // Route::post('menu/save/children',[MenuController::class,'saveChildren'])->name('management.menu.save.children');
        // // Route::put('menu/update',[MenuCatelogeController::class,'update'])->name('management.menu.update');
        
        // Route::get('menu',[MenuController::class,'index'])->name('management.menu.index');
        // Route::get('menu/create',[MenuController::class,'create'])->name('management.menu.create');
        // Route::get('menu/edit/{id}',[MenuController::class,'edit'])->name('management.menu.edit');
        // Route::post('menu/store',[MenuController::class,'store'])->name('management.menu.store');
        // Route::put('menu/update',[MenuController::class,'update'])->name('management.menu.update');
        // Route::put('menu/remove/{id}',[MenuController::class,'remove'])->name('management.menu.remove');
        
        
        // //Slider
        // Route::get('slider',[SliderController::class,'index'])->name('management.slider.index');
        // Route::get('slider/create',[SliderController::class,'create'])->name('management.slider.create');
        // Route::get('slider/edit/{id}',[SliderController::class,'edit'])->name('management.slider.edit');
        // Route::post('slider/store',[SliderController::class,'store'])->name('management.slider.store');
        // Route::put('slider/update/{id}',[SliderController::class,'update'])->name('management.slider.update');
        // Route::put('slider/remove/{id}',[SliderController::class,'remove'])->name('management.slider.remove');
        
        // //Widget
        // Route::get('widget/',[WidgetController::class,'index'])->name('management.widget.index');
        // Route::get('widget/create',[WidgetController::class,'create'])->name('management.widget.create');
        // Route::get('widget/edit/{id}',[WidgetController::class,'edit'])->name('management.widget.edit');
        // Route::post('widget/store',[WidgetController::class,'store'])->name('management.widget.store');
        // Route::put('widget/update/{id}',[WidgetController::class,'update'])->name('management.widget.update');
        // Route::put('widget/remove/{id}',[WidgetController::class,'remove'])->name('management.widget.remove');
        
        
        // //Cấu hình hệ thống
        // Route::get('configuration/setting',[SystemController::class,'index'])->name('management.configuration.setting.index');
        // Route::get('configuration/setting/create',[SystemController::class,'create'])->name('management.configuration.setting.create');
        // Route::get('configuration/setting/edit/{id}',[SystemController::class,'edit'])->name('management.configuration.setting.edit');
        // Route::post('configuration/setting/store',[SystemController::class,'store'])->name('management.configuration.setting.store');
        // Route::put('configuration/setting/update',[SystemController::class,'update'])->name('management.configuration.setting.update');
        // Route::get('configuration/setting/translate/{language_id}',[SystemController::class,'translate'])->name('management.configuration.setting.translate');
        // Route::post('configuration/setting/Savetranslate/{language_id}',[SystemController::class,'Savetranslate'])->name('management.configuration.setting.save.translate');
        
        
        
        // Route::get('product/cateloge',[ProductCatelogeController::class,'index'])->name('management.product.cateloge.index');
        // Route::get('product/cateloge/edit/{id}',[ProductCatelogeController::class,'edit'])->name('management.product.cateloge.edit');
        // Route::post('product/cateloge/store',[ProductCatelogeController::class,'store'])->name('management.product.cateloge.store');
        // Route::get('product/cateloge/create',[ProductCatelogeController::class,'create'])->name('management.product.cateloge.create');
        // Route::put('product/cateloge/update/{id}',[ProductCatelogeController::class,'update'])->name('management.product.cateloge.update');
        // Route::delete('product/cateloge/remove/{id}',[ProductCatelogeController::class,'destroy'])
        // ->where(['id' => '[0-9]+'])
        // ->name('management.product.cateloge.remove'); 
        
        
        // Route::get('product',[ProductController::class,'index'])->name('management.product.index');
        // Route::get('product/edit/{id}',[ProductController::class,'edit'])->name('management.product.edit');
        // Route::post('product/store',[ProductController::class,'store'])->name('management.product.store');
        // Route::get('product/create',[ProductController::class,'create'])->name('management.product.create');
        // Route::put('product/update/{id}',[ProductController::class,'update'])->name('management.product.update');
        // Route::delete('product/remove/{id}',[ProductController::class,'destroy'])
        // ->where(['id' => '[0-9]+'])
        // ->name('management.product.remove'); 
        
        // Route::get('attribute/cateloge',[AttributeCatelogeController::class,'index'])->name('management.attribute.cateloge.index');
        // Route::get('attribute/cateloge/edit/{id}',[AttributeCatelogeController::class,'edit'])->name('management.attribute.cateloge.edit');
        // Route::post('attribute/cateloge/store',[AttributeCatelogeController::class,'store'])->name('management.attribute.cateloge.store');
        // Route::get('attribute/cateloge/create',[AttributeCatelogeController::class,'create'])->name('management.attribute.cateloge.create');
        // Route::put('attribute/cateloge/update/{id}',[AttributeCatelogeController::class,'update'])->name('management.attribute.cateloge.update');
        // Route::delete('attribute/cateloge/remove/{id}',[AttributeCatelogeController::class,'destroy'])
        // ->where(['id' => '[0-9]+'])
        // ->name('management.attribute.cateloge.remove'); 
        
        // Route::get('attribute',[AttributeController::class,'index'])->name('management.attribute.index');
        // Route::get('attribute/edit/{id}',[AttributeController::class,'edit'])->name('management.attribute.edit');
        // Route::post('attribute/store',[AttributeController::class,'store'])->name('management.attribute.store');
        // Route::get('attribute/create',[AttributeController::class,'create'])->name('management.attribute.create');
        // Route::put('attribute/update/{id}',[AttributeController::class,'update'])->name('management.attribute.update');
        // Route::delete('attribute/remove/{id}',[AttributeController::class,'destroy'])
        // ->where(['id' => '[0-9]+'])
        // ->name('management.attribute.remove'); 
        // //@!new-controller-module
        
        // //order
        // Route::get('order',[OrderController::class,'index'])->name('management.order');
        //   //cancel order
        // Route::get('order/cancel',[OrderController::class,'orderCancel'])->name('management.order.cancel');
        // Route::post('order/cancel/{code}',[OrderController::class,'removeCancelOrder'])->name('management.order.stort.cancel');
        // Route::get('order/{code}',[OrderController::class,'detail'])->name('management.order.detail');
        // Route::post('order/save/detail/{code}',[OrderController::class,'uppdateInfoOrder'])->name('management.order.updateOrder');
        // // ghtk
        // Route::post('transport/ghtk/createOrder',[ShippingGHTK::class,'SubOrderAccess'])->name('ghtk.create.order');

      
        
    });


