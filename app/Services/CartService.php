<?php

namespace App\Services;

use App\Classes\Payments\VnPay;
use App\Enums\Enum\Order;
use App\Enums\Enum\OrderEnum;
use App\Events\OrderSendMail;
use App\Repositories\BaseRepositories;

use App\Repositories\OrderRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\CartServiceInterfaces;
use App\Services\Interfaces\ProductServiceInterfaces as ProductService;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class CartService implements CartServiceInterfaces
{
    protected $productService,$orderRepositories;
    
    public function __construct(ProductService $productService,OrderRepositories $orderRepositories){
        $this->productService = $productService;
        $this->orderRepositories = $orderRepositories;
    }
    public function add($request) {
        try {
            if($request->has('id')) {
                $data = [
                    'id' => $request->input('id'),
                    'name' => $request->input('name'),
                    'qty' => +$request->input('qualnity'),
                    'price' => $request->input('price'),
                    'options' => [
                        'discountValue' => $request->input('discountValue'),
                        'discountType' => $request->input('discountType'),
                        'priceSale' => $request->input('priceSale'),
                        'attribute_id' => $request->input('attribute'),
                        'attributeName' => $request->input('attributeName')
                    ]
                ];

                Cart::instance('cart')->add($data);
                return true;
            }
       } catch (\Throwable $th) {
          $th->getMessage();die();
          return false;
       }
    }


    public function removeItem(string $rowId) {
        if(!is_null($rowId)) {
           $flag = Cart::instance('cart')->remove($rowId); 
           return true;
        }
       
    }

    public function updateQty($request) {
        try {
           $flag = Cart::instance('cart')->update($request->rowId , ['qty' => $request->quantity]);
           $price =  +$flag->options->priceSale  * $flag->qty ?? $flag->price_previous * $flag->qty ;
           $carts = $this->productService->ComplieCartService(Cart::instance('cart')->content());
 
           $total = $this->totalCart($carts);
           return [
              'price' => convert_price($price,true),
              'total' => $total['total']
           ];   
        } catch (\Throwable $th) {
            $th->getMessage();
            return false;
        }
    }

    public function clearAllCart() {
        try {
            Cart::instance('cart')->destroy();
            return true;
         } catch (\Throwable $th) {
             $th->getMessage();
             return false;
         }
    }
    private function totalCart($carts) {
        $total = 0;$countCart = 0;
        foreach($carts as $item) {
           $total +=  +$item->options->priceSale * $item->qty ?? $item->price * $item->qty;
           $countCart++;
        }
        return [
            'total' => $total,
            'countCart' => $countCart
        ];
    }
    


    public function createOrder($request) {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token']);
            $carts = $this->productService->ComplieCartService(Cart::instance('cart')->content());
            $data = $this->HandleStoreOrder($payload,$carts);
            $order =  $this->orderRepositories->create($data);     
            $this->createProductOrder($carts,$order);     

            event(new OrderSendMail($order));
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());die();
        }
    }
    
    private function HandleStoreOrder($payload,$cart) { 
        if(!Auth::check()) {
            $payload['guest_cookie'] = Cookie::get('guest_cookie') ?: time().'_'.$payload['email'];
        }
        else if(Auth::guard('web')->check()) $payload['customer_id'] = Auth::guard('web')->user()->id;
        $payload['code'] = time().rand(0,123241);
        $payload['payment'] = OrderEnum::UNPAID;
        $payload['confirm'] = OrderEnum::PENDINGCONFIRM;
        $payload['shipping'] = OrderEnum::SHIPPINGBEGIN;
        $payload['cart'] = $this->totalCart($cart);
        return $payload;
    }
    
    private function createProductOrder($carts,$order) {
        if($order->id > 0) {
            $item = [];
            foreach($carts as $key => $cart) {
                $uuid = explode('_',$cart->id);
                $item[] = [
                    'order_id' => $order->id,
                    'product_id' => $uuid[0] ?? null,
                    'uuid' => $uuid[1] ?? null,
                    'name' => $cart->name,
                    'qty' => $cart->qty,
                    'price' => +$cart->price,
                    'priceSale' => +$cart->options->priceSale,
                    'promotion' => json_encode($cart->options),
                    'option' => json_encode($cart)
                ];
            }
            $order->Order_products()->sync($item);
        }
    }




}
