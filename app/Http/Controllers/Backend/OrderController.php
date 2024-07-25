<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Shipping\ShippingGHTK;
use App\Models\District;
use App\Models\Ward;
use App\Repositories\OrderRepositories;
use App\Services\Interfaces\OrderServiceInterfaces as OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
class OrderController extends Controller
{
    protected $orderService,$orderRepositories;

    public function __construct(OrderService $orderService,OrderRepositories $orderRepositories) {
        $this->orderService = $orderService;
        $this->orderRepositories = $orderRepositories;
    }


    public function index(Request $request) {
        $provinces = Redis::get('province');
        $order = $this->orderService->paginate($request);
        $config = [
            'link' => [
                'backend/css/style.css',
            ],
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/library/order.js',
                'backend/library/location.js'
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            
            ],
        ];
        return view('backend.Page.order.index',compact('config','order','provinces'));
    }
    public function detail(string $code = '') {
        $order = $this->orderRepositories->findCondition([
            ['code','=',$code]
        ],[],['province','district','ward'],'first',[]);
        if($order->is_transport == 1){
           $transport = new ShippingGHTK($this->orderRepositories);
           $order_shippment = $transport->statusOrderTransport($order->order_transport_fee->label_id);
           if($order_shippment['success']){
              $order->info = json_encode($order_shippment['order']);
           }

        }
        $config = [
            'links_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/library/order.js',
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            
            ],
        ];
        return view('backend.Page.order.detail',compact('order','config'));
    }
    public function uppdateInfoOrder(Request $request,string $code ) {
        if($this->orderService->updateInfo($request,$code)) {
           Session::flash('success','Cập nhật thành công');
           return redirect()->back();
        }
        Session::flash('error','Cập nhật thất bại');
        return redirect()->back();
    }


    public function orderCancel(Request $request){
        $provinces = Redis::get('province');
        $order = $this->orderService->paginate($request,'trashed');
        $config = [
            'link' => [
                'backend/css/style.css',
            ],
            'links_link' => [   
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
               
            ],
            'js' => [
                'backend/library/order.js',
                'backend/library/location.js'
            ],
            'js_link' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            
            ],
        ];
        return view('backend.Page.order.cancel.index',compact('config','order','provinces'));
    }

    public function removeCancelOrder(string $code = ''){
        if($this->orderService->cancel($code)){
            return redirect()->route('private-system.management.order')->with('success','Hủy đơn hàng thành công');
        }
        return redirect()->route('private-system.management.order')->with('error','Có vấn đề xảy ra với đơn hàng');
    }
   
}
