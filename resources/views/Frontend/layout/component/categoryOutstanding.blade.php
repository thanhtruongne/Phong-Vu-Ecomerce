
<div class="css-k9y40f">
        <div style="background:#fff;border-radius:8px">
            {{-- Title --}}
            <div class="css-ftpi71">
                <div class="css-1dlj6qw">Danh mục nổi bật</div>
        </div>
        <div class="glide_category" style="padding: 8px 16px 24px;">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @if (isset($data) && !empty($data))
                        @foreach ($data->object as $key => $item)
                            @php
                                $canonical = $item->canonical;
                                $name = $item->name;
                            @endphp
                            <li class="glide__slide" >
                                <div class="text-center">
                                    <a href="{{ $canonical }}" style="text-decoration: none;color: unset;cursor: pointer;">
                                        <div class="css-1senw2f">
                                            <img 
                                                src="{{ $item->image }}"
                                                style="width: 100%;height: 56px;object-fit: cover;" alt="">
                                        </div>
                                        <div class="css-pbict">
                                            {{ $name }}
                                        </div>
                                    </a>
                                </div>
                            </li>   
                        @endforeach
                    @endif
                    
                    
                </ul>
            </div>
        </div>   
</div>