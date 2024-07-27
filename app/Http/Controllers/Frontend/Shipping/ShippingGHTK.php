<?php

namespace App\Http\Controllers\Frontend\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Repositories\OrderRepositories;
use App\Repositories\OrderTransportFeeRepositories;
use Exception;
use Illuminate\Http\Request;

class ShippingGHTK extends BaseController
{  
    protected $orderRepositories,$orderTransportRepositories;
    public function __construct(OrderRepositories $orderRepositories ){
        $this->orderRepositories = $orderRepositories;
        $this->orderTransportRepositories = resolve(OrderTransportFeeRepositories::class);
    }
  
    public function CalcShippingByGhtk(Request $request){
        $pick_adress = config('apps.payment.pick_address');
        $temp = array(
            "pick_province" => $pick_adress['provinces'],
            "pick_district" => $pick_adress['district'],
            'pick_ward' => $pick_adress['ward'],
            "province" => $request->input('province'),
            "district" =>  $request->input('districts'),
            "address" =>  $request->input('address'),
            "weight" => 5000,
            "value" => +$request->input('value'),
            "transport" => "fly",
            "deliver_option" => "xteam",
            "tags"  => [1]
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://services-staging.ghtklab.com/services/shipment/fee?" . http_build_query($temp),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Token: ".env('API_GHTK_KEY')."",
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response;
        
    }

    public function SubOrderAccess(Request $request){
        $order = 
<<<HTTP_BODY
{
"products": {$request->input('products')},
"order": {
"id": "{$request->input("order_id")}",
"pick_name": "nguyễn",
"pick_address": "Tạ Quang Bửu",
"pick_province": "TP. Hồ Chí Minh",
"pick_district": "Quận 5",
"pick_ward": "Phường 4",
"pick_tel": "0911222333",
"tel": "{$request->input("tel_customer")}",
"name": "{$request->input("name_customer")}",
"address": "{$request->input("address_customer")}",
"province": "{$request->input("province_customer")}",
"district": "{$request->input("district_customer")}",
"ward": "{$request->input("ward_customer")}",
"hamlet": "Khác",
"is_freeship": "{$request->input("is_freeship")}",
"pick_money": {$request->input("pick_money")},
"note": "{$request->input("note")}",
"value":  "{$request->input("value")}",
"transport": "fly",
"pick_option":"cod",      
"deliver_option" : "none",  
"pick_session" : 2,
"tags": [ 1]
}
}
HTTP_BODY;
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://services-staging.ghtklab.com/services/shipment/order",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $order,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Token: ".env('API_GHTK_KEY')."",
        "Content-Length: " . strlen($order),
    ),
));


$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response,true);
    if($response['success'] == true){
        // Update transport order
        try {
            $this->orderRepositories->UpdateWhere([['code','=',$response['order']['partner_id']]],['is_transport' => 1]);
            $order = $this->orderRepositories->findCondition([['code','=',$response['order']['partner_id']]],[],[],'first',[]);
            $this->orderTransportRepositories->deleteByCondition([[
                'order_id','=',$order->id
            ]]);
          
            $data = [
                'label_id' => $response['order']['label'],
                'partner_id' => $response['order']['partner_id'],
                'option' => $response['order'],
                'status' => $response['order']['status_id'],
            ];
            $order->order_transport_fee()->create($data);
            return redirect()->route('private-system.management.order.detail',$order->code)->with('success','Tạo transport thành công với đơn vị GHTK');
        }catch(Exception $e) {
            return $e->getMessage();die();
        }
       
    }
    else if($response['success'] == false){
        return redirect()
        ->route('private-system.management.order')
        ->with('error',$response['message']);
    }
}


    public function statusOrderTransport(string $label = null) {
        try {
            if(!is_null($label)) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://services-staging.ghtklab.com/services/shipment/v2/".$label,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPHEADER => array(
                        "Token: ".env('API_GHTK_KEY')."",
                    ),
                ));
     
                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response,true);
                return $response;
            }
        } catch (\Throwable $th) {
            return $th->getMessage().$th->getLine();die();
        }
       
    }

    public function getInvoiceGHTK(string $label = ''){
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://services-staging.ghtklab.com/services/label/".$label."?original=portrait&page_size=A6",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type" => "application/pdf",
                    "Content-Disposition" => "attachment",
                    "filename" => "",
                "Content-Transfer-Encoding"=> "binary",
                    "Token: ".env('API_GHTK_KEY')."",
                ),
            ));
 
            $response = curl_exec($curl);
            curl_close($curl);
            dd($response);
        } catch (\Throwable $th) {
            return $th->getMessage();die();
        }
    }



}
