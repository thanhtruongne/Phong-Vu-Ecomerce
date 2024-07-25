<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStore;
use App\Models\Province;
use App\Repositories\OrderRepositories;
use App\Repositories\SliderRepositories;
use App\Repositories\SystemRepositories;
use App\Services\Interfaces\CartServiceInterfaces as CartService;
use App\Services\Interfaces\WidgetServiceInterfaces as  WidgetService;
use App\Services\ProductService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AccountController
{  
    protected $userRepositories,$orderRepositories;
  
    public function UpdateAccount(Request $request) {
         
    }
}
