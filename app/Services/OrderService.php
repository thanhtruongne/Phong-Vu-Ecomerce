<?php
namespace App\Services;

use App\Enums\Enum\OrderEnum;
use App\Repositories\OrderPaymentRepositories;
use App\Repositories\OrderRepositories;
use App\Services\Interfaces\OrderServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class OrderService extends BaseService implements OrderServiceInterfaces
{
   protected $orderRepositories,$orderPaymentRepositories;

    public function __construct(OrderRepositories $orderRepositories,OrderPaymentRepositories $orderPaymentRepositories) 
    {
        parent::__construct();
        $this->orderPaymentRepositories = $orderPaymentRepositories;
        $this->orderRepositories = $orderRepositories;
    }
        public function paginate($request,string $is_cancel = 'no') 
    {
       $condition = $this->arguments($request,$is_cancel);
       $order = $this->orderRepositories->customPagination(...$condition);
       return $order;
    }
    private function arguments($request,$is_cancel) { 
        return [
            'column' => ['*'],
            'condition' => [
                'search' => $request->input('search') ?? '',
                'customField' => [
                    ['confirm','=', $request->input('confirm') ?? 'none'],
                    ['payment','=',$request->input('payment') ?? 'none'],
                    ['shipping','=',$request->input('shipping') ?? 'none'],
                    ['is_transport','=',$request->input('is_transport') ?? 'none'],
                ],
                'address' => [
                    ['province_code','=', $request->input('province_code') ?? 'none'],
                    ['district_code','=',$request->input('district_code') ?? 'none'],
                    ['ward_code','=',$request->input('ward_code') ?? 'none'],
                ],
                'datetime' => $request->input('datefilter') ?? null,
            ],
            'page' => $request->input('record') ?? 6,
            'groupBy' => ['id'],
            'extend' => [],
            'order' => ['id' => 'desc'],
            'join' => [
                ['order_transport_fee as otf','otf.order_id','=','order.id']
            ],
            'whereJoins' => ['otf.status','=',$request->input('status_shipping') ?? 'none'],
            'is_cancel' => $is_cancel
        ];
    }


    public function updateInfo($request,string $code = '') {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token']);
            $this->orderRepositories->UpdateWhere([['code','=',$code]],$payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            // DB::rollBack();
            echo new Exception($e->getMessage()); die();
            return false;
        }
    }
    public function updateMethod($payload,string $code = '') {
        DB::beginTransaction();
        try {
            $this->orderRepositories->UpdateWhere([['code','=',$code]],$payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            // DB::rollBack();
            echo new Exception($e->getMessage()); die();
            return false;
        }
    }


    public function updateAfterPayment($order,$payload,string $paymentMethod = '') {
        DB::beginTransaction();
        try {
            $payment = [];
            $data = [
                'payment' => OrderEnum::PAID,
                'confirm' => OrderEnum::CONFIRM,
            ];
            if($paymentMethod == $order->method && $paymentMethod == 'vnpay') {
                $payment = [
                    'order_id' => $order->id,
                    'payment_id' => $payload['vnp_TmnCode'],
                    'methodName' => $payload['vnp_CardType'],
                    'detail_payment' => json_encode($payload),
                ];
            }
            else if($paymentMethod == $order->method && $paymentMethod == 'momo') $payment = $payload;
             
            else if($paymentMethod == $order->method && $paymentMethod == 'zalo') $payment = $payload;
            
            else {
                $payment = [
                    'order_id' => $order->id,
                    'payment_id' => '0000',
                    'methodName' => 'Thanh toán khi nhận hàng',
                    'detail_payment' => [],
                ];
            }
            $this->orderPaymentRepositories->createByInsert($payment);
            $this->orderRepositories->UpdateWhere([[
              'code','=',$order->code
            ]],$data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage()); die();
            return false;
        }
    }

    public function cancel(string $code = ''){
        DB::beginTransaction();
        try {
            $this->orderRepositories->deleteByCondition([['code','=',$code]]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('private-system.management.order')->with('error','Có lỗi xảy ra');
        }
    }
}
