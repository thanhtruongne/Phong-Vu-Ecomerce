<div class="" style="width:30%;">
    <div class="" style="background-color: #fff;padding:16px">
        <div class="" style="display:flex;justify-content:space-between;align-items:center">
            <div class="" >
                <i class="fa-solid fa-user" style="margin-right:4px"></i>
                <strong>Thông tin người nhận </strong>    
            </div>
            <div class="chanage_edit_the_user" data-target='districts' data-code="{{ $order->code }}" style="text-align: right;cursor:pointer;">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div class="toogle_check_close none_toggle" style="text-align: right;cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>
        <form action="{{ route('private-system.management.order.updateOrder',$order->code) }}" method="POST">
            @csrf
        <hr style="margin-left: -17px;font-size:25px;margin-right: -17px;">
        <div class="render_info_user">
            <div class="" style="margin-bottom:14px">
                <strong>Tên: </strong>
                <span>{{ $order->name }}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Email: </strong>
                <span>{{ $order->email }}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Điện thoại: </strong>
                <span>{{ $order->phone }}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Địa chỉ: </strong>
                <span>{{ $address }}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Ghi chú: </strong>
                <textarea readonly class="form-control" name="desc" style="height:100px" id="" cols="20" rows="10">{!! Str::of($order->desc)->trim() !!}</textarea>
            </div>
           
        </div>
        @include('backend.Page.order.components.address')
    </div>
    @if ($order->payment == 'paid' && $order->method != 'cod')
        <div class="" style="background-color: #fff;padding:16px;margin-top:16px">
            <div class="" style="display:flex;justify-content:space-between;align-items:center">
                <div class="" >
                    <i class="fa-solid fa-credit-card" style="margin-right:6px;"></i>
                    <strong>Thông tin thanh toán</strong>    
                </div>
            </div>
            <hr style="margin-left: -17px;font-size:25px;margin-right: -17px;">
            <div class="">
                <div class="" style="margin-bottom:14px">
                    <strong>Mã giao dịch: </strong>
                    <span>{{ $order->order_payment->payment_id }}</span>
                </div>
                <div class="" style="margin-bottom:14px">
                    <strong>Phương thức thanh toán: </strong>
                    <span>{{ Str::upper($order->order_payment->methodName) }}</span>
                </div>
                <div class="" style="margin-bottom:14px">
                    <strong>Thanh toán bằng : </strong>
                     {!! payment_svg($order->method) !!}
                </div>
                <div class="" style="margin-bottom:14px">
                    <strong>Tổng số tiền: </strong>
                    <span>{{ convert_price($order->cart['total'] + $order->shipping_options['total'],true ) }}đ</span>
                </div>
            </div>
        </div>
    @endif
    
</div>