<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Payments\Momo;
use App\Classes\Payments\VnPay;
use App\Classes\Payments\ZaloPay\ZaloPay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ConfirmOrder;
use App\Http\Requests\OrderStore;
use App\Models\Province;
use App\Repositories\OrderRepositories;
use Illuminate\Support\Str;
use App\Services\Interfaces\CartServiceInterfaces as CartService;
use App\Services\ProductService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class CartController extends BaseController
{  
   protected $productService,$cartService,$orderRepositories;

   public function __construct(ProductService $productService,CartService $cartService,OrderRepositories $orderRepositories) {
      $this->init();
      $this->productService = $productService;
      $this->cartService = $cartService;
      $this->orderRepositories = $orderRepositories;
      parent::__construct();
   }

   private function init() {
      if(Cookie::get('guest_cookie') == null || !Auth::check()) return back();
   }

   public function index(Request $request) {
      $config = [
         'js' => [
           'frontend/js/library/cart.js'
         ],
      ];
      $Seo = $this->Seo;
      // Cart::destroy();
      $carts = Cart::instance('cart')->content();    
      $carts = $this->productService->ComplieCartService($carts);
      $total = $this->totalCart($carts);
      return view('Frontend.page.Cart.cart',compact('Seo','carts','config','total'));
   }

   private function totalCart($carts) {
      $total = 0;
      foreach($carts as $item) {
         $total +=  +$item->options->priceSale * $item->qty ?? $item->price * $item->qty;
      }
      return $total;
   }
   public function removeItem(string $rowId) {
      $flag = $this->cartService->removeItem($rowId);
      return redirect()->back();
   }

   public function emptyCart() {
      $flag = $this->cartService->clearAllCart();
      return redirect()->back();
   }

   public function confirmPayment(string $code = '') {
      $order = $this->orderRepositories->findCondition([[
         'code','=',$code
      ]],[],['province','district','ward'],'first',[]);
      $config = [
         'js' => [
           'frontend/js/library/payment.js',
           'frontend/js/library/custom.js'
         ],
      ];
      $Seo = $this->Seo;
      return view('Frontend.page.Payments.confirmOrder',compact('order','config','Seo'));
   }
  

   public function checkout() {
      if(Cart::instance('cart')->count() == 0) return abort(404);
      $config = [
         'js' => [
           'frontend/js/library/payment.js',
           'frontend/js/library/custom.js'
         ],
      ];
      $Seo = $this->Seo;
      $carts = Cart::instance('cart')->content();   
      $carts = $this->productService->ComplieCartService($carts);
      $total = $this->totalCart($carts);
      if(!Redis::get('provinces')) Redis::set('provinces',Province::all());
      $provinces = json_decode(Redis::get('provinces'),true);
      return view('Frontend.page.Payments.checkout',compact('Seo','config','carts','total','provinces')); 
   }


   public function StoreOrder(OrderStore $request) {
      if(!Auth::guard('web')->check() && !Cookie::get('guest_cookie')) {
         Cookie::queue(Cookie::forget('guest_cookie'));
         Cookie::queue(Cookie::make('guest_cookie',time().'_'.$request->input('email'),60 * 24 * 7));
      }
     
      $order = $this->cartService->createOrder($request);
      Cart::instance('cart')->destroy();
      if(!empty($order) && !is_null($order)) {
         // handle phần payment nếu success thì redirect thẳng vào detail order;
         $response =  $this->orderPaymentCase($order);   
         
         if($response['code'] == '00'){
            return redirect()->away($response['data']);
         }
         return redirect()->route('home')->with('success','Tạo đơn hàng thành công');
      }
      return redirect()->route('home')->with('error','Có lỗi xảy ra');
   }

   public function StoreConfirmOrder(ConfirmOrder $request,string $code = '')  {
      $order = $this->orderRepositories->findCondition([[
         'code','=',$code
      ]],[],[],'first',[]);
      if($request->input('method') != $order->method) {
         $this->orderRepositories->UpdateWhere([[
            'code','=',$code
         ]],['method' => $request->input('method')]);
          //override method order để switch dc case;
         $order->method = $request->input('method');   
      } 
       //tránh trường hợp đơn hàng tồn tại    
      // $order->code = "".time()  + rand(200,50000)."";
      if(!empty($order) && !is_null($order)) {
         // handle phần payment nếu success thì redirect thẳng vào detail order;
         $response =  $this->orderPaymentCase($order);   
         if(empty($response['code'])) {
            redirect()->route('order.confirm.payment',$order->code)->with('error','Giao dịch thất bại');
         }
         
         else if($response['code'] == '00'){
            return redirect()->away($response['data']);
         }
         else return redirect()->route('home')->with('success','Tạo đơn hàng thành công');
      }
      return redirect()->route('home')->with('error','Có lỗi xảy ra');
   }

  private function orderPaymentCase($order) {
   $response = '';
      switch($order->method) {
          case 'zalo' :
            $response = $this->zalo($order);
              break;
          case 'vnpay' :
               $response =  $this->vnpay($order);
                break;
          case 'momo' : 
                $response =  $this->momo($order);
              break;
          case 'cod' :
              break;       
      }

      return $response;
  }

  private function vnpay($order) {
      $vnpay = new VnPay();
      $response = $vnpay->payments($order);
      return $response;
  }

   private function momo($order) {
      $momo = new Momo();
      $response = $momo->payments($order);
      return $response;
   }
   private function zalo($order) {
      $momo = new ZaloPay();
      $response = $momo->create($order);
      return $response;
   }
}
