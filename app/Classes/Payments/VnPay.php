<?php 

namespace App\Classes\Payments;
class VnPay {
    private $url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    private $return_url = 'http://localhost:8000/vnpay_return';
    public function payments($order) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $vnp_Url = $this->url;
        $vnp_Returnurl = $this->return_url;
        $vnp_TmnCode =env('CODE_WEBSITE');//Mã website tại VNPAY 
        $vnp_HashSecret =env('SERECT_KEY'); //Chuỗi bí mật
        
        $vnp_TxnRef = $order->code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
        $vnp_OrderInfo = $order->desc ?? 'No description';
        $vnp_OrderType = 'other';
        $vnp_Amount = ($order->cart['total'] + $order->shipping_options['total']) * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = date('YmdHis',strtotime('+30 minutes',strtotime(date('YmdHis'))));;

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$vnp_ExpireDate,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        return $returnData;
    }
}