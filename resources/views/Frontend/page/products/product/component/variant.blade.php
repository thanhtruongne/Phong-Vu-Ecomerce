<div class="" style="margin-top: 1rem;margin-bottom: 1rem;">

    @if (isset($product->attribute_variant) && !is_null($product->attribute_variant))
        @php
            $check = !is_array($product->sku_idx) ? json_decode($product->sku_idx) : $product->sku_idx;
        @endphp
        @foreach ($product->attribute_variant as $key_attribute_name =>  $attributes_item)
            @php
                $attempt_data = explode('_',$key_attribute_name);
            @endphp
            <div class="css-1w2ugk5">
                <div class="css-172d5l5 d-flex">{{ $attempt_data[0] }}: <div class="css-172d5l5 title" style="margin-left:4px"></div></div>
                <div class="css-vxzt17">
                    @foreach ($attributes_item as $index => $object)
                        <a
                            class=" {{ $check[$attempt_data[1]] === $index ?  'active_border' : ''}} css-ywmmpw loading_title attribute_click"
                            href=""
                            data-load="{{ $object['name'] }}"
                            data-index = {{ $index }}
                            data-name="{{ \Str::slug($object['name']) }}" 
                            data-id="{{ $object['id'] }}">
                            {{ $object['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>