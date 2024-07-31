<div class="css-1y2krk0 render_method_products">
    @if (isset($products) && !empty($products))
        @foreach ($products as $key => $product)
            @if (isset($product->variant) && !empty($product->variant))
                @foreach ($product->variant as $item)
             
                    @php
                        $sort = $item->attributes->pluck('id')->toArray();
                        sort($sort,SORT_NUMERIC);                
                        $name_slug = [];
                        if(isset($item) && !empty($item)); {
                            $name_variant = $item->name;        
                            $name = $product->name.' ('.$name_variant.')';
                            foreach(explode(', ',$name_variant) as $variant) {
                                $name_slug[] = Str::slug($variant);
                            }
                            $product_price_after_discount = 0;
                            if(!empty($item->promotions)) {     
                                $product_price_after_discount = 
                                $item->promotions['product_variant_price'] - $item->promotions['discount'] ;                       
                            }
                            else $product_price_after_discount = $item->price;
                            
                            
                            $url = $product->canonical.'---'.implode('--',$name_slug).'?sku='.$item->sku;
                            $canonical = makeTheURL($url,true);
                        
                          
                        }
                    @endphp
                      {{-- item --}}
                    <div class="" style="background: white;margin-bottom: 2px;width: calc(20% - 2px);">
                        <div class="css-1msrncq fill_parent">
                            <a href="{{ $canonical }}" class="d-block" style="text-decoration: none">
                                <div class="" style="position-relative" style="margin-bottom:0.5rem">
                                    <div class="" style="margin-bottom: 0.25rem">
                                        <div class="position-relative"  style="padding-bottom: 100%">
                                            <img src="{{ explode(',',$item->album)[0] }}"
                                            class="w-100 h-100 object-fit-contain position-absolute" style="top:0px;left:0px"
                                            alt="">
                                            @if (!empty($item->promotions))
                                            <div class="position-absolute" style="width: 94px;bottom:0;left:0">
                                                <div class="css-zb7zul">
                                                    <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                    <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                    
                                                        {{ convert_price($item->promotions['discount'],true) }} đ
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    {{-- title --}}
                                    <div class="" style="margin-bottom: 0.25rem">
                                        <div type="body" color="textSecondary" class="product-brand-name css-90n0z6" style="text-transform: uppercase; display: inline;">
                                            {{ Str::upper($product->product_cataloge->name) }}
                                        </div>
                                    </div>
                                    {{-- desc --}}
                                    <div class="" style="height:3rem">
                                        <div type="caption" class="att-product-card-title css-1uunp2d" color="textPrimary">
                                            <h3 
                                            title="Laptop ASUS Vivobook 15X Oled M3504YA-L1268W (Ryzen 5 7530U/RAM 16GB/512GB SSD/ Windows 11)" 
                                            class="css-1xdyrhj name_category_product">
                                                {{ $name }}
                                            </h3>
                                        </div>
                                    </div>
                                    {{-- price --}}
                                    <div class="" style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                        <div class="d-flex flex-column" style="height:2.5rem;">
                                            <div type="subtitle" class="att-product-detail-latest-price css-do31rh" color="primary500">
                                                {{ convert_price($product_price_after_discount,true) }}₫
                                            </div>
                                            @if (isset($item->promotions) && !empty($item->promotions))
                                                <div class="d-flex" style="height:1rem">
                                                    <div type="caption" class="att-product-detail-retail-price css-18z00w6" color="textSecondary">{{ convert_price($item->price) }}&nbsp;₫</div>
                                                    <div type="caption" color="primary500" class="css-2rwx6s">-{{ $item->promotions['discountValue'] }}{{ $item->promotions['discountType'] }}</div>
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="">
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="product_variant_id" value="{{ $item->id }}">
                                <input type="hidden" name="qualnity" value="1">
                                <input type="hidden" name="price" value="{{ $item->price ?? $product->price }}">
                                <input type="hidden" name="price_after_discount" value="{{ $product_price_after_discount ?? 0 }}">
                                <input type="hidden" name="discountValue" value="{{ $item->promotions['discountValue'] ?? null }}">
                                <input type="hidden" name="discountType" value="{{  $item->promotions['discountType'] ?? null }}">
                                <input type="hidden" name="attribute_id" value="{{ $item->code }}">
                                <input type="hidden" name="attribute_name" value="{{ $item->name}}">
                            
                            </div>
                            <button height="2rem" color="primary500" class="css-16gdkk6 add_to_cart_list" type="button">
                                <div type="body" class="button-text css-ct8m8z" color="primary500">Thêm vào giỏ</div>
                                <span style="margin-left: 0px;">
                                    <div class="css-157jl91"></div>
                                </span>
                            </button> 
                        </div>
                    </div>
                @endforeach
            
            @else
                @php                                        
                    $name = $product->name;
                    $url = $product->canonical;
                    $product_price_after_discount = 0;
                    if(!empty($product->promotions)) {     
                        $product_price_after_discount = 
                        $product->promotions['product_variant_price'] - $product->promotions['discount'] ;                       
                    }
                    else $product_price_after_discount = $product->price;
                    $canonical = makeTheURL($url,true); 
                @endphp
                {{-- item --}}
                <div class="" style="background: white;margin-bottom: 2px;width: calc(20% - 2px);">
                    <div class="css-1msrncq fill_parent">
                        <a href="{{ $canonical }}" class="d-block" style="text-decoration: none">
                            <div class="" style="position-relative" style="margin-bottom:0.5rem">
                                <div class="" style="margin-bottom: 0.25rem">
                                    <div class="position-relative"  style="padding-bottom: 100%">
                                        <img src="{{ $product->image }}"
                                        class="w-100 h-100 object-fit-contain position-absolute" style="top:0px;left:0px"
                                        alt="">
                                        @if (!empty($product->promotions))
                                        <div class="position-absolute" style="width: 94px;bottom:0;left:0">
                                            <div class="css-zb7zul">
                                                <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                
                                                    {{ convert_price($product->promotions['discount'],true) }} đ
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                {{-- title --}}
                                <div class="" style="margin-bottom: 0.25rem">
                                    <div type="body" color="textSecondary" class="product-brand-name css-90n0z6" style="text-transform: uppercase; display: inline;">
                                        {{ Str::upper($product->product_cataloge->name) }}
                                    </div>
                                </div>
                                {{-- desc --}}
                                <div class="" style="height:3rem">
                                    <div type="caption" class="att-product-card-title css-1uunp2d" color="textPrimary">
                                        <h3 
                                        title="Laptop ASUS Vivobook 15X Oled M3504YA-L1268W (Ryzen 5 7530U/RAM 16GB/512GB SSD/ Windows 11)" 
                                        class="css-1xdyrhj name_category_product">
                                            {{ $name }}
                                        </h3>
                                    </div>
                                </div>
                                {{-- price --}}
                                <div class="" style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                    <div class="d-flex flex-column" style="height:2.5rem;">
                                        <div type="subtitle" class="att-product-detail-latest-price css-do31rh" color="primary500">14.690.000&nbsp;₫</div>
                                        @if (isset($product->promotions) && !empty($product->promotions))
                                            <div class="d-flex" style="height:1rem">
                                                <div type="caption" class="att-product-detail-retail-price css-18z00w6" color="textSecondary">{{ convert_price($product->price) }}&nbsp;₫</div>
                                                <div type="caption" color="primary500" class="css-2rwx6s">-{{ $product->promotions['discountValue'] }}{{ $product->promotions['discountType'] }}</div>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_variant_id" value="">
                            <input type="hidden" name="qualnity" value="1">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="price_after_discount" value="{{ $product_price_after_discount ?? 0 }}">
                            <input type="hidden" name="discountValue" value="{{ $product->promotions['discountValue'] ?? null }}">
                            <input type="hidden" name="discountType" value="{{  $product->promotions['discountType'] ?? null }}">
                            <input type="hidden" name="attribute_id" value="{{ $product->code_product }}">
                            <input type="hidden" name="attribute_name" value="{{ $product->name}}">
                        
                        </div>
                        <button height="2rem" color="primary500" class="css-16gdkk6 add_to_cart_list" type="button">
                            <div type="body" class="button-text css-ct8m8z" color="primary500">Thêm vào giỏ</div>
                            <span style="margin-left: 0px;">
                                <div class="css-157jl91"></div>
                            </span>
                        </button> 
                    </div>
                </div>
            @endif
          
        @endforeach
        
    @endif
       
     

    </div>