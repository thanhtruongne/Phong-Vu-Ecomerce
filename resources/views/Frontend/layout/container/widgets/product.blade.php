@if (isset($widgets) && !empty($widgets))
@foreach ($widgets as $key => $widget)
            <div class="loading" style="margin-top: 30px">
                <div class="css-k9y40f">
                    <div class="position-relative" style="min-height: 416px">
                        <img class="position-absolute w-100 h-100" style="top:0px"
                        src="{{ $widget->image ?? '' }}" alt="">
                        
                        <div class="css-1ld3dfv">
                            <a href="" style="text-decoration: none;olor: unset;cursor: pointer;">
                                <div class="css-t2k8cn" style="padding: 0px 8px;">{!! $widget->content !!}</div>
                            </a>
            
                            <a href="" style="text-decoration: none;color: unset;cursor: pointer;">
                                <div class="css-t2k8cn" style="cursor: pointer;color: rgb(255, 255, 255);">
                                    Xem tất cả
                                    <svg 
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        class="css-ymxljd" 
                                        color="white" height="1em"
                                        width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.49976 19.0001L15.4998 12.0001L8.49976 5.00012" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                    </svg>
                                </div>
                            </a>
                        </div>  
                        <div class="glide_{{ $key }}" style="padding: 12px">
                            <div class="glide__track" data-glide-el="track">
                                <ul class="glide__slides">
                                    @foreach ($widget->data as $index => $data)
                                        
                                         @php
                                            // $sort = $item->attributes->pluck('id')->toArray();
                                            // sort($sort,SORT_NUMERIC);                
                                            // $name_slug = [];
                                            // if(isset($item) && !empty($item)); {
                                            //     $name_variant = $item->name;        
                                            //     $name = $product->name.' ('.$name_variant.')';
                                            //     foreach(explode(', ',$name_variant) as $variant) {
                                            //         $name_slug[] = Str::slug($variant);
                                            //     }
                                            //     $product_price_after_discount = 0;
                                            //     if(!empty($item->promotions)) {     
                                            //         $product_price_after_discount = 
                                            //         $item->promotions['product_variant_price'] - $item->promotions['discount'] ;                       
                                            //     }
                                            //     else $product_price_after_discount = $item->price;
                                                
                                                
                                            //     $url = $product->canonical.'---'.implode('--',$name_slug).'?sku='.$item->sku;
                                            //     $canonical = makeTheURL($url,true); 
                                            // }
                                            // dd($data);
                                            $promotion = $data->promotion->select(['name','id','amount'])->first();                                        
                                            $image = $data->image ? $data->image : explode(',',$data->album)[0];
                                            $price = $promotion ? ((int)$data->price - (int)$promotion['amount']) : $data->price;
                                        @endphp 
                                        {{-- Use Foreach load widget --}}
                                        <li class="glide__slide" style="width: 20%" >
                                            <div  class="css-1ei4kcr">
                                                <div class="css-1msrncq">
                                                    <a href="#" style="text-decoration: none">
                                                        <div class="css-4rhdrh">
                                                            <div style="margin-bottom: 0.25rem;position: relative;">
                                                                <div class="position-relative" style="padding-bottom: 100%;">
                                                                    <div class="bg-image w-100 h-100">
                                                                        <img class="w-100 h-100 object-fit-contain position-absolute" src="{{ $image }}" 
                                                                        style="top: 0px;left: 0px">
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
                                                                       {{$data->brand_name}}
                                                                    </div>
                                                                </div>
                                                                {{-- Title --}}
                                                                <div class="my-2">
                                                                    <div class="css-1uunp2d">
                                                                        <h3 class="css-1xdyrhj"> {{ $data->name }}</h3>
                                                                    </div>
                                                                </div>
                                                                {{-- desc --}}
                                                                <div style="height:3rem">
                                                                <div class="css-1uunp2d">
                                                                        <h3 style="font-size: 0.75rem;font-weight: 400;line-height: 1rem;display: inline;">
                                                                            {!! Str::limit($data->content,20, '...') !!}
                                                                        </h3>
                                                                </div>
                                                            </div>
                                                            {{-- price --}}
                                                            <div style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                                                    <div class="css-do31rh">
                                                                        {{ convert_price($price,true)  }} ₫
                                                                    </div>
                                                                    @if (isset($promotion) && !empty($promotion))
                                                                        <div style="display: flex;height: 1rem;">
                                                                            <div class="css-18z00w6">
                                                                                {{ convert_price($data->price,true) }} đ
                                                                            </div>
                                                                            <div class="css-2rwx6s">
                                                                                - {{ number_format(100 - (((int)$price / (int)$data->price) * 100),2) }} %
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
                                </ul>
                            </div>
                        </div>
                        <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left " style="left:0rem;box-shadow:none;outline: none;border: none;" data-glide-dir="<">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggb3BhY2l0eT0iMC4zIiBkPSJNMCAwSDI0QzM3LjI1NDggMCA0OCAxMC43NDUyIDQ4IDI0QzQ4IDM3LjI1NDggMzcuMjU0OCA0OCAyNCA0OEgwVjBaIiBmaWxsPSIjMUIxRDI5Ii8+CjxwYXRoIGQ9Ik0yNi41IDE4TDIwLjUgMjRMMjYuNSAzMCIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="">
                            </button>
                            <button class="glide__arrow glide__arrow--right " style="right:0rem;box-shadow:none;outline: none;border: none;" data-glide-dir=">">
                                <img src=" data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggb3BhY2l0eT0iMC4zIiBkPSJNMCAyNEMwIDEwLjc0NTIgMTAuNzQ1MiAwIDI0IDBINDhWNDhIMjRDMTAuNzQ1MiA0OCAwIDM3LjI1NDggMCAyNFoiIGZpbGw9IiMxQjFEMjkiLz4KPHBhdGggZD0iTTIxLjUgMzBMMjcuNSAyNEwyMS41IDE4IiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=" alt="">
                            </button>
                        </div>
                
                        
                        </div>               
                    </div>
        </div>           
        @push('scripts')
            <script>
                
                var glide =  new Glide(`.glide_{{ $key }}`,{
                type: 'carousel',
                startAt: 0,
                perView: 5,
                autoplay : 100000000,
                animationDuration: 1000
                })
                glide.mount();
            </script>
        @endpush
       
        
        
    @endforeach
@endif





