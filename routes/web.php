<?php

use App\Http\Controllers\Backend\Auth\AuthencateController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\HomeController;
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


Route::get('/login',[AuthController::class,'index'])->name('login');
//admin login
Route::get('/private/system/login',[AuthencateController::class,'index'])->name('private.system.login');
Route::post('/private/system/post-login',[AuthencateController::class,'login'])->name('private-system.post.login');


Route::get('/',[HomeController::class,'home'])->name('home');