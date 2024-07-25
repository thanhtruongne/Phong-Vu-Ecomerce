<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Events\OrderPayment;
use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepositories;
use App\Repositories\OrderRepositories;
use App\Services\Interfaces\CartServiceInterfaces as CartService;
use App\Services\Interfaces\OrderServiceInterfaces as OrderService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Flasher\Noty\Prime\NotyInterface;
class CartController extends Controller
{
    protected $cartService,$orderService,$orderRepositories;

    public function __construct(CartService $cartService,OrderService $orderService,OrderRepositories $orderRepositories) {
      $this->cartService = $cartService;
      $this->orderService = $orderService;
      $this->orderRepositories = $orderRepositories;

    }
  
 
    public function addToCart(Request $request) {
      $data = $this->cartService->add($request);
      return response()->json([
        'message' => $data == true ?  'Thêm giỏ hàng thành công' : 'Thao tác thất bại',
        'errCode' => $data == true ? 2 : -1,
        'cartCount' => count(Cart::instance('cart')->content())
        ]);
    }
    public function updateCartQty(Request $request) {
      $flag = $this->cartService->updateQty($request);
      return response()->json($flag);
    }


    public function ChangeAjaxOrder(Request $request) {
        $payload = [
          $request->input('name') => $request->input('val')
        ];
        $flag = $this->orderService->updateMethod($payload,$request->input('code'));
        if($flag) {
          return response()->json([
            'code' => 0,
            'message' => 'Thay đổi thành công'
          ]);
        }
        return response()->json([
          'code' => -2,
          'message' => 'Có lỗi xảy ra !'
        ]);
        
    }


    public function paymentsendInvoice(Request $request){
       try
       {
        $order = $this->orderRepositories->findCondition([
          ['code','=',$request->input('code')],['email','=',$request->input('email')]
        ],[],[],'first',[]);
          event(new OrderPayment($order));
          
          return response()->json([
            'code' => 0,
            'message' => 'Gủi mail thành công'
          ]);
       }
       catch(Exception $e){
          return response()->json([
            'code' => -2,
            'message' => $e->getMessage()
          ]);
       }
    }

}
