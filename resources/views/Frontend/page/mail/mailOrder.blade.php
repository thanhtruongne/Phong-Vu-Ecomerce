 <h1> ĐƠN HÀNG:{{ $data->code }}</h1>
    <div class="w-100" >
        <div class="css-gjf6g1">
           <div style="flex-wrap: wrap;display:flex;justify-content:center">
                @php
                    $address = $data->address.', '.$data->ward->full_name.', '.$data->district->full_name.','.$data->province->full_name;
                @endphp
                <div class="" style="width:80%;box-sizing: border-box;margin: 0px;min-width: 0px;">
                    <div style="display:flex;justify-content:center;align-items:center;margin-bottom: 1rem;">
                        
                        <h5 style="font-weight: 500; line-height: 1.3;font-size:1.25rem">
                            ĐƠN HÀNG:{{ $data->code }}
                        </h5>
                    </div>
                    <div class="css-1o0q5vl" style="display:flex;justify-content:between;align-items:center">
                        <div class="css-qry4qr">
                            <div class="" style="margin-bottom: 0.5rem;font-weight: bold;">
                                Thông tin người nhận    
                            </div>
                            <div class="" style="line-height: 1.7;">
                                <div class=""><strong>Người nhận:</strong> <span>{{ $data->name }}</span></div>
                                <div>
                                    <strong>Địa chỉ: </strong>
                                    <span>{!! $address !!}</span>
                                </div>
                                <div><strong>Điện thoại: </strong><span>{{ $data->phone }}</span></div>
                            </div>
                        </div>
                        <div class="css-qry4qr">
                            <div class="" style="margin-bottom: 0.5rem;font-weight: bold;">
                                Thông tin đơn hàng  
                            </div>
                            <div class="" style="line-height: 1.7;">
                                <div class=""><strong>Trạng thái đơn hàng:</strong> <span>{{ $data->confirm }}</span></div>
                                <div class=""><strong>Trạng thái thanh toán:</strong> <span>{{ $data->payment }}</span></div>
                                <div><strong>Phí giao hàng: </strong><span>{{ convert_price($data->shipping_options['total'],true) }}</span></div>
                                <div><strong>Thời gian tạo: </strong><span>{{ \Carbon\Carbon::parse($data->createdAt)->format('H:i d/m/Y') }}</span></div>
                            </div>
                        </div>
                    </div> 

                     <div class="css-118e7yd">
                        <div class="">
                            <div class="css-1x7er7i">Sản phẩm</div>
                            <div class="wrapper">
                         
                                @foreach ($data->Order_products as $key =>  $product)
                                    @php
                                        $option = json_decode($product->pivot->option);
                                    @endphp
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding: 12px 16px;background: rgb(255, 255, 255)">
                                        <div class="" style="display: flex;align-items:center">
                                            <div class="" style="margin-right: 12px">
                                                <div class="" style="widows: 80px;height:80px">
                                                    <img 
                                                    width="80" height="80"
                                                    src="https://lh3.googleusercontent.com/1lHnxpY9fkTPji3AXQIFSqL5MT6m6japIS8wbSRMRuaqo8lEMjSWnJXxb9MrX6vP-VIfc7enuvIMF2843gQnXMfmlXlPZb2J=rw" alt="">
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
                                        </div>
                                        <div class="" style="margin-left: 12px;">
                                            <div class="text-end">
                                                <div style="display:flex;align-items:center;justify-content:space-between">
                                                    <div  style="align-items: baseline;flex-direction:column;display:flex">
                                                        <span style="font-size: 0.875rem;font-weight: 500;color: rgb(67, 70, 87)">
                                                            {{ convert_price(!empty($product->pivot->priceSale) 
                                                            ? $product->pivot->priceSale : $product->pivot->price , true) }}
                                                            <span style="font-size: 0.875rem;font-weight: 500;color: rgb(67, 70, 87);">đ</span>
                                                        </span>
                                                        @if (!empty($product->pivot->priceSale))
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
                        <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Tổng tạm tính</div><div class="css-rs5cam"><span class="css-htm2b9">{{ convert_price($data->cart['total'],true)  }} <span class="css-1angbw">đ</span></span></div></div>
                        <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Phí vận chuyển</div><div class="css-rs5cam"><span class="css-htm2b9">{{ convert_price($data->shipping_options['total'],true) }}<span class="css-1angbw"> đ</span></span></div></div>
                        <div direction="row" class="css-4scx67"><div color="#848788" direction="row" class="css-1xs08uy">Thành tiền</div><div class="css-rs5cam"><span class="css-htm2b9"> {{ convert_price(($data->cart['total'] + $data->shipping_options['total']),true) }} <span class="css-1angbw">đ</span></span></div></div>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
