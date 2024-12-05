<div class="teko-col teko-col-6 css-17ajfcv">
    <div class="d-flex" style="gap:12px">
        {{-- image --}}
        <a href="" style="text-decoration: none;color: unset;cursor: pointer;">
            <div class="css-6zppmi">
                <img 
                decoding="async" height="80" class="w-100" loading="lazy"
                src="{{ $cart->options->image }}" alt="{{ $cart->name }}">
            </div>
        </a>
        {{-- desc_product --}}
        <div class="" style="flex: 1 1 0%;">
            <a href=""
            style="text-decoration: none;color: unset;cursor: pointer;" >
                <div class="css-1h5tj4c">{{ $cart->name }}</div>
            </a>
            <div type="caption" color="textSecondary" class="css-1f5a6jh">SKU: {{ $cart->options->code }}</div>
            {{-- <div type="caption" color="textSecondary" class="css-1f5a6jh">{{ $cart->options->attributeName ?? '' }}</div> --}}
        </div>
    </div>
</div>