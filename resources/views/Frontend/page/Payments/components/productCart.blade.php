@if (isset($carts) && !empty($carts)) 
    @foreach ($carts as $key => $cart)
        <div class="css-9op68y w-100" style="margin-bottom:1rem;" data-rowId="{{ $cart->rowId }}">
            <div class="d-flex">
                <div class="css-17nqxzh" style="width: 80px;height:80px">
                    <img 
                    style="object-fit:contain"
                    src="{{ $cart->options->image }}" class="w-100 h-100" alt="">
                </div>
                <div class=""  style="flex: 1 1 0%; margin-left: 1rem;">
                    <a href="#" style="text-decoration: none">
                        <div type="body" color="textPrimary" class="css-1h5tj4c">
                            {{ $cart->name }}
                        </div>
                    </a>
                    <div type="caption" color="textSecondary" class="css-1f5a6jh">Số lượng:  {{ $cart->qty }}</div>
                   
                    <span class="css-7ofbab">{{   
                    convert_price($cart->options->price_after_discount ? $cart->options->price_after_discount : $cart->price,true)     
                    }}đ</span>
                    @if ( !is_null($cart->options->price_after_discount))
                    <div class="teko-row justify-content-start align-items-center css-1qrgscw">
                        <span class="css-18z00w6 ">{{ convert_price($cart->price,true) }}đ</span> -
                        <span class="css-7ofbab">- {{ number_format(100 - (((int)$cart->options->price_after_discount / (int)$cart->price) * 100),2) }} %</span>
                    </div>
                @endif
                </div>
            </div>
        </div>
    @endforeach
@endif