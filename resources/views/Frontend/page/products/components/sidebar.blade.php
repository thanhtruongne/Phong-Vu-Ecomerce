<div class="teko-row teko-col-2 css-17ajfcv" style="padding: 0 8px">
    <div class="bg-white d-flex flex-column" style="border-radius: 0.5rem;padding: 0.75rem;">
        <div class="css-y7yt88">Khoảng giá</div>
        <div class="css-17ajfcv">
             <div class="css-1n5trgy">
                 <span class="css-11mfy90" id="slider-snap-value-lower" >0đ</span>
                 <span class="css-11mfy90" id="slider-snap-value-upper">10.000.000đ</span>
             </div>
             <div class="w-100 mt-3">
                 <div id="slider" class="noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"></div>
             </div>
        </div>
        <div class="css-1veiyrs">
            <div class="w-100 d-flex" style="border: 1px solid #E4E5F0"></div>
        </div>
        <ul id="metismenu" style="list-style: none;margin:0;padding:0">
            <input type="hidden" name="productCategory" value="{{$productCategory->id}}">
            @if (isset($filters) && !empty($filters))
                @foreach ($filters as $key =>  $filter)           
                    <li class="mb-2">
                        <a class="has-arrow css-q3day0 fw-bold data_parent" data-id="{{$filter['slug']}}" href="#" aria-expanded="false">{{ $filter['name'] }}</a>
                        <ul class="mm-collapse ul_parent" style="list-style: none;margin:0;padding:0">
                            @foreach ($filter['item'] as $attribute)
                                <li class="css-1p9luqs w-100">
                                    <input style="width: 16px; height: 16px;" data-slug="{{$attribute['slug']}}" class="form-check-input on_change_ajax" type="checkbox" value="{{ $attribute['id'] }}" id="{{ $attribute['slug'] }}_{{$attribute['id']}}" />
                                    <label class="css-6r3s23 ms-1 position-relative" style="top:2px" for="{{ $attribute['slug'] }}_{{$attribute['id']}}">{{ $attribute['name'] }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
                
            @endif
       
         </ul>
    </div>
 </div>
 
 