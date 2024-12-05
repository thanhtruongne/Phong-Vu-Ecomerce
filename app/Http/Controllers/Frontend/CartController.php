<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Payments\Momo;
use App\Classes\Payments\VnPay;
use App\Classes\Payments\ZaloPay\ZaloPay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ConfirmOrder;
use App\Http\Requests\OrderStore;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;;

interface InternfaceCartController {
   public function index(Request $request);
   public function confirmPayment(string $code = '');
   public function StoreConfirmOrder(ConfirmOrder $request,string $code = '');
   public function checkout();
   public function StoreOrder(OrderStore $request);
}
class CartController extends Controller implements InternfaceCartController
{  

   public function index(Request $request) {
      $carts = Cart::instance('cart')->content();    
      $total = $this->totalCart($carts);
      // dd($carts);
      return view('Frontend.page.Cart.cart',compact( 'carts','total'));
   }

   public function confirmPayment(string $code = '') {
      // $order = $this->orderRepositories->findCondition([[
      //    'code','=',$code
      // ]],[],['province','district','ward'],'first',[]);
      // $config = [
      //    'js' => [
      //      'frontend/js/library/payment.js',
      //      'frontend/js/library/custom.js'
      //    ],
      // ];
      // $Seo = $this->Seo;
      return view('Frontend.page.Payments.confirmOrder',compact('order','config','Seo'));
   }
  

   public function checkout() {
      $carts = Cart::instance('cart')->content();   
      if(isset($carts) &&  count($carts) == 0){
         abort(404);
      }
      $total = $this->totalCart($carts);
      // $provinces = json_decode(Redis::get('provinces'),true);
      return view('Frontend.page.Payments.checkout',compact('carts','total')); 
   }


   public function StoreOrder(OrderStore $request) {
      // if(!Auth::guard('web')->check() && !Cookie::get('guest_cookie')) {
      //    Cookie::queue(Cookie::forget('guest_cookie'));
      //    Cookie::queue(Cookie::make('guest_cookie',time().'_'.$request->input('email'),60 * 24 * 7));
      // }
     
      // $order = $this->cartService->createOrder($request);
      // Cart::instance('cart')->destroy();
      // if(!empty($order) && !is_null($order)) {
      //    // handle phần payment nếu success thì redirect thẳng vào detail order;
      //    $response =  $this->orderPaymentCase($order);   
         
      //    if($response['code'] == '00'){
      //       return redirect()->away($response['data']);
      //    }
      //    return redirect()->route('home')->with('success','Tạo đơn hàng thành công');
      // }
      // return redirect()->route('home')->with('error','Có lỗi xảy ra');
   }

   public function StoreConfirmOrder(ConfirmOrder $request,string $code = '')  {
      // $order = $this->orderRepositories->findCondition([[
      //    'code','=',$code
      // ]],[],[],'first',[]);
      // if($request->input('method') != $order->method) {
      //    $this->orderRepositories->UpdateWhere([[
      //       'code','=',$code
      //    ]],['method' => $request->input('method')]);
      //     //override method order để switch dc case;
      //    $order->method = $request->input('method');   
      // } 
      //  //tránh trường hợp đơn hàng tồn tại    
      // // $order->code = "".time()  + rand(200,50000)."";
      // if(!empty($order) && !is_null($order)) {
      //    // handle phần payment nếu success thì redirect thẳng vào detail order;
      //    $response =  $this->orderPaymentCase($order);   
      //    if(empty($response['code'])) {
      //       redirect()->route('order.confirm.payment',$order->code)->with('error','Giao dịch thất bại');
      //    }
         
      //    else if($response['code'] == '00'){
      //       return redirect()->away($response['data']);
      //    }
      //    else return redirect()->route('home')->with('success','Tạo đơn hàng thành công');
      // }
      // return redirect()->route('home')->with('error','Có lỗi xảy ra');
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
