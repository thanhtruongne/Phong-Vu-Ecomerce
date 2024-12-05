<?php

namespace App\Http\Controllers\Frontend\Payments;

use App\Enums\Enum\OrderEnum;
use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Order\Entities\Orders;
use Modules\Order\Events\OrderSendmail;

class VnPayController extends Controller
{  
    
    public function return_page(Request $request) {
        try {
            $vnp_SecureHash = $request->input('vnp_SecureHash');
            $inputData = array();
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }
            $secureHash = hash_hmac('sha512', $hashData, env('SERECT_KEY'));
            if ($secureHash == $vnp_SecureHash) {
                $order = Orders::where('code',$request->vnp_TxnRef)->first();
                if ($inputData['vnp_ResponseCode'] == '00' && $order) { 
                    $order->order_payment()->create([
                        'method_payment' => 'vnpay',
                        'label_id' => $request->vnp_TmnCode,
                        'unit_payment'=> $request->vnp_CardType,
                        'unit_transport'=> $request->vnp_BankCode,
                        'partner_id'=> $request->vnp_BankTranNo,
                        'detail_payment' => $inputData,
                    ]);
                    $order->status = OrderEnum::ORDER_WAIT_DELI;
                    $order->confirm_status = OrderEnum::CONFIRM;
                    $order->payment_time = \Carbon::now();
                    $order->save();
    
                    //send mail
                    event(new OrderSendmail($order));
                    
    
                   return redirect(route('home'))->with('message','Giao dịch thành công');
                } else {
                    return response()->json(['message' => 'Giao dịch không thành công','status' => StatusReponse::ERROR]);
                } 
            }
            else {
              return response()->json(['message' => 'Thanh toán không hợp lệ','status' => StatusReponse::ERROR]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(),'status' => StatusReponse::ERROR]);
        }

       
        
    }
  
}
