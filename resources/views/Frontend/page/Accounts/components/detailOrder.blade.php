


@php
    $province = $order->province ? $order->province->full_name  : ''; 
    $district = $order->district ? $order->district->full_name  : ''; 
    $ward = $order->ward ? $order->ward->full_name  : ''; 
    $address = $order->address.', '.$ward.', '.$district.', '.$province;
@endphp
<div class="" style="width:80%;box-sizing: border-box;margin: 0px;min-width: 0px;">
    <div class="d-flex justify-content-between algin-items-center" style="margin-bottom: 1rem;">
        <h5 style="font-weight: 500; line-height: 1.3;font-size:1.25rem">
            <div class="css-1fxhdbo">
                <a class="css-v89nyz" href="{{ route(Auth::guard('web')->check() ? 'account.order' : 'guest.order') }}"></a>
            </div>
            ĐƠN HÀNG:{{ $order->code }}
        </h5>
        @if ($order->payment == 'unpaid')
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <i style="color:#ffae00" class="fa-solid fa-triangle-exclamation"></i>
                    Hóa đơn trong quá trình chờ
                </div>
                <a href="{{ route('order.confirm.payment',$order->code) }}" class="btn btn-warning">Thanh toán
                    <i class="ms-1 fa-solid fa-exclamation"></i>
                </a>
            </div>>
        @endif
        
    </div>
    <div class="css-1o0q5vl">
        <div class="css-qry4qr">
            <div class="" style="margin-bottom: 0.5rem;font-weight: bold;">
                Thông tin người nhận    
            </div>
            <div class="" style="line-height: 1.7;">
                <div class="mb-2"><strong>Người nhận:</strong> <span>{{ $order->name }}</span></div>
                <div class="mb-2"><strong>Email:</strong> <span>{{ $order->email }}</span></div>
                {{-- <div class="mb-2"><strong>Hình thức nhận hàng: </strong><span>{{ shipping_Rule(+$order->shipping_rule)['title'] }}</span></div> --}}
                <div class="mb-2">
                    <strong>Địa chỉ: </strong>
                    <span>{!! $address !!}</span>
                </div>
                <div class="mb-2"><strong>Điện thoại: </strong><span>{{ $order->phone }}</span></div>
            </div>
        </div>
        <div class="css-qry4qr">
            <div class="text-center" style="margin-bottom: 0.5rem;font-weight: bold;">
                Thông tin đơn hàng  
            </div>
            <div class="" style="line-height: 1.7;">
                <div class="mb-1"><strong>Phương thức thanh toán:</strong> {!! payment_status_fe($order->method) !!}</div>
                <div class="mb-2"><strong>Trạng thái đơn hàng:</strong> {!! confirm_order_status($order->confirm) !!}</div>
                <div class="mb-2"><strong>Trạng thái thanh toán:</strong> {!! confirm_order_status($order->payment) !!}</div>
                @if ($order->payment != 'unpaid')
                <div class="mb-2"><strong>Trạng thái giao hàng:</strong> <span style="font-style: italic">{!! confirm_order_status_admin($order->shipping) !!}</span></div>
                @endif       
                <div class="mb-2" ><strong>Phí giao hàng: </strong><span>{{ convert_price($order->shipping_options['total'],true) }} đ</span></div>
                <div class="mb-2" ><strong>Thời gian tạo: </strong><span>{{ \Carbon\Carbon::parse($order->createdAt)->format('H:i d/m/Y') }}</span></div>
            </div>
        </div>
    </div>

    <div class="css-118e7yd">
        <div class="">
            <div class="css-1x7er7i">Sản phẩm</div>
            <div class="wrapper">
                {{-- item --}}
                @foreach ($order->Order_products as $key =>  $product)
                    @php
                        $option = json_decode($product->pivot->option);
                    @endphp
                    <div class="d-flex align-items-center" style="padding: 12px 16px;background: rgb(255, 255, 255)">
                        <div class="" style="margin-right: 12px">
                            <div class="" style="widows: 80px;height:80px">
                                <img 
                                class="w-100 h-100"
                                src="{{ $product->image }}" alt="">
                            </div>
                        </div>
                        <div class="" style="flex: 1 1 0%;overflow: hidden;">
                            <a href="{{ $option->canonical }}" style="text-decoration: none">
                                <div class="css-1h7pc8k">{{ $option->name }}</div>
                            </a>
                            <div class="" style="font-size: 13px;rgb(130, 134, 158);">
                                <div class="css-194zbj">
                                    SKU: {{ $option->sku }}
                                </div>
                            </div>
                        </div>
                        <div class="" style="margin-left: 12px;">
                            <div class="text-end">
                                <div class="d-flex justify-conent-between">
                                    <div class="d-flex flex-column" style="align-items: baseline;">
                                        <span style="font-size: 0.875rem;font-weight: 500;color: rgb(67, 70, 87)">
                                            {{ convert_price( $product->pivot->priceSale ?: $product->pivot->price , true) }}
                                            <span style="font-size: 0.875rem;font-weight: 500;color: rgb(67, 70, 87);">đ</span>
                                        </span>
                                        @if (!empty($product->pivot->priceSale !== $product->pivot->price))
                                            <span class="css-18z00w6 ">
                                                {{ convert_price($product->pivot->price,true) }}
                                                <span style="font-size: 0.875rem;font-weight: 500;color: rgb(67, 70, 87);">đ</span>
                                            </span> 
                                        @endif
                                      
                                    </div>
                                </div>
                            </div>
                        <div class="" style="color: rgb(132, 135, 136);font-weight: 400;font-size: 12px;text-align: right;overflow: hidden;">
                            X{{ $product->pivot->qty }}
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>
           
    </div>

   
</div>
<div class="" style="border-radius: 8px;background-color: rgb(255, 255, 255);position: relative;margin-bottom: 16px;padding: 16px">
    <div class="" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;display: flex;flex-flow: column;gap: 0rem;justify-content: flex-start;align-items: flex-end;">
      <div class="" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;display: inline-block;min-width: 300px;">
          <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Tổng tạm tính</div><div class="css-rs5cam"><span class="css-htm2b9">{{ convert_price($order->cart['total'],true)  }} <span class="css-1angbw">đ</span></span></div></div>
          <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Phí vận chuyển</div><div class="css-rs5cam"><span class="css-htm2b9">{{ convert_price($order->shipping_options['total'],true) }}<span class="css-1angbw"> đ</span></span></div></div>
          <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Thành tiền</div><div class="css-rs5cam"><span class="css-htm2b9"> {{ convert_price(($order->cart['total'] + $order->shipping_options['total']),true)  }}    <span class="css-1angbw">đ</span></span></div></div>
      </div>
    </div>
  </div>
