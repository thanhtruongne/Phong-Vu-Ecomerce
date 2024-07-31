@extends('backend.layout.layout');
@section('title')
    Quản lý đơn hàng
@endsection

@section('content')
    @php
        $provinces_code = $order->province ? $order->province->full_name  : ''; 
        $districts_code = $order->district ? $order->district->full_name  : ''; 
        $wards_code = $order->ward ? $order->ward->full_name  : ''; 
        $address = $order->address.', '.$wards_code.', '.$districts_code.', '.$provinces_code;
        $name = $order->name;
    @endphp
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                <div class="" style="align-items:center;display:flex;justify-content:space-between">
                    {{ Breadcrumbs::view('partial.frontend.breadcrumbs','order-detail',$order) }}      
                </div>
                @if ($order->confirm == 'unconfirmed')
                    @if ($order->payment == 'cod')
                        <div class="" style="display:flex;justify-content:space-between;align-items:center;width:20%">
                            <div>
                                <i class="fa fa-warning" style="margin-right: 4px;color:rgb(242, 142, 11)"></i>
                               Xác nhận đơn hàng
                            </div>
                            <button class="btn btn-danger submit_order_confirm">Xác nhận</button>
                        </div>  

                    @else 
                    <div class="" style="display:flex;justify-content:space-between;align-items:center;width:20%">
                        <div>
                            <i class="fa fa-warning" style="margin-right: 4px;color:rgb(242, 142, 11)"></i>
                             Sau 180' (nếu khách hàng không thanh toán sẽ hủy) (   {{ \Carbon\Carbon::parse($order->created)->addMinutes(180)->format('H:i d/m/Y') }})
                        </div>
                        <form action="{{ route('private-system.management.order.stort.cancel',$order->code) }}" method="POST">
                            @csrf
                            <button
                            {{ \Carbon\Carbon::parse($order->created)->addMinutes(180)->gt(\Carbon\Carbon::now()) ? 'disabled' : ''   }}
                           class="btn btn-danger submit_order_confirm">Hủy</button>
                        </form>
                    
                    </div>  
                    @endif
                    @endif
                  
            </div>
            <div class="ibox-content" style="background-color:transparent !important;">
              <div class="">
                <div class="" style="display:flex;justify-content:space-between">
                    <div class="" style="width: 65%;">
                        <div class="" style="background-color: #fff;padding:16px">
                            <div class="" style=" display: flex;justify-content: space-between;align-items: center;">
                                <div class="" >
                                    <strong>Đơn hàng: </strong>
                                    <span>#{{ $order->code }}</span>
                                    <div class="" >
                                        <i class="fa fa-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($order->created)->format('H:i d/m/Y') }}</span>        
                                    </div>
                                </div>
                                <div class="" style="display: flex">
                                    <div class="" style="margin-right:12px">
                                        {!! confirm_order_status_admin($order->payment) !!}                           
                                    </div>
                                    <div class="">
                                        {!! confirm_order_status_admin($order->confirm) !!}                           
                                    </div>
                                </div>
                            </div>
                           <hr style="margin-left: -17px;font-size:25px;margin-right: -17px;">
                            <div class="">
                                @foreach ($order->Order_products as $product)
                                @php
                                    $dataPivot =  json_decode($product->pivot->option,true);
                                    
                                    $canonical = $dataPivot['canonical'];
                                    $image = $dataPivot['thumb'];
                                @endphp
                                    <div class="item_product_order" style="display: flex;justify-content:space-between;align-items:center;margin:14px 0px;">
                                        <div class="" style="display: flex">
                                            <div class="">
                                                <img style="width: 80px;height:80px"
                                                 src="{{ $image }}" alt="">
                                            </div>
                                            <div class="" style="padding-left: 10px">
                                                <a href="{{ $canonical }}" style="color:rgb(0, 92, 198);font-size:15px">
                                                    {{ $dataPivot['name'] }}
                                                </a>
                                                <br>
                                                <strong>Sku:</strong> 
                                                <span>{{ $dataPivot['sku'] }}</span>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="" style="text-align: center">
                                            <span>{{convert_price($dataPivot['options']['priceSale'],true) ?: convert_price($dataPivot['price'],true) }}đ</span>
                                            <br>
                                            @if (isset($dataPivot['options']['priceSale']) && !is_null($dataPivot['options']['priceSale']))
                                                <span>-{{ $dataPivot['options']['discountValue'] }}{{ $dataPivot['options']['discountType'] }}</span>
                                                <del>{{ convert_price($dataPivot['price'],true) }}đ</del> 
                                                <br>
                                            @endif
                                      
                                        </div>
                                    </div>
                                @endforeach
                           
                            </div>
                            <div class="" style="display: flex;justify-content:end">
                                <div class="" style="width: 32%">
                                    <div class="" style="display: flex;justify-content:space-between;margin-top:8px">
                                        <strong >Tổng tạm tính</strong>
                                        <span class="">{{ convert_price($order->cart['total'],true) }}</span>
                                     </div>
                                     <div class="" style="display: flex;justify-content:space-between;margin-top:8px">
                                         <strong >Phí giao hàng</strong>
                                         <span class="">{{ convert_price($order->shipping_options['total'],true) }}đ</span>
                                      </div>
                                      <div class="" style="display: flex;justify-content:space-between;margin-top:8px">
                                         <strong >Tổng</strong>
                                         <span class="">
                                            {{ convert_price($order->cart['total'] + $order->shipping_options['total'],true ) }}đ
                                        </span>
                                      </div>
                                </div>
                                
                            </div>
                            <hr style="margin-left: -17px;font-size:25px;margin-right: -17px;">
                            <div class="" style="display: flex;justify-content:space-between;align-items:center">
                                <div class="">Gửi hóa đơn email envoice (<span class="text-danger">thông báo thanh toán !!!</span>)</div>
                                
                                <button
                                 data-code="{{ $order->code }}"
                                 data-email="{{ $order->email }}"
                                 data-href="{{ $order->payment == 'paid' ? '' : 
                                 route('private-system.ajax.order.payment.send.invoice')
                                 }}"
                                 class="{{ $order->payment == 'paid' ? 'btn btn-primary' : 'btn btn-danger' }} submit_send_mail_invoice">
                                 Send Invoice <span class="loading"></span></button>
                                <div class="">
                                    <strong>Đã send</strong>: (<span class="send_mail_count">{{ $order->is_send_mail }}</span>)
                                </div>
                            </div>
                        </div>
                       @if ($order->is_transport === 1 && !is_null($order->info))
                            @php
                                $info = json_decode($order->info,true);
                            @endphp
                            <div class="ibox float-e-margins" style="margin-top:40px">
                                <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                                    <div class="" >
                                        <strong>Đã tạo đơn hàng: </strong>
                                        <span>#{{ $order->code }}</span>
                                        <span> thành công</span>
                                        <div class="" >
                                            Đơn vị vận chuyển GHTK
                                        </div>
                                    </div>
                                    <div class="" style="margin-right:12px">
                                        <img width="40" height="40" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1721279574/zrola2m5sjmwewvbphyc.webp" alt="">
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="css-qry4qr" style="padding:0 10px">
                                            <div class="text-center" style="margin-bottom: 0.5rem;font-weight: bold;">
                                                Thông tin transport GHTK 
                                            </div>
                                            <div class="">
                                                <div class="" style="line-height: 1.7;display:flex;align-items:center;justify-content:space-between">

                                                    <div class="" style="margin-bottom: 12px">
                                                        <div class="mb-2"><strong style="margin-right:6px">Trạng thái đơn hàng:</strong> {!!  order_shipping_status($info['status']) !!}</div>
                                                        <div class="mb-2"><strong style="margin-right:6px">Ngày tạo đơn hàng:</strong> {{ $info['created'] }}</div>
                                                        <div class="mb-2"><strong style="margin-right:6px">Ngày hẹn lấy hàng:</strong> {{ $info['pick_date'] }}</div>
                                                        <div class="mb-2"><strong style="margin-right:6px">Ngày hẹn giao thành công</strong> {{ $info['deliver_date'] }}</div>
                                                    </div>
                                                     
                                                    <div class="">
                                                        <div  class="mb-2"><strong style="margin-right:6px">Tên người nhận:</strong> {{ $info['customer_fullname'] }}</div>
                                                    <div class="mb-2"><strong style="margin-right:6px">Số điện thoại người nhận:</strong> {{ $info['customer_tel'] }}</div>
                                                    <div class="mb-2"><strong style="margin-right:6px">Địa chỉ:</strong> {{ $info['address'] }}</div>
                                                    <div class="mb-2"><strong style="margin-right:6px">Số ngày tồn kho:</strong> {{ $info['storage_day'] }}</div>
                                                    <div class="mb-2"><strong style="margin-right:6px">Phí giao hàng:</strong> {{ convert_price($info['ship_money'],true) }} đ</div>
                                                    <div class="mb-2"><strong style="margin-right:6px">Thu COD:</strong> {{ $info['pick_money'] }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                       @else
                            @include('backend.Page.order.components.transport',['order' => $order,'address' => $address])
                       @endif
                    </div>

                    @include('backend.Page.order.components.customerInfo',['order' => $order,'address' => $address])
                </div>
              </div>
              
            </div>
        </div>
    </div>
    <input type="hidden" name="email" value="{{ $order->email }}">
    <input type="hidden" name="name" value="{{ $order->name }}">
    <input type="hidden" name="phone" value="{{ $order->phone }}">
    <input type="hidden" name="address" value="{{ $order->address }}">
    <input type="hidden" name="province_code" value="{{ $order->province_code }}">
    <input type="hidden" name="district_code" value="{{ $order->district_code }}">
    <input type="hidden" name="ward_code" value="{{ $order->ward_code }}">
    <input type="hidden" name="desc" value="{{ $order->desc }}">


    @push('scripts')
    <script>
        var province_id = '{{ (isset($order->province_code)) ? $order->province_code : old('province_code') }}';
        var district_id = '{{ (isset($order->district_code)) ? $order->district_code : old('district_code') }}';
        var ward_id = '{{ (isset($order->ward_code)) ? $order->ward_code : old('ward_code') }}';
    </script>
        
    @endpush
@endsection
