<div class="" style="margin-top: 1rem;margin-bottom: 1rem;">
    @if (isset($attribute) && !is_null($attribute))
        @foreach ($attribute as $key_attribute =>  $attribute_item)
            <div class="css-1w2ugk5">
                <div class="css-172d5l5 d-flex">{{ $attribute_item->name }}: <div class="css-172d5l5 title" style="margin-left:4px"></div></div>
                @if (isset($attribute_item->object) &&  !is_null($attribute_item->object))
                <div class="css-vxzt17">
                    @foreach ($attribute_item->object as $object)
                    {{-- active_border --}}
                        <a
                         class="css-ywmmpw loading_title {{ !is_null($slug) && in_array(Str::slug($object->name),$slug) ?  'active_border' : ''}} attribute_click"
                            href=""
                            data-load="{{ $object->name }}"
                            data-name="{{ Str::slug($object->name) }}" data-id="{{ $object->id }}">
                            {{ $object->name }}
                        </a>
                    @endforeach
                </div>
                    
                @endif 
            </div>
        @endforeach
    @endif
</div>