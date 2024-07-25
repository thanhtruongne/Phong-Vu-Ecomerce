
<div class="" style="width:80%;box-sizing: border-box;margin: 0px;min-width: 0px;">
    <div class="d-flex justify-content-between algin-items-center" style="margin-bottom: 1rem;">
        <div style="font-size: 1.25rem;font-weight: 500;margin: 0px;">Quản lý đơn hàng</div>
        <ul class="css-1ycoyke">
            @foreach (config('apps.payment.status_order') as $item)
                <li class="css-1i0g1st" data-id="{{ $item['value'] }}">{{ $item['title'] }}</li>
            @endforeach
            
        </ul>
    </div>
    <div class="d-flex flex-column justify-content-between" style="min-height: 70vh">
        <div class="" style="border-radius: 8px;background-color: rgb(255, 255, 255);position: relative;margin-bottom: 16px;">
            <div class="">
                <div style="min-height: 550px">
                    <table class="w-100" style="background-color: rgb(255, 255, 255);border-radius: 8px;border-spacing: 0px;">
                        <thead>
                            <tr>
                                <th class="th_row">Mã đơn hàng</th>
                                <th class="th_row">Ngày mua</th>
                                <th class="th_row" style="width: 36%;max-width: 40%;">Sản phẩm</th>
                                <th class="th_row text-end" >Tổng tiền</th>
                                <th class="th_row text-end" style="width: 16%">Trạng thái</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           
                            @if (count($orders) > 0)
                            @foreach ($orders as  $order)
                                <tr>
                                    <td class="text-center">
                                        <a 
                                        href="{{ route(Auth::guard('web')->check() ? 'account.order.detail' : 'guest.order.detail'
                                        ,$order->code) }}"
                                        style="color: rgb(4, 127, 255);text-decoration:none">{{ $order->code }}</a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->createdAt)->format('H:i d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="css-vrxw35">
                                           {{ $order->Order_products->first()->pivot->name }}
                                        </div>
                                    </td>
                                    <td class="text-end"  style="font-size: 14px;padding: 16px;width: max-content;vertical-align: top;">
                                    <span>{{ convert_price($order->cart['total'],true) }}đ</span>
                                    </td>
                                    <td class="text-end"  style="font-size: 14px;padding: 16px;width: max-content;vertical-align: top;">
                                    <div  style="color: rgb(214, 15, 41);">{!! confirm_order_status($order->confirm) !!}</div>
                                    </td>
                                </tr>
                            @endforeach
                            
                            @else
                                <tr>
                                    <td class="text-center">
                                        Đơn hàng trống
                                    </td>
                                </tr>
                            @endif
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
