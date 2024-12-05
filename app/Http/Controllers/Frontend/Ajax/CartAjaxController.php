<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
interface InterfaceCart {
    public function addToCart(Request $request);
    public function removeItemCart(string $id );
    public function clearAllCart();
    public function updateCartQty(Request $request);
}
class CartAjaxController extends Controller implements InterfaceCart
{  
    public function addToCart(Request $request) {
        try {
            $this->validateRequest([
                'id' => 'required'
            ],$request,[
                'id' => 'Có lỗi xảy ra !'
            ]);
            $data = [
                'id' => $request->input('id'),
                'sku_id' => $request->input(key: 'sku_id'),
                'name' => $request->input('name'),
                'qty' => +$request->input('qualnity'),
                'price' => $request->input('price'),
                'options' => [
                    'price_after_discount' => $request->input('price_after_discount'),
                    'promotion_name' => $request->input('promotion_name'),
                    'promotion_amount' => $request->input('promotion_amount'),
                    'sku_idx' =>  $request->input('sku_idx'),
                    'image' => $request->input('image'),
                    'brand' => $request->input('brand'),
                    'product_category_id' => $request->input('product_category_id'),
                    'code' => $request->input('sku_code'),
                ]
            ];
            $id_check = $request->input('sku_id') ? $request->input('sku_id') : $request->input('id');
            $item_check = $id_check.'_'.$request->input('sku_code');
            if(!session()->has('cart_check')) {
               session()->put('cart_check',[$item_check]);
            } 
            else {
              $attempt =  session()->get('cart_check');
              array_push($attempt, $item_check);
              session()->put('cart_check',$attempt);
            }
            Cart::instance('cart')->add($data);
            return response()->json(['message' => 'Thêm giỏ hàng thành công','status' => StatusReponse::SUCCESS , 'count' => Cart::instance('cart')->count()]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(),'status' => StatusReponse::ERROR]);
        }
       
    }

    public function removeItemCart(string $id ) {
        if(!$id) {
            return response()->json(['message' => 'Có lỗi xảy ra','status' => StatusReponse::ERROR]);
        }
        $flag = Cart::instance('cart')->get($id);

        //remove session applies
        $flag_key_code = $flag->sku_id ?  $flag->sku_id :  $flag->id;
        $key_code = $flag_key_code.'_'.$flag->sku_code;
        $attempt =  session()->get('cart_check');
        Arr::forget($attempt,$key_code);
        session()->put('cart_check',$attempt);

        
        Cart::instance('cart')->remove($id);

        if(Cart::content()->count() == 0) {
            session()->forget('cart_check');
        }

        return response()->json([
            'message' => 'Xóa item thành công',
            'status' => StatusReponse::SUCCESS ,
            'total' =>  $this->totalCart(Cart::instance('cart')->content()),
            'single_remove' => 1
        ]);
         
    }

    public function clearAllCart() {
        session()->forget('cart_check');
        Cart::instance('cart')->destroy();
        return response()->json(['message' => 'Xóa thành công','status' => StatusReponse::SUCCESS , 'clear_all' => 1]);
    }

    public function updateCartQty(Request $request) {
        try {
            $this->validateRequest([
                'rowId' => 'required',
                'quantity' => 'required'
            ],$request,[
                'rowId' => 'Có lỗi xảy ra !',
                'quantity' => 'Số lượng sản phẩm lỗi !'
            ]);
            $item = Cart::instance('cart')->update($request->rowId , ['qty' => $request->quantity]);
            $price = $item->options->price_after_discount ? $item->options->price_after_discount * $item->qty : $item->price * $item->qty;
            $total = $this->totalCart(Cart::instance('cart')->content());
            
            return response()->json([
             'message' => 'Thành công',
             'status' => StatusReponse::SUCCESS ,
             'price' => $price,
             'total' => $total
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(),'status' => StatusReponse::ERROR]);
        }
    }

 
  
}
