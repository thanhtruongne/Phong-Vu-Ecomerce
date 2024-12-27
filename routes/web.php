<?php

use App\Http\Controllers\Frontend\Ajax\CartAjaxController;
use App\Http\Controllers\Frontend\Ajax\LocationAjaxController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\Ajax\ProductAjaxController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Payments\VnPayController;
use App\Http\Controllers\Frontend\Payments\MomoController;
use App\Http\Controllers\Frontend\Payments\ZaloPayController;
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





// Route::get('/ajax/dashboard/loadVariant',[ProductController::class,'loadProductVariant'])->name('loading.product.variant');
Route::get('/login',[AuthController::class,'loginForm'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('store.login');


Route::get('sign-google-login',[AuthController::class,'callBackGoogle'])->name('fe.login-sign-callback-google');
Route::get('google/callback',[AuthController::class,'handleLoginCallbackGoogle'])->name('fe.handle-callback-google');



Route::middleware(['auth'])->group(function() {
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    //account
    Route::get('/account',[AccountController::class,'account'])->name('account');
    Route::get('/account/infomation',[AccountController::class,'accountInfo'])->name('account.infomation');
    Route::get('/account/address',[AccountController::class,'accountAddress'])->name('account.address-main');
    Route::get('/account/order',[AccountController::class,'accountOrder'])->name('account.order');
    Route::post('/account/update/{id}',[AccountController::class,'update'])->name('account.update');
    Route::get('/account/order/{code}',[AccountController::class,'detailOrder'])->name('account.order.detail');
    Route::post('/account/save/address',[AccountController::class,'saveAddressUserMain'])->name('account.save-main-address-user');
    Route::post('/account/address/remove',[AccountController::class,'removeAddressMain'])->name('account.remove-main-address-user');
    Route::get('/account/address/form',[AccountController::class,'formAddressMain'])->name('account.form-main-address-user');
});

// Route::get('/ghtk',[ShippingGHTK::class,'calcShippingByGhtk'])->name('ghtk');

//Cart
Route::get('/cart',[CartController::class,'index'])->name('cart');
Route::post('/emptyCart',[CartAjaxController::class,'clearAllCart'])->name('emptyCart');
Route::post('/removeCart/{rowId}',[CartAjaxController::class,'removeItemCart'])->name('removeCart');
Route::post('/ajax/addToCart',[CartAjaxController::class,'addToCart'])->name('addToCart');
Route::post('/ajax/updateQuantityCart',[CartAjaxController::class,'updateCartQty'])->name('updateQtyCart');

//checkout
Route::get('/checkout',[CartController::class,'checkout'])->name('checkout');
// Route::post('/store/order',[CartController::class,'StoreOrder'])->name('order.store');




// // #payment
// Route::get('/confirm-payment/{code}',[FrontendCartController::class,'confirmPayment'])->name('order.confirm.payment');
// Route::post('/store/confirm-order/{code}',[FrontendCartController::class,'StoreConfirmOrder'])->name('order.store.confirm.payment');


//payment

// #VNPAY
Route::get('/vnpay_return',[VnPayController::class,'return_page'])->name('vnpay.return_page');
//Momo
Route::get('/momo_return',[MomoController::class,'return_page'])->name('momo.return_page');

//ZaloPay
Route::get('/zaloPay_return',[ZaloPayController::class,'return_page'])->name('zaloPay.return_page');


//GHTK// load provinces
Route::get('/ajax/ghtk/transportfee',[ShippingGHTK::class,'CalcShippingByGhtk'])->name('ghtk.tranport.fee');
Route::get('/ajax/location',[LocationAjaxController::class,'getLocation'])->name('location');
Route::get('/ajax/provinces',[LocationAjaxController::class,'getProvinces'])->name('provinces');


Route::get('/',[HomeController::class,'home'])->name('home');
// Route::middleware(['cacheResponse:600'])->group(function(){
Route::get('/{url}--{slug}',[HomeController::class,'detailProduct'])
->name('router.detail.slug')
->where('url','[a-zA-Z0-9-]+')
->where('slug','[a-zA-Z0-9-]+');

Route::get('/c/{slug}',[HomeController::class,'productCategory'])->name('home.category')->where('canonical', '[a-zA-Z0-9-]+');
Route::get('/get-product-by-category-filter',[ProductAjaxController::class,'getProductByCategoryParams'])->name('fe.product.category.filter');
Route::get('/ajax/load-variant',[ProductAjaxController::class,'getLoadVariantData'])->name('fe.product.load.variant');


