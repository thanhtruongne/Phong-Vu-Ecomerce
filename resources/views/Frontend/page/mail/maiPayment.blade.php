<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <style>
        h1 {
            color: red;
        }
     </style>

    <title>Document</title>
</head>
<body>
    <h1> ĐƠN HÀNG:{{ $data->code }}</h1>
    <div class="w-100" >
        <div class="css-gjf6g1">
           <div style="flex-wrap: wrap;display:flex;justify-content:center">
                @php
                 $provinces_code = $data->province ? $data->province->full_name  : ''; 
                    $districts_code = $data->district ? $data->district->full_name  : ''; 
                    $wards_code = $data->ward ? $data->ward->full_name  : ''; 
                    $address = $data->address.', '.$wards_code.', '.$districts_code.', '.$provinces_code;
            
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

                <div class="">
                    <a href="{{ route('order.confirm.payment',$data->code) }}">Vui lòng click vào lick để thanh toán hóa đơn !!!</a>
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

  
</body>
</html>