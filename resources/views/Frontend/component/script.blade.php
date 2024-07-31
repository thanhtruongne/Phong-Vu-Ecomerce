<script>
        //Global
        const Server_Frontend = 'http://localhost:8000';
</script>

<script src="{{ asset('frontend/boosttrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/plugins/jquery.js') }}"></script>

<script src="{{ asset('frontend/boosttrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="{{ asset('frontend/js/plugins/glide-slide.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('frontend/js/library/jquery.js') }}"></script>
{{-- <script src="{{ asset('backend/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script> --}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@if (!empty($config['js']))
    @foreach ($config['js'] as $item)
        <script src="{{ asset($item) }}"></script>
    @endforeach
@endif


@if (!empty($config['js_link']))
    @foreach ($config['js_link'] as $item)
        <script src="{{ $item }}"></script>
    @endforeach
@endif

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
  
   window.addEventListener('load', function() {

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

})

</script>


