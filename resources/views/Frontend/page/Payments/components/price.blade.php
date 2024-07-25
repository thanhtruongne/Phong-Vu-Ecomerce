<div class="css-194iuus"> <div class="teko-row justify-content-between align-items-center css-33wqqr shipping_rule">
    <div type="subtitle" class="css-1lg3tx0">Tổng tiền ( tạm tính )</div>
        <div class="teko-col css-17ajfcv" style="text-align: right;">
            <div type="subtitle" color="" id="price_yet_cart" style="font-size: 14px;font-weight:bold" class="shipping_render css-nbdyuc">{{ convert_price($total,true) }}₫</div>
        </div>
    </div>
    <div class="render_here_method d-flex justify-content-between align-items-center mb-3">
        
    </div>
    <div type="subtitle" class="css-1lg3tx0 justify-content-between">Tổng tiền thanh toán
        <span type="subtitle" style="line-height: 1" class="css-aafp0n total_render">
            
        </span>
    </div>
</div>
@if ($errors->has('total'))
<div class="css-fwmmrl mt-2 mb-2" style="font-size: 15px">
    {{  $errors->first('total') }}
</div>
@endif
<div class="footer_cart">
    <div class="">
        <button style="text-decoration: none" type="submit" class="css-v463h2">
            Thanh toán
        </button>
    </div>
</div>