<?php 

namespace App\Classes\Payments;
class Momo {

    private $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
    private $returnUrl = "http://localhost:8000/momo_return";
    private $notifyurl = "http://localhost:8000/atm/ipn_momo.php";
    
    public function payments($order) {    
        if (!empty($_POST)) {
                $partnerCode = env('PARTNERKEY');
                 $accessKey = env('ACCRESSKEY');
                 $serectkey = env('SERECT_KEY_MOMO');
                 $orderid = $order->code;
                 $orderInfo = $order->desc ?? 'Thanh toán qua Momo #'.$order->code;
                 $amount = "".$order->cart['total'] + $order->shipping_options['total']."";
                 $bankCode = "";
                 $returnUrl = $this->returnUrl;
                 $requestId = time()."";
                 $requestType = "payWithMoMoATM";
                 $extraData = "";
                 //before sign HMAC SHA256 signature
                 $rawHashArr =  array(
                                'partnerCode' => $partnerCode,
                                'accessKey' => $accessKey,
                                'requestId' => $requestId,
                                'amount' => $amount,
                                'orderId' => $orderid,
                                'orderInfo' => $orderInfo,
                                'bankCode' => $bankCode,
                                'returnUrl' => $returnUrl,
                                'notifyUrl' => $this->notifyurl,
                                'extraData' => $extraData,
                                'requestType' => $requestType
                                );
                 // echo $serectkey;die;
                 $rawHash = "partnerCode=".$partnerCode."&accessKey=".$accessKey."&requestId=".$requestId."&bankCode=".$bankCode."&amount=".$amount."&orderId=".$orderid."&orderInfo=".$orderInfo."&returnUrl=".$returnUrl."&notifyUrl=".$this->notifyurl."&extraData=".$extraData."&requestType=".$requestType;
                 $signature = hash_hmac("sha256", $rawHash, $serectkey);
        
                 $data =  array('partnerCode' => $partnerCode,
                                'accessKey' => $accessKey,
                                'requestId' => $requestId,
                                'amount' => $amount,
                                'orderId' => $orderid,
                                'orderInfo' => $orderInfo,
                                'returnUrl' => $returnUrl,
                                'bankCode' => $bankCode,
                                'notifyUrl' => $this->notifyurl,
                                'extraData' => $extraData,
                                'requestType' => $requestType,
                                'signature' => $signature);
                 $result = execPostRequest($this->endpoint, json_encode($data));
                 $jsonResult = json_decode($result,true);  // decode json
                 if($jsonResult['errorCode'] == 0) {
                    $jsonResult['code'] = '00';
                    $jsonResult['data'] = $jsonResult['payUrl'];
                 }               
                 return $jsonResult;
    }
    
    }
}