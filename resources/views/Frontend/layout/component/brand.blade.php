@if (isset($brands) && !empty($brands))
    <div class="" style="margin-left: -6px;margin-right: -8px;">
        <div class="brand w-100 d-flex" style="flex-wrap:wrap" style="margin:0 -8px">
            @foreach ($brands as $key => $brand)
                <div class="teko-col teko-col-3 css-17ajfcv" style="padding: 0 8px;width:24%;margin-top:30px">
                    <a href="#">
                        <div class="css-egxwy8">
                            <img class="w-100" style="height: auto"
                                src="{{ $brand->image }}" alt="">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif    