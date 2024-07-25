
<div class="ibox float-e-margins" style="margin-top:40px">
    <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
        <div class="" >
            <strong>Đăng đơn hàng: </strong>
            <span>#{{ $order->code }}</span>
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
            <div class="" style="padding:12px 30px">
                @foreach ($order->Order_products as $product)
                @php
                    $products[] = [
                        "name" => $product->pivot->name,
                        "weight" => 0.3,
                        "quantity" => $product->pivot->qty,
                        "product_code" => $product->pivot->product_id.'H'.$product->pivot->uuid,
                    ];
                    
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
            <form action="{{ route('private-system.ghtk.create.order') }}" method="POST">
                @csrf
                <input type="hidden" name="products" value="{{ json_encode( $products )}}">
                <input type="hidden" name="order_id" value="{{$order->code}}">
            <div class="">
                <h3 class="m-t-none m-b" style="padding:8px 30px">Thông tin người nhận</h3>   
                <div class="col-sm-12 b-r">
                    <div class="form-group col-sm-6">
                        <label>Email</label> 
                        <input type="email" readonly name="email_customer" value={{ $order->email }} class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Họ và Tên</label>
                         <input type="text" name="name_customer" value={{ $order->name }} class="form-control">
                    </div>
                </div>
                <div class="col-sm-12 b-r">
                    <div class="form-group col-sm-6">
                        <label>Số điện thoại</label>
                         <input type="text" readonly name="tel_customer" value={{ $order->phone }} class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Địa chỉ</label>
                         <input type="text" readonly value={!! $address !!} class="form-control">
                         <input type="hidden" name="address_customer" value="{{ $order->address}}">
                         <input type="hidden" name="province_customer" value="{{ $order->province->full_name }}">
                         <input type="hidden" name="district_customer" value="{{ $order->district->full_name }}">
                         <input type="hidden" name="ward_customer" value="{{ $order->ward->full_name }}">
                    </div>
                </div>
                <div class="col-sm-12 b-r" style="padding:0 30px">
                    <div class="">
                        <label>Ghi chú</label> 
                    </div>   
                    <textarea name="note" readonly class="form-control" id="" cols="30" rows="10">{!! $order->desc !!}</textarea>
                </div>
                <div class="col-sm-12 b-r" style="margin-top:18px">
                    <div class="form-group col-sm-6">
                        <label> Giá trị đơn hàng</label> 
                        <input type="text"  readonly value="{{ $order->cart['total'] }}" class="form-control">
                        <input type="hidden" name="value" readonly value="{{ $order->payment == 'paid' ? 1 : $order->cart['total'] }}" class="form-control">
                         <div>
                            <label for="">Ghi chú:</label>
                            <div class="">
                                <strong>Tổng tiền:</strong> <span class="text-danger">{{ convert_price($order->cart['total'],true) }} đ</span>
                            </div>
                            <div class="">
                                <strong>Phí ship:</strong> <span class="text-danger">{{ convert_price($order->shipping_options['total'],true) }}đ</span>
                                <input type="hidden" name="shipcost"  value="{{ $order->shipping_options['total'] }}">
                            </div>
                            <div class="" style="padding:0 12px ">
                                Bao gồm:
                                <strong> Phí vận chuyển :</strong> <span>{{ convert_price($order->shipping_options['ship_fee_only'],true) }}</span>
                                <strong> Phí bảo hiểm hàng hóa :</strong> <span>{{ convert_price($order->shipping_options['insurance_fee'],true) }}</span>
                            </div>
                            
                         </div>
                         @if ($errors->has('value'))
                            <div class="" style="margin:6px 0px">
                                <span class="text-danger">{{ $error->first('value') }}</span>
                            </div>
                         @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Loại vận chuyển</label>
                        <select {{ $order->payment == 'paid'  ? 'readonly' : '' }} name="is_freeship" id="" class="form-control">
                            @foreach (config('apps.payment.is_freeship') as $key => $is_freeship)
                                <option 
                                {{ $order->payment == 'paid'  ? 'selected' : '' }}
                                 value="{{ $key }}">{{ $is_freeship }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('is_freeship'))
                            <div class="" style="margin:6px 0px">
                                <span class="text-danger">{{ $error->first('is_freeship') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 b-r" style="margin-top:18px">
                    <div class="form-group col-sm-6">
                        <label>Số tiền thu hộ {{ $order->payment == 'paid' ? "(chưa bao gồm phí vận chuyển)" : "(bao gồm phí vận chuyển)" }} </label> 
                        <input 
                        type="text" name="pick_money"  {{  $order->payment == 'paid' ? 'readonly' : '' }}
                        value="{{ $order->payment == 'paid' ?  0
                        : $order->cart['total'] + $order->shipping_options['total'] }}" 
                        class="form-control">
                        @if ($errors->has('pick_money'))
                            <div class="" style="margin:6px 0px">
                                <span class="text-danger">{{ $error->first('pick_money') }}</span>
                            </div>
                        @endif
                        
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Số tiền khách trả <strong>{{ $order->payment == 'paid' ? 0 : convert_price(($order->shipping_options['total'] + $order->total['cart']),true) }} đ</strong> </label>
                        
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>