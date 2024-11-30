<?php

use App\Http\Controllers\Backend\Ajax\CartController;
use App\Http\Controllers\Backend\Ajax\LocationController;
use App\Http\Controllers\Backend\Ajax\ProductController;
use App\Http\Controllers\Backend\Auth\AuthencateController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\Ajax\ProductAjaxController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\CartController as FrontendCartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Payments\VnPayController;
use App\Http\Controllers\Frontend\Payments\MomoController;
use App\Http\Controllers\Frontend\Payments\ZaloPayController;
use App\Http\Controllers\Frontend\RouterController;
use App\Http\Controllers\Frontend\Shipping\ShippingGHTK;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// AJAX
//load vairant





Route::get('/ajax/dashboard/loadVariant',[ProductController::class,'loadProductVariant'])->name('loading.product.variant');
//add to Cart
Route::get('/ajax/dashboard/addToCart',[CartController::class,'addToCart'])->name('addToCart');
Route::get('/ajax/dashboard/updateQuantityCart',[CartController::class,'updateCartQty'])->name('updateQtyCart');
Route::get('/ajax/dashboard/location',[LocationController::class,'getLocation'])->name('location');



Route::get('/login',[AuthController::class,'login'])->name('login')->middleware('guest:user');
Route::post('/store-login',[AuthController::class,'StoreLogin'])->name('store.login'); 

Route::middleware(['auth'])->group(function() {
    Route::post('/logout',[AuthController::class,'logout'])->name('logout'); 
    //account 
    Route::get('/account',[AccountController::class,'account'])->name('account'); 
    Route::get('/account/infomation',[AccountController::class,'accountInfo'])->name('account.infomation'); 
    Route::post('/account/update/{id}',[AccountController::class,'update'])->name('account.update');
    Route::get('/account/order',[AccountController::class,'accountOrder'])->name('account.order'); 
    Route::get('/account/order/{code}',[AccountController::class,'detailOrder'])->name('account.order.detail'); 
});

Route::get('/',[HomeController::class,'home'])->name('fe.home');



// Route::get('/ghtk',[ShippingGHTK::class,'calcShippingByGhtk'])->name('ghtk');
//guest
Route::get('/guest/order',[AccountController::class,'guestOrder'])->name('guest.order'); 
Route::get('/guest/order/{code}',[AccountController::class,'guestOrderDetail'])->name('guest.order.detail');


//Cart
Route::get('/cart',[FrontendCartController::class,'index'])->name('cart');
Route::get('/removeCart/{rowId}',[FrontendCartController::class,'removeItem'])->name('removeCart');
Route::get('/emptyCart',[FrontendCartController::class,'emptyCart'])->name('emptyCart');

//checkout
Route::get('/checkout',[FrontendCartController::class,'checkout'])->name('checkout'); 
Route::post('/store/order',[FrontendCartController::class,'StoreOrder'])->name('order.store'); 
// #payment
Route::get('/confirm-payment/{code}',[FrontendCartController::class,'confirmPayment'])->name('order.confirm.payment'); 
Route::post('/store/confirm-order/{code}',[FrontendCartController::class,'StoreConfirmOrder'])->name('order.store.confirm.payment'); 



//payment

// #VNPAY
Route::get('/vnpay_return',[VnPayController::class,'return_page'])->name('vnpay.return_page');
//Momo
Route::get('/momo_return',[MomoController::class,'return_page'])->name('momo.return_page');

//ZaloPay
Route::get('/zaloPay_return',[ZaloPayController::class,'return_page'])->name('zaloPay.return_page');


//GHTK
Route::get('/ajax/ghtk/transportfee',[ShippingGHTK::class,'CalcShippingByGhtk'])->name('ghtk.tranport.fee');




Route::get('/',[HomeController::class,'home'])->name('home');
// Route::middleware(['cacheResponse:600'])->group(function(){
Route::get('{canonical}---{slug}',[RouterController::class,'detail'])->name('router.detail.slug')
->where('canonical','[a-zA-Z0-9-]+')->where('slug','[a-zA-Z0-9-]+');

Route::get('/c/{slug}',[HomeController::class,'productCategory'])->name('home.category')->where('canonical', '[a-zA-Z0-9-]+');
Route::get('/get-product-by-category-filter',[ProductAjaxController::class,'getProductByCategoryParams'])->name('fe.product.category.filter');

