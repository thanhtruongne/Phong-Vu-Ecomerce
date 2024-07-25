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
                            {{-- @php
                    //   dd($related->promotions[0]['id']);
                                $product_price_after_discount_related = 
                                isset($related->promotions) && !empty($related->promotions) 
                                ? $related->price - $related->promotions[0]['discount']
                                : $related->price; 
                                $canonical = makeTheURL($related->canonical,true,false); 
                            @endphp --}}
                         
                        @endforeach
                    @endif
                       
           
                </ul>
            </div>
        
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left access_arrow_slide_left"  style="border:none;outline:none;box-shadow:none;left:8em;top:174%" data-glide-dir="<">
                      <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggb3BhY2l0eT0iMC4zIiBkPSJNMCAwSDI0QzM3LjI1NDggMCA0OCAxMC43NDUyIDQ4IDI0QzQ4IDM3LjI1NDggMzcuMjU0OCA0OCAyNCA0OEgwVjBaIiBmaWxsPSIjMUIxRDI5Ii8+CjxwYXRoIGQ9Ik0yNi41IDE4TDIwLjUgMjRMMjYuNSAzMCIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="">
                </button>
                <button class="glide__arrow glide__arrow--right access_arrow_slide_right"  style="border:none;outline:none;box-shadow:none;top:174%;right:8em" data-glide-dir=">">
                     <img src=" data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggb3BhY2l0eT0iMC4zIiBkPSJNMCAyNEMwIDEwLjc0NTIgMTAuNzQ1MiAwIDI0IDBINDhWNDhIMjRDMTAuNzQ1MiA0OCAwIDM3LjI1NDggMCAyNFoiIGZpbGw9IiMxQjFEMjkiLz4KPHBhdGggZD0iTTIxLjUgMzBMMjcuNSAyNEwyMS41IDE4IiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=" alt="">
                </button>
            </div>
        </div>   
    </div>
</div>

