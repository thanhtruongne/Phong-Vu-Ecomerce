<?php

namespace Modules\Order\Http\Controllers;

use App\Enums\Enum\OrderEnum;
use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Classes\Payments\Momo;
use App\Classes\Payments\VnPay;
use App\Classes\Payments\ZaloPay\ZaloPay;
use Modules\Order\Entities\Orders;
use Modules\Order\Jobs\OrderSync;
interface OrderInterface {
    public function createOrder(Request $request);

    public function handleCreate($request,$carts);
}
class OrderController extends Controller implements OrderInterface
{
    public function createOrder(Request $request){
        $this->validateRequest([
            'total_amount' => 'required',
            'freight_amount' => "required",
            'receiver_name' => 'required',
            'receiver_province' => 'required',
            'receiver_phone' => 'required',
            'receiver_district' => 'required',
            'receiver_ward' => 'required',
            'receiver_email' => 'required|email',
            'receiver_address' => 'required',
            'method_payment' => 'required'
        ],$request,Orders::getAttributeName());
        $carts = Cart::instance('cart')->content();
        $order = $this->handleCreate($request,$carts);

        // redirect thanh toán;
        if(!empty($order) && !is_null($order)) {
            Cart::instance('cart')->destroy(); // clear cart
            $response =  $this->orderPaymentCase($order,$request->method_payment);   
            if($response['code'] === '00'){
                return response()->json(['message' => 'Redirect thanh toán','status' => StatusReponse::SUCCESS,'url' => $response['data']]);
            }
        }
    }

    public function handleCreate($request,$carts) {
        \DB::beginTransaction();
        try {
            $model = $this->store($request);
            OrderSync::dispatch($model,$carts);
            \DB::commit();
            return $model;
        } catch (\Throwable $th) {
            \DB::rollBack();
            return response()->json(['message' => $th->getMessage(),'status' => StatusReponse::ERROR]);
        }
    }
    private function store($request){
        $model = Orders::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->user_id = auth()->id() ?? 1;
        $model->code = (string)\Str::uuid();;
        $model->create_time = \Carbon::now();
        $model->pay_type = OrderEnum::PAYTYPE;
        $model->delivery_company = OrderEnum::GHTKCOMPANY;
        $model->delivery_code = OrderEnum::GHTKCODE;
        $model->pay_type = OrderEnum::PAYTYPE;
        $model->status = OrderEnum::ORDER_PENDING_PAYMENT;
        $model->confirm_status = OrderEnum::PENDINGCONFIRM;
        $model->delete_status = OrderEnum::PENDINGCONFIRM;
        $model->save();
 
        return $model;
    }
    private function orderPaymentCase($order,string $method = '') {
        $response = '';
           switch($method) {
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



