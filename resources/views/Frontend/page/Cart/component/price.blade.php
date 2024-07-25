<div class="teko-col teko-col-2 css-1g0wtwt">
    <div class="teko-col css-17ajfcv">
        <div class="teko-row justify-content-end align-items-center css-1qrgscw">
            <span class="css-rmdhxt ">{{ 
            convert_price($cart->options->priceSale == 0 || is_null($cart->options->priceSale)  
            ? $cart->price_previous : $cart->options->priceSale,true) 
            }}đ</span>
        </div>
        @if ($cart->options->priceSale != 0 && !is_null($cart->options->priceSale))
            <div class="teko-row justify-content-end align-items-center css-1qrgscw">
                <span class="me-1 css-1lg3tx0" style="font-size: 12px">-{{ $cart->options->discountValue }}{{ $cart->options->discountType }}</span>
                <span class="css-18z00w6 ">{{ convert_price($cart->price,true) }}đ</span>
            </div>
        @endif
       
    </div>
</div>