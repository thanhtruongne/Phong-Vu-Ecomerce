
<div class="css-k9y40f">
        <div style="background:#fff;border-radius:8px">
            {{-- Title --}}
            <div class="css-ftpi71">
                <div class="css-1dlj6qw">Danh mục nổi bật</div> 
            </div>
        <div class="d-flex justify-content-around align-items-center" style="padding: 8px 16px 24px;">
            @if (isset($data) && !empty($data))
                @foreach ($data as $key => $item)
                    <div class="text-center">
                        <a href="#" style="text-decoration: none;color: unset;cursor: pointer;">
                            <div class="css-1senw2f">
                                <img 
                                    class="w-100 object-fit-cover"
                                    src="{{ $item->icon }}"
                                    style="height: 56px;" alt="">
                            </div>
                            <div class="css-pbict">
                                {{ $item->name }}
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif       
        </div>   
</div>