<script>
        //Global
        const Server_Frontend = '{{env('APP_URL_DEFAULT')}}';
</script>

{{-- <script src="{{ asset('frontend/boosttrap/js/bootstrap.min.js') }}"></script> --}}
<script src="{{ asset('frontend/js/plugins/jquery.js') }}"></script>
<script src="{{ asset('frontend/boosttrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('frontend/js/plugins/popper.min.js')}}" ></script>
<script src="{{ asset('frontend/js/plugins/glide-slide.js') }}"></script>
<script src="{{asset('frontend/js/plugins/jquery-elevatezoom.min.js')}}"></script>
<script src="{{asset('frontend/js/plugins/nouislider.min.js')}}"></script>
<script src="{{asset('frontend/js/plugins/metisMenu.min.js')}}"></script>
<script src="{{asset('frontend/js/plugins/wNumb.min.js')}}"></script>
<script src="{{asset('backend2/plugins/select2/js/select2.min.js')}}"></script>
{{-- load custom jquery --}}
<script src="{{asset('backend2/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('frontend/js/custom/jquery.js')}}"></script>
<script src="{{asset('frontend/js/custom/custom.js')}}"></script>
<script src="{{asset('frontend/js/custom/cart.js')}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


<script>
    $(document).ready(function(){
        if($('#metismenu').length){
            $("#metismenu").metisMenu({
            toggle: false
        });
        }

    })
</script>


<script>
    var glide =  new Glide('.glide',{
        type: 'carousel',
        startAt: 0,
        perView: 1,
        autoplay: 2000
    })
    glide.mount();

    var glide_widget =  new Glide('.glide_widget',{
        type: 'carousel',
        startAt: 0,
        perView: 5,
    })
    glide_widget.mount();



    var glide_category =  new Glide('.glide_category',{
        type: 'carousel',
        startAt: 0,
        perView: 10,
    })
    glide_category.mount();
//    window.addEventListener('load', function() {

    $("#img_01").elevateZoom({

        constrainType: "height",

        constrainSize: 274,

        zoomType: "lens",

        containLensZoom: true,

        gallery: 'gallery_01',

        cursor: 'pointer',

        galleryActiveClass: "active"

    });

    $("#img_01").bind("click", function(e) {

        var ez = $('#img_01').data('elevateZoom');

        $.fancybox(ez.getGalleryList());

        return false;

    });

    // })

</script>


