@extends('Frontend.layout.layout')
@section('title')
    Trang chi tiết
@endsection



@section('content')
    @php
        $breadcum = [];
        if($childCategory) {
            foreach ($childCategory as $key => $breadcrumb) {
                $breadcum[] = [
                    'name' => $breadcrumb,
                    'url' => $key
                ];
            }
        }
    @endphp
    <div class="container">
        <div class="w-100">
            <div class="breadcrumbs css-seb2g4">
                @include('Frontend.component.breadcrumbs',$breadcum)
            </div>
            @php
                $promotion = $product->sku_id ? $product->variant_promotion_price : $product->promotion->select(['name','id','amount'])->first(); 
                $name =  $product->sku_id ?  $product->variant_name : $product->product_name;                                
                $image = $product->sku_id ?  $product->variant_image : $product->image;
                $price = $product->sku_id ?  $product->variant_price : $product->price;
                $sku = $product->sku_id ?  $product->variant_sku : $product->product_sku;
                $price_promtion_save = isset($promotion) && !empty($promotion)  ? ((int)$price - (int)$promotion['amount']) : null;
                $album = $product->sku_id ?  $product->variant_album : $product->album;     
           @endphp
           <div class="d-flex" style="margin: 0px 0px 24px;min-width: 0px;">
                <div class="" style="margin: 0px 16px 0px 0px;min-width: 0px;width: 75.6%;">
                    <div class="h-100" style="background: white;border-radius: 8px;padding: 24px;" >
                          <div class="d-flex" style="margin: 0px;min-width: 0px;">
                            {{-- image --}}
                                <div style="margin: 0px;min-width: 0px;width: 40.5%;padding-right: 16px;">
                                    {{-- album --}}
                                    <div id="album_miltiple">
                                        @include('Frontend.page.products.product.component.album',
                                        ['album' => $album])
                                    </div>
                                    

                                    <div class="css-9eazwe">
                                        <div width="100%" color="divider" class="css-1fm9yfq"></div>
                                    </div>
                                    <div class="" style="padding: 1rem">
                                         {!! $product->content !!}
                                    </div>
                                </div>
                                <div class="find_original_name" data-name="{{ $name }}"
                                     style="margin: 0px;min-width: 0px;width: 59.5%;">
                                    {{-- title --}}
                                    <div class="title_product_dynamic">
                                        <h1 style="font-size: 24px;line-height: 1.33;margin-bottom: 8px;">
                                            {{ $name }}
                                        </h1>
                                        <div>
                                            <div class="css-1f5a6jh" style="font-size: 14px;margin-top: -4px;">
                                                Thương hiệu :
                                                <a href="" style="text-decoration: none;color: unset;cursor: pointer;">
                                                    {{ $product->brand_name  }}
                                                </a>
                                                <span style="margin:0 8px">|</span>
                                                SKU : <span class="sku_after_variant"> {{ $sku }}</span>
                                            </div>
                                            {{-- variants --}}
                                             @include('Frontend.page.products.product.component.variant')
                                            
                                            {{-- Price --}}
                                            <div class="css-2zf5gn mt-3">
                                                <div type="title" class="att-product-detail-latest-price css-roachw price_original" color="primary500">
                                                    {{ convert_price($price_promtion_save,true)  }} ₫
                                                </div>
                                                @if (isset($promotion) && !empty($promotion))
                                                    <div class="css-3mjppt d-flex">
                                                        <div type="caption" class="att-product-detail-retail-price css-18z00w6 price_discount" color="textSecondary">
                                                            {{ convert_price($price,true) }} đ 
                                                        </div>
                                                        <div type="caption" color="primary500" class="css-2rwx6s discount_type">
                                                            - {{ number_format(100 - (((int)$price_promtion_save / (int)$price) * 100),2) }} %
                                                        </div>
                                                    </div>
                                                @endif
                                               
                                            </div>
                                            <div class="css-9eazwe">
                                                <div width="100%" color="divider" class="css-1fm9yfq"></div>
                                            </div>
                                            {{-- Voucher sẽ phát triển thêm --}}
                                            <div class="" style="display: flex;gap: 0.5rem;margin-top: 1rem;">                  
                                                <div class="" style="flex: 1 1 0%;">
                                                    <button class="css-1nb4xqk ">
                                                        <div class="css-fdtrln">Mua</div>
                                                        <span style="margin-left:0px">
                                                            <div class="css-157jl91"></div>
                                                        </span>
                                                    </button>
                                                </div>
                                                @php
                                                    $bool = false;
                                                    $id_check = $product->sku_id ?  $product->sku_id : $product->id;   
                                                    $key_code = $id_check.'_'.$sku;
                                                    $attempt_check = session()->get('cart_check');;
                                                    if($attempt_check && in_array($key_code,$attempt_check)) {
                                                        $bool = true;
                                                    }
                                                @endphp
                                                <div class="" style="flex: 1 1 0%;">
                                                    <button class="css-1nhnj3v add_to_cart {{$bool ? 'opacity_active' : ''}}" {{$bool ? 'disabled' : ''}} style="margin-top: 1rem;">
                                                       {{$bool ? 'Đã thêm vào giỏ hàng'  : 'Thêm vào giỏ hàng'}}                         
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          </div>
                           
                    </div>
                </div>

                <div class="" style="margin: 0px;min-width: 0px;width: 24.4%;">
                    <div class="" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
                        <div class="css-1j6ajm9">
                            <span class="css-1v2cybn">
                                <img style="object-fit: contain"  width="40" height="40"
                                src="https://lh3.googleusercontent.com/qOnchEYD7No58bjEQs5pf_05IV-0DmoaCmEFXD007VHs5cn16LZ6PC98IlY3OiBL9UXsEwNzwiVHRrvSDMQ" alt="">
                            </span>
                            <div class="css-4eq9p2">
                                CÔNG TY CỔ PHẦN THƯƠNG MẠI DỊCH VỤ PHONG VŨ (Clone)
                            </div>
                        </div>
                        <div class="BOXCARDBODY-RIGHT css-1cpfnn9" style="margin-top:20px">
                            <div class="att-product-detail-sale-policies css-50tizz">
                                <div type="subtitle" class="css-zamej5">Chính sách bán hàng</div>
                                <div>
                                    <div>
                                        <div class="css-15eranj">
                                            <div height="24" width="24" class="css-1a6hohg">
                                                <img src="https://lh3.googleusercontent.com/uvWBg1q90XtEWvHkWGDbDemjEaANJ_kX3NEfIywURPTMeaSZTORdttpehuFBNKpYiWQ3jHgito4ciCt9pEJIHH1V4IlPYoE=rw" loading="lazy" decoding="async" style="width: 100%; height: 24px;"></div><div class="att-policy-content-0 css-9yb8e7"><p>Miễn phí giao hàng cho đơn hàng từ 5 triệu <a href="https://help.phongvu.vn/chinh-sach-ban-hang/giao-hang-va-lap-dat-tai-nha">Xem chi tiết</a></p></div></div><div class="css-15eranj"><div height="24" width="24" class="css-1a6hohg"><img src="https://lh3.googleusercontent.com/LT3jrA76x0rGqq9TmqrwY09FgyZfy0sjMxbS4PLFwUekIrCA9GlLF6EkiFuKKL711tFBT7f2JaUgKT3--To8zOW4kHxPPHs4=rw" loading="lazy" decoding="async" style="width: 100%; height: 24px;"></div><div class="att-policy-content-1 css-9yb8e7"><p>Cam kết hàng chính hãng 100%&nbsp;</p></div></div><div class="css-15eranj"><div height="24" width="24" class="css-1a6hohg"><img src="https://storage.googleapis.com/teko-gae.appspot.com/media/image/2023/4/11/fa215580-77d3-47f3-a21a-1d88381bf609/Discount.svg" loading="lazy" decoding="async" style="width: 100%; height: 24px;"></div><div class="att-policy-content-2 css-9yb8e7"><p>Trả góp 0% , không phí phát sinh cho sản phẩm Apple <a href="https://phongvu.vn/cong-nghe/tra-gop-san-pham-apple/">Xem chi tiết</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div direction="row" class="css-1ata8it"></div>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
              

           </div>

            {{-- desc --}}
           <div class="desc">
                <div class="teko-row css-29qdu">
                    <div class="teko-col teko-col-8 css-a5pz1h">
                        <div class="bg-white" style="border-radius: 0.5rem;">
                            <div class="css-ftpi71">
                                <div type="title" color="textTitle" class="title css-1dlj6qw">Mô tả sản phẩm</div>
                            </div>
                            {{-- render --}}
                            <div class="" style="padding: 1rem;">
                                <div class="w-100">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>


           {{-- Product liên quan --}}
           @include('Frontend.page.products.product.component.related',['product_related' => $productRelated ])
          
           
        </div>
    </div>
    <input type="hidden" name="product_id" value="{{$product->id }}"> 
    <input type="hidden" name="row_ID">
    <input type="hidden" name="product_variant_id" value="{{ $product->sku_id }}">
    <input type="hidden" name="sku_code" value="{{ $sku }}">
    <input type="hidden" name="image" value="{{ $image }}">
    <input type="hidden" name="sku_idx" value="{{$product->sku_idx}}"> 
    <input type="hidden" name="price" value="{{ $price }}"> 
    <input type="hidden" name="price_after_discount" value="{{ $price_promtion_save ?? 0 }}">
    <input type="hidden" name="brand" value="{{ $product->brand_name}}">
    <input type="hidden" name="product_category_id" value="{{ $product->product_category_id}}"> 
    <input type="hidden" name="promotion_name" value="{{ $promotion ? $promotion['name'] : null}}">
    <input type="hidden" name="promotion_amount" value="{{ $promotion ? $promotion['amount'] : null}}">
    <input type="hidden" name="brand" value="{{ $product->brand_name}}">
    @push('scripts')
        
        <script>
            var slider = document.querySelector('.glide_content');
            if(slider){
                var glide =  new Glide(slider,{
                type: 'carousel',
                startAt: 0,
                perView: 4,
            })
            glide.mount();
            }
            
        
        </script>
    @endpush
@endsection