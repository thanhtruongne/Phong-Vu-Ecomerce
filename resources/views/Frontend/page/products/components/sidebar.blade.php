<div class="teko-row teko-col-2 css-17ajfcv" style="padding: 0 8px">
    <div class="bg-white d-flex flex-column" style="border-radius: 0.5rem;padding: 0.75rem;">
        <div class="css-y7yt88">Khoảng giá</div>
        <div class="css-17ajfcv">
             <div class="css-1n5trgy">
                 <input  type="text" class="css-11mfy90 set_price" data-name="{{ config('apps.sort.name_sort_symbol.price_gte') }}" id="slider-snap-value-lower"  />
                 <input  type="text" class="css-11mfy90 set_price" data-name="{{ config('apps.sort.name_sort_symbol.price_lte') }}" id="slider-snap-value-upper" />
             </div>
             <div class="w-100 mt-3">
                 <div id="slider" class="noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"></div>
             </div>
        </div>
        <div class="css-1veiyrs">
            <div class="w-100 d-flex" style="border: 1px solid #E4E5F0"></div>
        </div>
        <input type="hidden" name="cateloge_id" value="{{ json_encode($breadcrumb) ?? null }}">
        <ul id="metismenu" style="list-style: none;margin:0;padding:0">
            @if (isset($brands) && !empty($brands) && count($brands) > 0)     
                <li class="mb-2">
                    <a class="has-arrow css-q3day0" href="#" aria-expanded="false">Thương hiệu</a>
                    <ul class="mm-collapse" style="list-style: none;margin:0;padding:0">        
                        @foreach ($brands as $brand)
                            <li class="css-1p9luqs w-100">
                                <input
                                  data-attribute="{{ config('apps.sort.name_sort_symbol.thuonghieu') }}"
                                  style="width: 16px; height: 16px;"
                                  class="form-check-input change_checkbox_item" 
                                  type="checkbox" 
                                  value="{{ $brand->id }}" 
                                  id="{{ Str::slug($brand->name) }}" />
                                <label class="css-6r3s23 ms-1" style="position: relative;top:2px" for="{{ Str::slug($brand->name) }}">{{ $brand->name }}</label>
                            </li>
                        @endforeach 
                    </ul>
                </li>
            @endif

            @if (isset($filter) && !empty($filter))
                @foreach ($filter as $key =>  $item)
                  
                    <li class="mb-2">
                        <a class="has-arrow css-q3day0" href="#" aria-expanded="false">{{ $item->name }}</a>
                        <ul class="mm-collapse" style="list-style: none;margin:0;padding:0">
                            @foreach ($item->attributes as $attribute)
                                <li class="css-1p9luqs w-100">
                                    <input 
                                       data-attribute="{{ convert_string_slug_trim($item->name) }}"
                                       data-name=""
                                       style="width: 16px; height: 16px;"
                                       class="form-check-input change_checkbox_item" 
                                       type="checkbox" 
                                       value="{{ $attribute->id }}"
                                       id="{{ Str::slug($attribute->name) }}" />
                                    <label class="css-6r3s23 ms-1" style="position: relative;top:2px" for="{{ Str::slug($attribute->name) }}">{{ $attribute->name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
                
            @endif
       
         </ul>
    </div>
 </div>
 
 