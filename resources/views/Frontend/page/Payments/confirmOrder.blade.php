@extends('Frontend.layout.layout')
@section('title')
    
@endsection
@section('content')
@php
    $province = $order->province ? $order->province->full_name  : ''; 
    $district = $order->district ? $order->district->full_name  : ''; 
    $ward = $order->ward ? $order->ward->full_name  : ''; 
    $address = $order->address.', '.$ward.', '.$district.', '.$province;
@endphp
<div class="container">
    <div class="w-100">
        {{-- breadcrumbs --}}
        <div class="breadcrumbs css-seb2g4">
            {{ Breadcrumbs::view('partial.frontend.breadcrumbs','checkout') }}         
        </div>
        <form action="{{ route('order.store.confirm.payment',$order->code) }}" method="POST" enctype="multipart/form-data">
         @csrf
            <div class="css-rf24tk">
                <div class="teko-row css-zbluka" style="margin:0 -8px">
                    
                    <div class="teko-col teko-col-8 css-17ajfcv" style="padding: 0 8px">
                        <div class="css-1eks86m">
                            <div class="css-1557c61">
                                <div class="css-1ms22as">
                                    <div class="css-7mlvw6" style="font-weight:bold">Thông tin nhận hàng</div>
                                    <div class="css-4sc7mn h-100">
                                        <strong>{{ $order->name }} - {{ $order->email }}</strong><br>
                                        <span>{{ $order->phone }}</span><br>
                                        <span>{{ $address }}</span><br>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        {{-- Shipping --}}
                        <div class="bg-white mt-4" style="padding:12px 22px">
                            <strong>Tổng phí vận chuyển :</strong> <span class="shipping_price fw-bold " style="font-size:14px">{{ convert_price($order->shipping_options['total'],true) }} đ</span>
                            <div class="ms-3 render_shipping_option">
                                --<strong>Bảo hiểm đơn hàng :</strong> <span class="text-danger" >{{ convert_price($order->shipping_options['insurance_fee'],true) }} đ</span>
                                --<strong>Bảo hiểm hàng hóa dễ vỡ :</strong> <span class="text-danger" >{{ convert_price($order->shipping_options['extFees'],true) }} đ</span>
                                --<strong>Phí vận chuyển :</strong> <span class="text-danger" >{{ convert_price($order->shipping_options['options'],true) }} đ</span>
                            </div>      
                        </div>
                        {{-- desc --}}
                        <div class="css-176y93t">
                            <div class="css-y7yt88" style="font-weight:bold">Ghi chú đơn hàng</div>
                            <div class="css-1v4kstc">
                                <textarea name="desc" readonly id="" cols="30" class="form-control" rows="10">{!! $order->desc !!}</textarea>
                            </div>
                        </div>
                        {{-- mehthod payment --}}
                        @include('Frontend.page.Payments.components.paymentMethod',['method' => $order->method])
                    </div>

                    {{--  --}}
                    <div class="css-9zicy3">
                        <div class="css-14xqo9c">
                            <div class="css-1euuut5">
                                <div class="" style="font-size: 15px;line-height: 24px;font-weight: bold;">Thông tin đơn hàng</div>
                            </div>
                            {{-- body --}}
                            @foreach ($order->Order_products as $key => $products)
                                @php
                                    $cart = json_decode($products->pivot->option,true);
                                @endphp
                                <div class="css-9op68y w-100" style="margin-bottom:1rem;" data-rowId="{{ $cart['rowId'] }}">
                                    <div class="d-flex">
                                        <div class="css-17nqxzh" style="width: 80px;height:80px">
                                            <img 
                                            style="object-fit:contain"
                                            src="{{ $cart['thumb'] }}" class="w-100 h-100" alt="">
                                        </div>
                                        <div class=""  style="flex: 1 1 0%; margin-left: 1rem;">
                                            <a href="{{ $cart['canonical'] }}" style="text-decoration: none">
                                                <div type="body" color="textPrimary" class="css-1h5tj4c">
                                                    {{ $cart['name'] }}
                                                </div>
                                            </a>
                                            <div type="caption" color="textSecondary" class="css-1f5a6jh">Số lượng:  {{ $cart['qty'] }}</div>
                                        
                                            <span class="css-7ofbab">{{   
                                            convert_price($cart['options']['priceSale'] == 0 || is_null($cart['options']['priceSale'])  
                                            ? $cart['price_previous'] 
                                            : $cart['options']['priceSale'],true)     
                                            }}đ</span>
                                            @if ($cart['options']['priceSale'] != 0 && !is_null($cart['options']['priceSale']))
                                            <div class="teko-row justify-content-start align-items-center css-1qrgscw">
                                                <span class="css-18z00w6 ">{{ convert_price($cart['price'],true) }}đ</span>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- price --}}
                        <div class="" style="border-radius: 8px;background-color: rgb(255, 255, 255);position: relative;margin-bottom: 16px;padding: 16px">
                            <div class="" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;display: flex;flex-flow: column;gap: 0rem;justify-content: flex-start;align-items: flex-end;">
                              <div class="" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;display: inline-block;min-width: 300px;">
                                  <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Tổng tạm tính</div><div class="css-rs5cam"><span class="css-htm2b9">{{ convert_price($order->cart['total'],true)  }} <span class="css-1angbw">đ</span></span></div></div>
                                  <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Phí vận chuyển</div><div class="css-rs5cam"><span class="css-htm2b9">{{ convert_price($order->shipping_options['total'],true) }}<span class="css-1angbw"> đ</span></span></div></div>
                                  <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Thành tiền</div><div class="css-rs5cam"><span class="css-htm2b9 text-danger"> {{ convert_price(($order->cart['total'] + $order->shipping_options['total']),true) }} <span class="css-1angbw">đ</span></span></div></div>
                                  <input type="hidden" name="total" value="{{ $order->cart['total'] + $order->shipping_options['total'] }}">
                                </div> 
                            </div>
                            <div class="footer_cart">
                                <div class="">
                                    <button style="text-decoration: none" type="submit" class="css-v463h2">
                                        Thanh toán
                                    </button>
                                </div>
                                . @if ($errors->has('total'))
                                    <div class="css-fwmmrl text-danger fw-bold" style="font-size: 14px">
                                        {{  $errors->first('total') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>    
                
                </div>
            </div>
        </form>
    </div>
</div>   

  
@endsection