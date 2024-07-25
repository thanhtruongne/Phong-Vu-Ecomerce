@extends('Frontend.layout.layout')
@section('title')
   Laptop
@endsection



@section('content')
    <div class="container">
        <div class="w-100">
            <div class="breadcrumbs css-seb2g4">
                {{ Breadcrumbs::view('partial.frontend.breadcrumbs','laptopCategory') }}  
            </div>
            <div class="css-rf24tk">
                <div class="teko-row css-ezmamy" style="margin-left: -8px;margin-right: -8px;row-gap: 16px;">
                    {{-- sidebar --}}
                    @include('Frontend.page.products.components.sidebar',['filter' => $filter])

                    <div class="teko-col teko-col-10 css-17ajfcv" style="padding: 0 8px"> 
                        <div class="css-1of9xbq">
                            <div class="teko-row justify-content-start css-iv0lz5">
                                <h1 class="css-7nrxrf">{!!  $productCateloge->content !!}</h1>
                                <div class="css-18xfrv">({{ count($productCateloge->products) }} sản phẩm)</div>
                            </div>

                            {{-- brand --}}
                            @include('Frontend.page.products.components.brand',['descentanof' => $descentanofCateloge])

                            {{-- nhu cầu --}}
                            {{-- <div class="" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;margin-top: 0.75rem;margin-bottom: 0.25rem">
                                <h2 class="css-1xw9vei">Chọn theo nhu cầu</h2>
                                <div class="css-9hrw0v" style="overflow: hidden"> 
                                    <a href="" class="css-1h3fn00">
                                        <div class="css-1kkr1rl">
                                        
                                            <div class="" style="position: relative;display: inline-block;overflow: hidden;height: 90px;width: 90px;">
                                                <img class="w-100 object-fit-contain" height="90"  src="https://lh3.googleusercontent.com/qB66Bo3zMseXCcuk_VTXoLuj4J7a-hBm5G0sa5cgHWnsPb3SnZdNxadBlQhHum8fl9fFHh82BDbh6yt254908rZr30Metr1t=rw" alt="">
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="css-1fvto6t">Laptop AI</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div> --}}
                        </div>

                        <div class="css-qc5ueq w-100">
                            {{-- sort --}}
                             @include('Frontend.page.products.components.sort')
                             {{-- products --}}
                             @include('Frontend.page.products.components.products',['products' => $products])
                        </div>
                    </div>

                    {{-- desc sluig --}}
                    <div class="w-100">
                         @include('Frontend.page.products.components.descSlug',['desc' => $productCateloge->desc])
                    </div>
                </div>
            </div>
        </div>
    </div>


@push('scripts')
   <script>
//    $(document).ready(function(){
//     length = 500;
//     cHtml = $(".content_desc_product_cateloge").html();
//     cText = $(".content_desc_product_cateloge").text().substr(0, length).trim();
//     $(".content_desc_product_cateloge").addClass("compressed").html(cText);
//     $(".button_toggle").addClass('exp').text('Xem thêm nội dung');
//     window.handler = function()
//     {
//         $('.exp').click(function(){
//             if ($(".content_desc_product_cateloge").hasClass("compressed"))
//             {
//                 $(".content_desc_product_cateloge").html(cHtml);
//                 $(".button_toggle").text('Tóm tắt nội dung');
//                 $(".content_desc_product_cateloge").removeClass("compressed");
//                 handler();
//                 return false;
//             }
//             else
//             {
//                 $(".content_desc_product_cateloge").html(cText);
//                 $(".button_toggle").text('Xem thêm nội dung');
//                 $(".content_desc_product_cateloge").addClass("compressed");
//                 handler();
//                 return false;
//             }
//         });
//     }
//     handler();
// });





    var slider = document.getElementById('slider');
    var moneyFormat = wNumb({
            decimals: 3,
            thousand: ".",
            suffix: " đ"
        });
noUiSlider.create(slider, {
    start: [1000000, 5000000],  
    step : 100,
    range: {
        'min': 100000,
        'max': 10000000
    },
    format :moneyFormat,
    connect: true,
});
var snapValues = [
    document.getElementById('slider-snap-value-lower'),
    document.getElementById('slider-snap-value-upper')
];

slider.noUiSlider.on('update', function (values, handle) {
    snapValues[handle].innerHTML = values[handle];
});
snapValues.addEventListener('change', function () {
    slider.noUiSlider.set(this.value);
});



   </script>
   
@endpush

@endsection