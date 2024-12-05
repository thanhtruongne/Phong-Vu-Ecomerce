<?php
namespace App\Classes\Payments\ZaloPay;
use App\Classes\Payments\ZaloPay\ZaloPayHelper;
use Illuminate\Support\Facades\Request;

  class ZaloPay {
    // public function create($orders){
    // $embeddata = '{
    //   "redirecturl" : "http://localhost:8000/zaloPay_return"
    // }'; // Merchant's data
    // $items = '[]'; // Merchant's data
    // $order = [
    //     "app_id" => env('APP_ID_ZALO'),
    //     "app_time" => round(microtime(true) * 1000), // miliseconds
    //     "app_trans_id" => $orders->code, // translation missing: vi.docs.shared.sample_code.comments.app_trans_id
    //     "app_user" => $orders->name,
    //     "item" => $items,
    //     "embed_data" => $embeddata,
    //     "amount" => $orders->total_amount,
    //     "description" => "Thanh toán đơn hàng #".$orders->code."",
    //     "bank_code" => "",
    //     'callback_url' => 'http://localhost:8000/callback'
    // ];

    // // appid|app_trans_id|appuser|amount|apptime|embeddata|item
    // $data =$order["appid"]."|".$order["apptransid"]."|".$order["appuser"]."|".$order["amount"]
    //   ."|".$order["apptime"]."|".$order["embeddata"]."|".$order["item"];

    // $order["mac"] = hash_hmac("sha256", $data, env('KEY_1_ZALO'));
    // $result = Http::postForm(Config::get()['api']['createorder'], $order);
    // // $context = stream_context_create([
    // //     "http" => [
    // //         "header" => "Content-type: application/x-www-form-urlencoded\r\n",
    // //         "method" => "POST",
    // //         "content" => http_build_query($order)
    // //     ]
    // // ]);
    // // $resp = file_get_contents('https://sbgateway.zalopay.vn/pay?order=', false, $context);
    // $result = json_decode($resp, true);
    // dd($result);
    // if($result['return_code'] == 1) {
    //   $result['code'] = '00'; $result['data'] = $result['order_url'];
    // }
    // return $result;
     
    // }

    public function create($orders){
      $orderData = ZaloPayHelper::newCreateOrderData($orders->toArray());
      $result = ZaloPayHelper::createOrder($orderData);
      if ($result["returncode"] === 1) {
         $result['code'] = '00';
         $result['data'] = $result['orderurl'];
      }
      return $result;
    }
  }
  

  
