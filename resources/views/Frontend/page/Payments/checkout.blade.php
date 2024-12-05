@extends('Frontend.layout.layout')
@section('title')
     Thanh toán
@endsection
@section('content')
    @php
        $breadcum = [
            [
                'name' => 'Trang chủ',
                'url' => route('home')
            ],
            [
                'name' => 'Thanh toán',
                'url' => route('checkout')
            ]
        ];
    @endphp
    <div class="container">
        <div class="w-100">
            {{-- breadcrumbs --}}
            <div class="breadcrumbs css-seb2g4">
                @include('Frontend.component.breadcrumbs',$breadcum)
            </div>
            <form action="" id="form-checkout-cart" method="POST" enctype="multipart/form-data">
                <div class="css-rf24tk">
                    <div class="teko-row css-zbluka" style="margin:0 -8px">    
                        <div class="teko-col teko-col-8 css-17ajfcv" style="padding: 0 8px">
                            <div class="css-1eks86m">
                                <div class="css-1557c61">
                                    <div class="css-1ms22as">
                                        @if (Auth::check())
                                            @php
                                                $address =  Auth::user()->address.', '. Auth::user()->ward->full_name.', '. Auth::user()->district->full_name.','. Auth::user()->province->full_name;
                                            @endphp
                                        <div class="css-qry4qr">
                                            <div class="" style="margin-bottom: 0.5rem;font-weight: bold;">
                                                Thông tin người nhận    
                                            </div>
                                            <div class="" style="line-height: 1.7;">
                                                <div class="mb-2"><strong>Người nhận:</strong> <span>{{ Auth::user()->name }}</span></div>
                                                <div class="mb-2"><strong>Email:</strong> <span>{{  Auth::user()->email }}</span></div>
                                                <div class="mb-2">
                                                    <strong>Địa chỉ: </strong>
                                                    <span>{!! $address !!}</span>
                                                </div>
                                                <div class="mb-2"><strong>Điện thoại: </strong><span>{{ Auth::user()->phone }}</span></div>
                                            </div>
                                        </div>
                                         {{-- <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                         <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                         <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                                         <input type="hidden" name="address" value="{{ Auth::user()->address }}">
                                         <input type="hidden" name="province_code" value="{{ Auth::user()->province_code }}">
                                         <input type="hidden" name="district_code" value="{{ Auth::user()->district_code }}">
                                         <input type="hidden" name="ward_code" value="{{ Auth::user()->ward_code }}"> --}}
                                         
                                        @else
                                            {{-- address --}}
                                            @include('Frontend.page.Payments.components.modal')         
                                         
                                        @endif
                                          {{-- Shipping --}}
                                          @include('Frontend.page.Payments.components.shipping_rule')

                                    </div>
                                </div>
                            </div>
                            {{-- desc --}}
                            @include('Frontend.page.Payments.components.desc')
                            {{-- mehthod payment --}}
                            @include('Frontend.page.Payments.components.paymentMethod')
                        </div>

                        {{--  --}}
                        <div class="css-9zicy3">
                            <div class="css-14xqo9c">
                                <div class="css-1euuut5">
                                    <div class="" style="font-size: 15px;line-height: 24px;font-weight: bold;">Thông tin đơn hàng</div>
                                    <a href="{{ route('cart') }}" style="text-decoration: none;color:#0d6efd">Chỉnh sửa</a>
                                </div>
                                {{-- body --}}
                                @include('Frontend.page.Payments.components.productCart',['cart' => $carts])
                            </div>
                            {{-- price --}}
                            @include('Frontend.page.Payments.components.price',['total' => $total])
                        </div>    
                    
                    </div>
                </div>
            </form>
        </div>
    </div>   
@endsection


@push('scripts')
   <script>
        $('#form-checkout-cart').submit(function(e){
           e.preventDefault();   
            var formData = $(this).serialize();
            $('#btn_submit_checkout').html('<i class="fa fa-spinner fa-spin"></i>').attr("disabled", true);
            checkOut(formData);
       })

       function checkOut(formData){
        $.ajax({
            type: 'POST',
            url: '{{route('order.store')}}',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if(data?.status == 'error'){
                    $('#btn_submit_checkout').html('Thanh toán').attr("disabled", false);
                    show_message(data?.message, data?.status);
                    return false;
                } else {
                    show_message(data?.message,data?.status);
                    if(data?.url){
                        window.location.href = data?.url;
                    } else {
                        return false;
                    }
                }
                $('#btn_submit_checkout').html('Thanh toán').attr("disabled", false);
            }
        }).fail(function(result) {
            $('#btn_submit_checkout').html('Thanh toán').attr("disabled", false);
            show_message('Lỗi dữ liệu', 'error');
            return false;
        });
       }
   </script>
   
@endpush