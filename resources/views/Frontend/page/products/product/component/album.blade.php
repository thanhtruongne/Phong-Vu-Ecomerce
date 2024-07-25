
@php
    $album = json_decode($data->album) ?? explode(',',$data->album);
@endphp
<div class="">
    {{-- Image galley --}}
    <div class="" style="cursor: pointer;position: relative;margin-bottom: 0.5rem;">
        <div class="css-j4683g">
            <img 
            id="img_01" 
            data-zoom-image="{{ $type == 'variant' ? $album[0] : $product->image }}"
            style="width: 100%;height: 100%;object-fit: contain;" 
            src="{{$type == 'variant' ? $album[0] : $product->image }}" alt="">
        </div>
    </div>
        {{-- Image-galley-zoom --}}
    <div id="gallery_01" style="display: flex;justify-content: flex-start;gap: 0.5rem;">
        @if (isset($album) && !empty($album))
            @foreach ($album as $key => $item)
                <div class="css-4ok7dy">
                    <a href="{{ $item }}"
                    data-zoom-image="{{ $item }}"
                    data-image="{{ $item }}" height="50px" width="50px" class="css-1dje825">
                        <img 
                        {{-- xpreview="{{ $item }}" --}}
                    id="img_01"
                        src="{{ $item }}" loading="lazy" decoding="async" alt="iPhone 15 Pro Max 512GB" style="width: 100%; height: 50px; object-fit: contain;">
                    </a>
                </div>
            @endforeach
        @endif
    
    </div>
</div>