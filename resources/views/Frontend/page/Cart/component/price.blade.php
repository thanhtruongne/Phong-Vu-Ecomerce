<div class="teko-col teko-col-2 css-1g0wtwt">
    <div class="teko-col css-17ajfcv">
        <div class="teko-row justify-content-end align-items-center css-1qrgscw">
            <span class="css-rmdhxt ">{{ 
                convert_price(!is_null($cart->options->price_after_discount) ? $cart->options->price_after_discount : $cart->price,true) }}đ
            </span>
        </div>
        @if (!is_null($cart->options->price_after_discount))
            <div class="teko-row justify-content-end align-items-center css-1qrgscw">
                <span class="me-1 css-1lg3tx0" style="font-size: 12px">-{{ convert_price($cart->price - $cart->options->price_after_discount,true) }} đ</span>
                <span class="css-18z00w6 ">{{ convert_price($cart->price,true) }}đ</span>
            </div>
        @endif
       
    </div>
</div>