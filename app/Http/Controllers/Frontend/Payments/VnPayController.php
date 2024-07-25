<?php

namespace App\Http\Controllers\Frontend\Payments;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Services\Interfaces\OrderServiceInterfaces as OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class VnPayController
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
      
        $this->config();
        
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
            $order = $this->orderRepositories->findCondition([[
                'code','=', $inputData['vnp_TxnRef']
            ]],[],['district','province','ward'],'first',[]);
            

            if ($inputData['vnp_ResponseCode'] == '00') {
                $this->orderService->updateAfterPayment($order,$inputData,'vnpay');
                return redirect()->route('account.order.detail',$order->code)->with('success','Giao dịch thành công');
            } 
            else {
             return redirect()->back()->with('error','Giao dịch không thành công'); 
            } 
        }
        else {
          return redirect()->back()->with('error','Chữ ký không hợ5pl lệ');
        }
        
    }
  
}
