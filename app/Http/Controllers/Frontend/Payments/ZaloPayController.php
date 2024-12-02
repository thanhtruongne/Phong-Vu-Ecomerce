<?php

namespace App\Http\Controllers\Frontend\Payments;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositories;
use App\Services\Interfaces\OrderServiceInterfaces as OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class ZaloPayController
{  
    protected $orderRepositories,$orderService; 
    public function __construct(OrderRepositories $orderRepositories,OrderService $orderService){
        $this->orderService = $orderService;
        $this->orderRepositories = $orderRepositories;
    }
    
    public function return_page(Request $request) {
        $app_trans_id = $request->input('apptransid');  // Input your app_trans_id
        $data = $request->input('appid')."|".$app_trans_id."|".env('KEY_1_ZALO'); // app_id|app_trans_id|key1
        $params = [
          "app_id" => $request->input('appid'),
          "app_trans_id" => $app_trans_id,
          "mac" => hash_hmac("sha256", $data, env('KEY_1_ZALO'))
        ];
      
        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($params)
            ]
        ]);
        
        $resp = file_get_contents('https://sb-openapi.zalopay.vn/v2/query', false, $context);
        $result = json_decode(json: $resp, true);
   
        if($result['return_code'] == 1) {
            $code = explode('_',$app_trans_id);
            
            $order = $this->orderRepositories->findCondition([[
                'code','=', $code[1]
            ]],[],['district','province','ward'],'first',[]);
            $payload = [
                'order_id' => $order->id,
                'payment_id' => $result['zp_trans_id'],
                'methodName' => $request->input('bankcode'),
                'detail_payment' => json_encode($request->all())
            ];
            $this->orderService->updateAfterPayment($order,$payload,'zalo');
            return redirect()->route( Auth::guard('web')->check() ? 'account.order.detail' : 'guest.order.detail' 
            ,$order->code)->with('success',$result['return_message']);
        }
        else {
            return redirect()->back()->with('error',$result['return_message']);
        }
        
    }

    public function callback(Request $request) {
        // PHP Version 7.3.3
        $result = [];
        try{
            $key2 = "eG4r0GcoNtRGbO8";
          $postdata = file_get_contents('php://input');
          $postdatajson = json_decode($postdata, true);
          $mac = hash_hmac("sha256", $postdatajson["data"], $key2);
        
          $requestmac = $postdatajson["mac"];
        
          // kiểm tra callback hợp lệ (đến từ ZaloPay server)
          if (strcmp($mac, $requestmac) != 0) {
            // callback không hợp lệ
            $result["return_code"] = -1;
            $result["return_message"] = "mac not equal";
          } else {
            // thanh toán thành công
            // merchant cập nhật trạng thái cho đơn hàng
            $datajson = json_decode($postdatajson["data"], true);
            // echo "update order's status = success where app_trans_id = ". $dataJson["app_trans_id"];
        
            $result["return_code"] = 1;
            $result["return_message"] = "success";
          }
        }catch(Exception $e) {

            $result["return_code"] = 0; // ZaloPay server sẽ callback lại (tối đa 3 lần)
            $result["return_message"] = $e->getMessage();
        } 
        // thông báo kết quả cho ZaloPay server
        echo json_encode($result);die();
    }


}
