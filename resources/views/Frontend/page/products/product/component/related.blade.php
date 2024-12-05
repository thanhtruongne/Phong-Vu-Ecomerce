<div class="">
    <div class="" style="margin-bottom: 24px;background: white;border-radius: 8px;">
        <div class="css-ftpi71">
            <div type="title" color="textTitle" class="title css-1dlj6qw">Sản phẩm liên quan</div>
        </div>
        <div class="glide_content">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @if (isset($product_related) && !is_null($product_related) && !empty($product_related))
                        @foreach ($product_related as $index =>  $product)
                            @php
                                $promotion = $product->sku_id ? $product->variant_promotion_price : $product->promotion->select(['name','id','amount'])->first(); 
                                $name =  $product->sku_id ?  $product->variant_name : $product->product_name;                                
                                $image = $product->sku_id ?  $product->variant_album : $product->image;
                                $price = $product->sku_id ?  $product->variant_price : $product->price;
                                $price_promtion_save = isset($promotion) && !empty($promotion)  ? ((int)$price - (int)$promotion['amount']) : null;
                            @endphp
                            <li class="glide__slide" >
                                <div  class="css-1ei4kcr ">
                                    <div class="css-1msrncq">
                                        <a href="#" style="text-decoration: none">
                                            <div class="css-4rhdrh">
                                                <div style="margin-bottom: 0.25rem;position: relative;">
                                                    <div class="" class="position-relative">
                                                        <div style="width:100%;height:100%;position: relative"  class="">
                                                            <img src="{{ $image }}" 
                                                            
                                                            style="width: 100%;height: 100%;object-fit: cover;">
                                                            @if (!empty($promotion))
                
                                                                <div class="position-absolute" style="width: 86px;bottom:0;left:0">
                                                                    <div class="css-zb7zul">
                                                                    <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                                    <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                                        {{ convert_price($promotion['amount'],true) }}
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            @endif                                          
                                                        </div>                        
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="css-90n0z6 text-uppercase">
                                                            {{$product->brand_name}}
                                                        </div>
                                                    </div>
                                                    {{-- Title --}}
                                                    <div style="margin-bottom: 0.25rem">
                                                        <div class="css-90n0z6">
                                                            {{ $name }}
                                                        </div>
                                                    </div>
                                                    {{-- desc --}}
                                                    <div style="height:3rem">
                                                    <div class="css-1uunp2d">
                                                            <h3 style="font-size: 0.75rem;font-weight: 400;line-height: 1rem;display: inline;">
                                                            {!! Str::limit($product->content, 20, '...') !!}
                                                            </h3>
                                                    </div>
                                                </div>
                                                {{-- price --}}
                                                <div style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                                        <div class="css-do31rh">
                                                            {{ convert_price($price_promtion_save,true)  }} ₫
                                                        </div>
                                                        @if (isset($promotion) && !empty($promotion))
                                                            <div style="display: flex;height: 1rem;">
                                                                <div class="css-18z00w6">
                                                                    {{ convert_price($price,true) }} đ
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
                            </li>     
                        @endforeach
                    @endif
                       
           
                </ul>
            </div>
        </div>   
    </div>
</div>

