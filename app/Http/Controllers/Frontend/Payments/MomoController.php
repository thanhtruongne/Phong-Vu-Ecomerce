<?php

namespace App\Http\Controllers\Frontend\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MomoController
{     
    public function return_page(Request $request) {
        $secretKey = env('SECRETKEYMOMO'); 
        if (!empty($_GET)) {
            $partnerCode = $request->input('partnerCode');
            $accessKey = $request->input('accessKey');
            $orderId = $request->input('orderId');
            $localMessage = $request->input('localMessage');
            $message = $request->input('message') ;
            $transId = $request->input('transId') ;
            $orderInfo = $request->input('orderInfo');
            $amount =  $request->input('amount');
            $errorCode = $request->input('errorCode');
            $responseTime = $request->input('responseTime');;
            $requestId = $request->input('requestId');
            $extraData = $request->input('extraData');
            $payType = $request->input('payType');
            $orderType = $request->input('orderType');
            $extraData = $request->input('extraData');
            $m2signature = $request->input('signature'); //MoMo signature

        
            //Checksum
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
            "&payType=" . $payType . "&extraData=" . $extraData;


        
            $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        
            dd($m2signature == $partnerSignature,$partnerSignature,$m2signature);
            if ($m2signature == $partnerSignature) {
                if ($errorCode == '0') {
                    dd($orderId);
                    // $order = $this->orderRepositories->findCondition([[
                    //     'code','=', $orderId
                    // ]],[],['district','province','ward'],'first',[]);
                    // $payload = [
                    //     'order_id' => $order->id,
                    //     'payment_id' => $transId,
                    //     'methodName' => $orderType,
                    //     'detail_payment' => json_encode($data)
                    // ];
                    // $this->orderService->updateAfterPayment($order,$payload,'momo');
                    // return redirect()->route('account.order.detail',$order->code)->with('success','Giao dịch thành công');
                } else {  
                    return redirect()->back()->with('error','Giao dịch không thành công'); 
                }
            } else {
                return redirect()->back()->with('error','Sai thông tin người dùng và chữ ký'); 
            }
        }      
    }
  
}
