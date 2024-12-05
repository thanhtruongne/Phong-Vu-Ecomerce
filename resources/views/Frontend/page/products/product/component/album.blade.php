
@php
    $album = $album  ? (!is_array(json_decode($album)) ? explode(',',json_decode($album)) : json_decode($album)) : null
@endphp
<div class="">
    {{-- Image galley --}}
    <div class="position-relative" style="cursor: pointer;margin-bottom: 0.5rem;">
        <div class="css-j4683g">
            <img 
            id="zoom_01" 
            class="w-100 h-100"
            data-zoom-image="{{  $album[0] }}"
            style="object-fit: contain;" 
            src="{{ $album[0] }}" alt="">
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
                        class="w-100"
                        src="{{ $item }}" loading="lazy" decoding="async"  style="height: 50px; object-fit: contain;">
                    </a>
                </div>
            @endforeach
        @endif
    
    </div>
</div>