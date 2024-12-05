<?php
namespace App\Classes\Payments\ZaloPay;

use Illuminate\Support\Facades\Http;

class ZaloPayHelper
{
  private static $PUBLIC_KEY;
  private static $UID;

  static function init()
  {
    # Public key nhận được khi đăng ký ứng dụng với zalopay
    self::$PUBLIC_KEY = file_get_contents('../publickey.pem');
    self::$UID = round(microtime(true) * 1000);
  }

  /**
   * Kiểm callback có hợp lệ hay không 
   * 
   * @param Array $params ["data" => string, "mac" => string]
   * @return Array ["returncode" => int, "returnmessage" => string]
   */
  static function verifyCallback(Array $params)
  {
    $data = $params["data"];
    $requestMac = $params["mac"];

    $result = [];
    $mac = ZaloPayMacGenerator::compute($data, env('KEY_2_ZALO'));

    if ($mac != $requestMac) {
      $result['returncode'] = -1;
      $result['returnmessage'] = 'mac not equal';
    } else {
      $result['returncode'] = 1;
      $result['returnmessage'] = 'success';
    }

    return $result;
  }

  /**
   * Kiểm callback có hợp lệ hay không 
   * 
   * @param Array $data - là query string mà zalopay truyền vào redirect link ($_GET)
   * @return bool
   *  - true: hợp lệ
   *  - false: không hợp lệ
   */
  static function verifyRedirect(Array $data)
  {
    $reqChecksum = $data["checksum"];
    $checksum = ZaloPayMacGenerator::redirect($data);

    return $reqChecksum === $checksum;
  }

  /**
   * Generate apptransid hoặc mrefundid
   * 
   * @return string
   *  - apptransid có dạng yyMMddxxxxx
   *  - mrefundid có dạng yyMMdd_appid_xxxxx
   */
  static function genTransID()
  {
    return date("ymd")."_".env('APP_ID_ZALO')."_".(++self::$UID);
  }

  /**
   * Tạo Array chứa các tham số cần thiết để truyền vào API "tạo đơn hàng"
   * 
   * @param Array $params [
   *  "amount" => long,
   *  "description" => string (optional),
   *  "bankcode" => string (optional - default "zalopayapp"),
   *  "appuser" => string (optional - default "demo"),
   *  "item" => string (optional - default "")
   * ]
   * @return Array
   */
  static function newCreateOrderData(Array $params)
  {
    $embeddata = [
      ''
    ];
    
    if (array_key_exists("embeddata", $params)) {
      $embeddata = $params["embeddata"];
    }

    $order = [
      "appid" => env('APP_ID_ZALO'),
      "apptime" =>  round(microtime(true) * 1000),
      "apptransid" => $params['code'],
      "appuser" => array_key_exists("appuser", $params) ? $params["appuser"] : "demo",
      "item" => json_encode(array_key_exists("item", $params) ? $params["item"] : []),
      "embeddata" => json_encode($embeddata),      
      "bankcode" =>  array_key_exists("bankcode", $params) ? $params["bankcode"] : "zalopayapp",
      "description" => array_key_exists("description", $params) ? $params['description'] : "",
      "amount" => '100000',
    ];

    return $order;
  }

  /**
   * Nhận vào thông tin đơn hàng và tạo đơn hàng thông qua API "tạo đơn hàng"
   * 
   * @param Array $order - Thông tin đơn hàng
   * @return Array - Kết quả tạo đơn hàng
   */
  static function createOrder(Array $order) {
    $order['mac'] = ZaloPayMacGenerator::createOrder($order);
    $context = stream_context_create([
      "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($order)
      ]
    ]);
   $result = json_decode(file_get_contents(env('API_ZALO_CREATEORDER'), false, $context),true);
    return $result;
  }

  static function getBankList()
  {
    $params = [
      "appid" => env('APP_ID_ZALO'),
      "reqtime" => round(microtime(true) * 1000)
    ];

    $params['mac'] = ZaloPayMacGenerator::getBankList($params);
    return Http::postForm(env('API_ZALO_BANKLIST'), $params);
  }
   
}
ZaloPayHelper::init();