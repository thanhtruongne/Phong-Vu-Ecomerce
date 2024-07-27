<?php

namespace App\Http\Controllers\Frontend\Payments;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Services\Interfaces\OrderServiceInterfaces as OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class MomoController
{  
    protected $orderRepositories,$orderService;
    private $url , $return_url, $exipre;   
    public function __construct(OrderRepositories $orderRepositories,OrderService $orderService){
        $this->orderService = $orderService;
        $this->orderRepositories = $orderRepositories;
    }
    private function config() {
      $this->exipre =  date('YmdHis',strtotime('+30 minutes',strtotime(date("YmdHis"))));
      $this->url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
      $this->return_url = 'http://localhost:8000/vnpay_return';
    }
    
    public function return_page(Request $request) {
        $secretKey = env('SERECT_KEY_MOMO'); //Put your secret key in there
        
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
            $data = [
                'orderId' => $request->input('orderId'),
                'localMessage' => $request->input('localMessage'),
                'message' => $request->input('message') ,
                'transId' => $request->input('transId') ,
                'orderInfo' => $request->input('orderInfo'),
                'amount' =>  $request->input('amount'),
                'errorCode' => $request->input('errorCode'),
                'responseTime' => $request->input('responseTime'),
                'requestId' => $request->input('requestId'),
                'extraData' => $request->input('extraData'),
                'payType' => $request->input('payType'),
                'orderType' => $request->input('orderType'),
                'extraData' => $request->input('extraData'),
                'm2signature' => $request->input('signature'), //MoMo signature
            ];
        
            //Checksum
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
                "&payType=" . $payType . "&extraData=" . $extraData;
        
            $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        
            echo "<script>console.log('Debug huhu Objects: " . $rawHash . "' );</script>";
            echo "<script>console.log('Debug huhu Objects: " . $secretKey . "' );</script>";
            echo "<script>console.log('Debug huhu Objects: " . $partnerSignature . "' );</script>";
        
        
            if ($m2signature == $partnerSignature) {
                if ($errorCode == '0') {
                    $order = $this->orderRepositories->findCondition([[
                        'code','=', $orderId
                    ]],[],['district','province','ward'],'first',[]);
                    $payload = [
                        'order_id' => $order->id,
                        'payment_id' => $transId,
                        'methodName' => $orderType,
                        'detail_payment' => json_encode($data)
                    ];
                    $this->orderService->updateAfterPayment($order,$payload,'momo');
                    if(Auth::guard('web')->check()){
                        return redirect()->route('account.order.detail',$order->code)->with('success','Giao dịch thành công');
                    }
                    else  return redirect()->route('guest.order.detail',$order->code)->with('success','Giao dịch thành công');
                   
                } else {  
                    return redirect()->back()->with('error','Giao dịch không thành công'); 
                }
            } else {
                return redirect()->back()->with('error','Sai thông tin người dùng và chữ ký'); 
            }
        }      
    }
  
}
