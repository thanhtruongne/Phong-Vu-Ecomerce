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
                        @if (isset($product->variant) && !empty($product->variant))
                            @foreach ($product->variant as $variant)
                                @php
                                    $sort = $variant->attributes->pluck('id')->toArray();
                                    sort($sort,SORT_NUMERIC);                
                                    $name_slug = [];
                                    if(isset($variant) && !empty($variant)); {
                                        $name_variant = $variant->name;        
                                        $name = $product->name.' ('.$name_variant.')';
                                        foreach(explode(', ',$name_variant) as $variants) {
                                            $name_slug[] = Str::slug($variants);
                                        }
                                        $product_price_after_discount = 0;
                                        if(!empty($variant->promotions)) {     
                                            $product_price_after_discount = 
                                            $variant->promotions['product_variant_price'] - $variant->promotions['discount'] ;                       
                                        }
                                        else $product_price_after_discount = $variant->price;   
                                        $url = $product->canonical.'---'.implode('--',$name_slug).'?sku='.$variant->sku;
                                        $canonical = makeTheURL($url,true);

                                    } 
                                @endphp
                                   <li class="glide__slide" >
                                    <div  class="css-1ei4kcr ">
                                        <div class="css-1msrncq">
                                            <a href="{{ $canonical }}" style="text-decoration: none">
                                                <div class="css-4rhdrh">
                                                    <div style="margin-bottom: 0.25rem;position: relative;">
                                                        <div class="" class="position-relative">
                                                            <div style="width:100%;height:100%;position: relative"  class="">
                                                                <img src="{{ explode(',',$variant->album)[0] }}" 
                                                                
                                                                style="width: 100%;height: 100%;object-fit: cover;">
                                                                @if (!empty($variant->promotions))
                    
                                                                    <div class="position-absolute" style="width: 86px;bottom:0;left:0">
                                                                        <div class="css-zb7zul">
                                                                        <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                                        <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                                            {{ convert_price($variant->promotions['discount'],true) }}
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                @endif                                          
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
                                                                {{ convert_price($product_price_after_discount,true)  }} ₫
                                                            </div>
                                                            @if (isset($variant->promotions) && !empty($variant->promotions))
                                                                <div style="display: flex;height: 1rem;">
                                                                    <div class="css-18z00w6">
                                                                        {{ convert_price($variant->price,true) }} đ
                                                                    </div>
                                                                    <div class="css-2rwx6s">
                                                                        - {{ $variant->promotions['discountValue'] }} {{ $variant->promotions['discountType'] }}
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
                            @php                                          
                                $name = $product->name;
                                $url = $product->canonical;
                                $product_price_after_discount = 0;
                                if(!empty($product->promotions)) {     
                                    $product_price_after_discount = 
                                    $product->promotions[0]['product_price'] - $product->promotions[0]['discount'] ;                       
                                }
                                else $product_price_after_discount = $product->price;
                                $canonical = makeTheURL($url,true); 
                            @endphp
                            <li class="glide__slide" style="width: 20%" >
                                <div  class="css-1ei4kcr">
                                    <div class="css-1msrncq">
                                        <a href="{{ $canonical }}" style="text-decoration: none">
                                            <div class="css-4rhdrh">
                                                <div style="margin-bottom: 0.25rem;position: relative;">
                                                    <div class="position-relative" style="padding-bottom: 100%;">
                                                        <div style="width:100%;height:100%"  class="hover-zoom bg-image">
                                                            <img src="{{ $product->image ?? '' }}" 
                                                            style="width: 100%;height: 100%;object-fit: contain;position: absolute;top: 0px;left: 0px">
                                                            @if (!empty($product->promotions))
                                                                <div class="position-absolute" style="width: 94px;bottom:0;left:0">
                                                                    <div class="css-zb7zul">
                                                                        <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                                        <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                                        
                                                                            {{ convert_price($product->promotions[0]['discount'],true) }} đ
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
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
                                                            {{ convert_price($product_price_after_discount,true)  }} ₫
                                                            </div>
                                                            @if (!empty($product->promotions))
                                                                <div style="display: flex;height: 1rem;">
                                                                    <div class="css-18z00w6">
                                                                        {{ convert_price($product->price,true) }} đ
                                                                    </div>
                                                                    <div class="css-2rwx6s">
                                                                        - {{ $product->promotions[0]['discountValue'] }} {{ $product->promotions[0]['discountType'] }}
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

