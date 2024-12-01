<div class="css-1y2krk0" id="render_data">
    {{-- @if (isset($products) && !empty($products))
        @foreach ($products as $key => $product)
            @php
                $promotion = $product->sku_id ? $product->variant_promotion_price : $product->promotion->select(['name','id','amount'])->first(); 
                $name =  $product->sku_id ?  $product->variant_name : $product->product_name;                                
                $image = $product->sku_id ?  $product->variant_album : $product->image;
                $price = $product->sku_id ?  $product->variant_price : $product->price;
                $price_promtion_save = isset($promotion) && !empty($promotion)  ? ((int)$price - (int)$promotion['amount']) : null;
            @endphp
            <div class="" style="background: white;margin-bottom: 2px;width: calc(20% - 2px);">
                <div class="css-1msrncq fill_parent">
                    <a href="#" class="d-block" style="text-decoration: none">
                        <div class="" style="position-relative" style="margin-bottom:0.5rem">
                            <div class="" style="margin-bottom: 0.25rem">
                                <div class="position-relative"  style="padding-bottom: 100%">
                                    <img src="{{$image}}"
                                    class="w-100 h-100 object-fit-contain position-absolute" style="top:0px;left:0px"
                                    alt="">
                                    @if (!empty($promotion))
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
                                    {{$product->brand_name}}
                                </div>
                            </div>
                            <div class="my-2">
                                <div class="css-1uunp2d">
                                    <h3 class="css-1xdyrhj"> {{ $name }}</h3>
                                </div>
                            </div>
                            <div class="" style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                <div class="d-flex flex-column" style="height:2.5rem;">
                                    <div type="subtitle" class="att-product-detail-latest-price css-do31rh" color="primary500">   {{ convert_price((int)$price,true)  }} ₫</div>
                                    @if (isset($promotion) && !empty($promotion))
                                        <div class="d-flex" style="height:1rem">
                                            <div type="caption" class="att-product-detail-retail-price css-18z00w6" color="textSecondary">    {{ convert_price($price_promtion_save,true) }} đ</div>
                                            <div type="caption" color="primary500" class="css-2rwx6s">   - {{ number_format(100 - (((int)$price_promtion_save / (int)$price) * 100),2) }} %</div>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </a> --}}
                    {{-- <div class="">
                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                        <input type="hidden" name="product_variant_id" value="{{ $item->id }}">
                        <input type="hidden" name="qualnity" value="1">
                        <input type="hidden" name="price" value="{{ $item->price ?? $product->price }}">
                        <input type="hidden" name="price_after_discount" value="{{ $product_price_after_discount ?? 0 }}">
                        <input type="hidden" name="discountValue" value="{{ $item->promotions['discountValue'] ?? null }}">
                        <input type="hidden" name="discountType" value="{{  $item->promotions['discountType'] ?? null }}">
                        <input type="hidden" name="attribute_id" value="{{ $item->code }}">
                        <input type="hidden" name="attribute_name" value="{{ $item->name}}">
                    
                    </div> --}}
                    {{-- <button height="2rem" color="primary500" class="css-16gdkk6 add_to_cart_list" type="button">
                        <div type="body" class="button-text css-ct8m8z" color="primary500">Thêm vào giỏ</div>
                        <span style="margin-left: 0px;">
                            <div class="css-157jl91"></div>
                        </span>
                    </button> 
                </div>
            </div>
          
        @endforeach
        
    @endif --}}
       
     

</div>