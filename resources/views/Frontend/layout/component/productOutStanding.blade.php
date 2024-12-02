<div class="mt-3">
    <div class="bg-white">
        <div class="css-ftpi71" style="padding-left:16px">
            <div class="css-1dlj6qw">Sản phẩm nổi bật</div>
            <div class="">
                <div color="" class="css-k6wbw">
                    Xem tất cả
                    <svg fill="none" viewBox="0 0 24 24" class="css-9w5ue6" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8.49976 19.0001L15.4998 12.0001L8.49976 5.00012" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </div>
            </div>
        </div>

        <div class="css-1y2krk0 d-flex" style="flex-wrap: wrap;column-gap: 2px;">
            @if (isset($products) && !empty($products))
                @foreach ($products as  $product)
                    @php
                        $promotion = $product->variant_id ? $product->variant_promotion_price : $product->promotion->select(['name','id','amount'])->first(); 
                        $name =  $product->variant_id ?  $product->variant_name : $product->product_name;                                
                        $image = $product->variant_id ?  $product->variant_album : $product->image;
                        $price = $product->variant_id ?  $product->variant_price : $product->price;
                        $price_promtion_save = isset($promotion) && !empty($promotion)  ? ((int)$price - (int)$promotion['amount']) : null;
                   @endphp
                    <div class="bg-white mb-2" style="width: calc(20% - 2px);">
                        <div  class="css-1ei4kcr" style="">
                            <div class="css-1msrncq">
                                <a href="" style="text-decoration: none">
                                    <div class="css-4rhdrh">
                                        <div class="position-relative" style="margin-bottom: 0.25rem;">
                                            <div class="position-relative" style="padding-bottom: 100%;">
                                                <div class="bg-image w-100 h-100">
                                                    <img src="{{ $image }}"  class="w-100 h-100 position-absolute object-fit-contain"
                                                    style="top: 0px;left: 0px">
                                                    @if (isset($promotion) && !empty($promotion))
                                                        <div class="position-absolute" style="width: 94px;bottom:0;left:0">
                                                            <div class="css-zb7zul">
                                                                <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                                <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                                    {{ convert_price($promotion['amount'],true) }} đ
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                </div>                        
                                            </div>
                                            <div class="mt-2">
                                                <div class="css-90n0z6 text-uppercase">
                                                   {{ $product->brand_name }}
                                                </div>
                                            </div>
                                            {{-- Title --}}
                                            <div style="margin-bottom: 0.25rem">
                                                <div class="">
                                                    {{ $name }}
                                                </div>
                                            </div>
                                            {{-- desc --}}
                                            <div style="height:3rem">
                                                <div class="css-1uunp2d">
                                                    <h3 style="font-size: 0.75rem;font-weight: 400;line-height: 1rem;display: inline;">
                                                        {!! Str::limit($product->content,20, '...') !!}   
                                                    </h3>
                                                </div>
                                            </div>
                                            {{-- price --}}
                                            <div style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                                <div class="css-do31rh">
                                                    {{-- @dd((int)$product->price) --}}
                                                    {{ convert_price((int)$price,true)  }} ₫
                                                </div>
                                                @if (isset($promotion) && !empty($promotion))
                                                    <div style="display: flex;height: 1rem;">
                                                        <div class="css-18z00w6">
                                                            {{ convert_price($price_promtion_save,true) }} đ
                                                        </div>
                                                        <div class="css-2rwx6s">
                                                            - {{ number_format(100 - (((int)$price_promtion_save / (int)$price) * 100),2) }} %
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
        
                                        </div>
                                    </div>
                                </a>
                                <button class="css-16gdkk6">
                                    <div class="css-ct8m8z">
                                        Thêm giỏ hàng
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
           
            
        </div>

        <div class="mt-3">
             <div class="w-100 text-center">
                <div class="css-19xt07j">
                    
                </div>
             </div>
        </div>
    </div>
</div>