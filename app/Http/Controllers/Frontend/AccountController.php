<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Repositories\OrderRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
class AccountController extends BaseController
{
    protected $orderRepositories;

    public function __construct(OrderRepositories $orderRepositories){
        parent::__construct();
        // $this->checkGuestCookie($orderRepositories);
        $this->orderRepositories = $orderRepositories;
    }

    public function account() {
        return view('Frontend.page.Accounts.index');
    }
    public function accountOrder() {
        $config = [
            'js' => [
              'frontend/js/library/custom.js'
            ],
        ];
        $Seo = $this->Seo;

        $order = $this->orderRepositories->findCondition([[
            'customer_id','=',Auth::user()->id
        ]],[],[],'multiple',[]);
        return view('Frontend.page.Accounts.orders.order',compact('Seo','config','order'));
    }

    public function guestOrder() {
        if(empty(Cookie::get('guest_cookie'))) {
            return abort(403);
        };
        $config = [
            'js' => [
              'frontend/js/library/custom.js'
            ],
        ];
        $Seo = $this->Seo;
        $emailCheck =  explode('_',Cookie::get('guest_cookie'))[1] ;

        $order = $this->orderRepositories->findCondition([[
            'email','=',$emailCheck,
            'customer_id','=',null
        ]],[],[],'multiple',[]);
        return view('Frontend.page.Accounts.guests.order',compact('Seo','config','order'));
    }
    public function guestOrderDetail(string $code = '') {
        if(empty(Cookie::get('guest_cookie'))) return abort(403);
        $config = [
            'js' => [
              'frontend/js/library/custom.js'
            ],
        ];
        $Seo = $this->Seo;
        $email = explode('_',Cookie::get('guest_cookie'))[1];
        $order = $this->orderRepositories->findCondition([
            [
                'code','=',$code
            ],
            [
                'email','=',$email
            ],
            [
                'customer_id','=',null
            ]
        ],[],['province','ward','district'],'first',[]);
        if(is_null($order)) return abort(403);
        return view('Frontend.page.Accounts.guests.detail',compact('Seo','config','order'));
    }
    public function detailOrder(string $code = '') {
        $config = [
            'js' => [
              'frontend/js/library/custom.js'
            ],
        ];
        $Seo = $this->Seo;
        $order = $this->orderRepositories->findCondition([
            [
                'code','=',$code
            ],
            [
                'email','=', Auth::user()->email
            ],
            [
                'customer_id','=', Auth::user()->id
            ]
        ],[],['province','ward','district'],'first',[]);
        if(is_null($order)) return abort(403);
        return view('Frontend.page.Accounts.orders.detail',compact('Seo','config','order'));
    }



}
