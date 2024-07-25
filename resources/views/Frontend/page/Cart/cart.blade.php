@extends('Frontend.layout.layout')
@section('title')
    Giỏ hàng
@endsection
@section('content')
    <div class="container">
        <div class="w-100">
            {{-- breadcrumbs --}}
           
            @if (isset($carts) && !empty($carts) && count($carts) > 0)
         <div class="breadcrumbs css-seb2g4">
                {{ Breadcrumbs::view('partial.frontend.breadcrumbs','cart') }}         
            </div>
            <div class="css-117j3zt">
                <div class="d-flex algin-items-center justify-content-between" style="width:67%">
                       <div class="css-1cp1h79">Giỏ hàng</div>
                       <button class="css-tj2ae3 clear_cart">Xóa tất cả</button>
                </div>
              </div>
   
                <div class="d-flex" style="margin: 0;min-width:0">
                   <div class="css-8x68m">
                       <div class="css-1yvxdyp">
                           <div class="" style="padding-bottom: 0.25rem">
                               <div class="teko-row css-8m0ae5 justify-content-between align-items-center">
                                   <div class="teko-col css-17ajfcv" style="flex: 0 0 4%;">
                                       <label for="" class="css-1u2186j">
                                           <div class="css-l24w9c">
                                               <input type="checkbox" class="form-check-input">
                                           </div>
                                       </label>
                                   </div>
   
                                   <div class="teko-col css-17ajfcv" style="flex: 0 0 96%;">
                                       <div class="teko-row justify-content-between align-items-center css-1qrgscw">
                                           
                                           <div class="teko-col teko-col-6 css-17ajfcv">
                                               <div class="css-1j4ksfn">
                                                   <div class="css-4eq9p2">Chi tiết sản phẩm</div>
                                               </div>
                                           </div>
                                           <div class="teko-col teko-col-2 css-14k6732">
                                              <div class="css-1dqxh16">Đơn giá</div>
                                           </div>
                                           <div class="teko-col teko-col-2 css-14k6732 text-center" >
                                               <div class="css-1dqxh16">Số lượng</div>
                                            </div>
                                            <div class="teko-col teko-col-2 css-14k6732 text-right" style="">
                                               <div class="css-1dqxh16">Thành tiền</div>
                                            </div>
   
                                       </div>
                                   </div>
                               </div>
                               {{-- data table render --}}
                               <div class="css-ehdnal">
                                   @foreach ($carts as $key => $cart)
                                        <div class="teko-row teko_self_row jusitfy-content-between align-items-center css-1qrgscw" style="padding-bottom:20px">
                                            <div class="teko-col css-17ajfcv" style="flex: 0 0 4%;">
                                                <label for="" class="css-1u2186j">
                                                    <div class="css-l24w9c">
                                                        <input type="checkbox" class="form-check-input" name="{{ $cart->rowId }}">
                                                    </div>
                                                </label>
                                            </div>
        
                                            <div class="teko-col css-17ajfcv" style="flex: 0 0 96%;">
                                                <div class="teko-row justify-content-between align-items-center css-1qrgscw">                               
                                                    
                                                    @include('Frontend.page.Cart.component.info',['cart' => $cart])

                                                    @include('Frontend.page.Cart.component.price',['cart' => $cart])

                                                    @include('Frontend.page.Cart.component.minus&plus',['cart' => $cart])

                                                    
                                                    <div class="teko-col teko-col-2 css-1g0wtwt">
                                                        <div class="teko-col css-17ajfcv">
                                                        <div class="teko-row justify-content-end align-items-center css-1qrgscw">
                                                            <span class="css-rmdhxt price_all" style="color : rgba(20,53,195,1)">{{ 
                                                            convert_price($cart->options->priceSale == 0 || is_null($cart->options->priceSale)  
                                                            ? $cart->price_previous * $cart->qty
                                                             : $cart->options->priceSale * $cart->qty,true) 
                                                            }}đ </span>
                                                        </div>
                                                        </div>
                                                    </div>
            
                                                </div>
                                            </div>
                                        </div>
                                   @endforeach
                                   
                              
                                   
                               </div>
                           </div>
                       </div>
                   </div>
   
                   <div class="css-8xcfft ">
                       <div class="css-1pmyljg">
                           <div class="cart_title">
                               <h6>Thanh toán</h6>
                           </div>
   
                           <div class="cart_body">
                               <div class="css-l1po7j">
                                   <div class="teko-row justify-content-between align-items-center css-33wqqr">
                                       <div type="subtitle" class="css-1lg3tx0">Tổng tạm tính</div>
                                       <div class="teko-col css-17ajfcv" style="text-align: right;">
                                           <div type="subtitle" color="" id="price_yet_cart" class="css-nbdyuc">{{ convert_price($total,true) }}₫</div>
                                       </div>
                                   </div>
                                    <div class="teko-row justify-content-between align-items-center css-33wqqr">
                                        <div type="subtitle" class="css-1lg3tx0">Thành tiền</div>
                                        <div class="teko-col css-17ajfcv" style="text-align: right;">
                                            <div type="subtitle" color="" id="price_total_cart" class="css-nbdyuc" style="color:rgb(20, 53, 195);font-weight:600">
                                                {{ convert_price($total,true) }}₫
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer_cart">
                                        <div class="">
                                            <a style="text-decoration: none" href="{{ route('checkout') }}" class="css-v463h2">
                                                TIẾP TỤC
                                            </a>
                                        </div>
                                    </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            @else

            <div class="css-1bqbden">
                <div class="">
                    <div class="css-18zym6u">
                        <div class="css-11f6yue w-100">
                            <img 
                            src="https://shopfront-cdn.tekoapis.com/static/empty_cart.png" 
                            style="width: 100%;height: 100%;object-fit: inherit;position: absolute;top: 0px;left: 0px;" alt="">
                        </div>
                        <div class="css-1qoenic">Giỏ hàng chưa có sản phẩm nào</div>
                        <a class="buy-now css-fhio94" href="{{ route('home') }}" style="text-decoration: none">
                            <div type="body" class="button-text css-2h64mz" color="white">Mua sắm ngay</div>
                        </a>
                    </div>
                </div>
            </div>
            @endif 
          
         



        </div>
    </div>   
        
@endsection