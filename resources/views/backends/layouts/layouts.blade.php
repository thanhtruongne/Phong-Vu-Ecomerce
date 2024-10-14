<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title','Dashboard')</title>
    @include('backends.layouts.components.link')
    @yield('links')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div id="wrapper">
        {{-- Loader --}}
        @include('backends.layouts.components.loader')

        {{-- Navbar --}}
        @include('backends.layouts.topmenu')

        {{-- Sidebar --}}
        @include('backends.layouts.aside')

        {{-- Content --}}
        <div class="content-wrapper">
            <!-- breadcrumb -->
            <div class="content-header">
              <div class="container-fluid">
                  {{-- @include('layouts.components.breadcrumb') --}}
                  @yield('breadcrumbs')
              </div><!-- /.container-fluid -->
            </div>
            <!-- /.breadcrumb -->
        
            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                @yield('content') 
                {{-- theo row --}}
              </div>
            </section>
            <!-- /.content -->
        </div>

        {{-- footer --}}
        @include('backends.layouts.footer')

         
    </div>
    
    @include('backends.layouts.components.scirpts')
    <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var scrollTrigger = 60,
          backToTop = function() {

          };
 
        $('.bootstrap-table').removeClass('table-bordered');
        $(window).on('scroll', function() {
            backToTop();
        });    

        $('.editor').each(function() {
            let editor = $(this);
            let id = editor.data('target');
            CKEDITOR.replace(id);
        })

        $('body').on('click','.ckfinder_3',function() {
        let element = $(this);
        let render = $(this).parents('.check_hidden_image_album').next('.ul_upload_view_album');
        CKFinder.popup({
        chooseFiles: true,
        onInit : function(finder) {
            finder.on( 'files:choose', function( evt ) {   

                    var files = evt.data.files;
                    var html = '';
                    files.forEach( function( file, i ) {
                        html += `
                        <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                            <img height="120" src="${file.getUrl()}" width="150" alt="">
                            <input type="hidden" name="album[]" value="${file.getUrl()}"/>
                            <button type="button" class="trash_album" >
                                <i class="fa-solid fa-trash"></i>
                            </button >
                        </li> 
                        `
                    });
                    
                    element.parents('.check_hidden_image_album').addClass('hidden');
                    render.html(html);              
               
            } );
            finder.on( 'file:choose:resizedImage', function( evt ) {
                // document.getElementById( 'url' ).value = evt.data.resizedUrl;
            } );
        }
      });
    })

    $('body').on('click','.ckfinder_12',function() {
        let input = $(this).find('input');   
        let img = $(this).find('img');   
        CKFinder.popup({
        chooseFiles: true,
        onInit : function(finder) {
            finder.on( 'files:choose', function( evt ) {   
                if(type == 'image') {
                    var file = evt.data.files.first();
                    input.val(file.getUrl());
                    console.log( input.val(file.getUrl()),image)
                    if(image != null) {
                        image.attr("src",file.getUrl())
                    }
                }
                else {
                    var files = evt.data.files;
                    var html = '';
                    files.forEach( function( file, i ) {
                        html += `
                        <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                            <img height="120" src="${file.getUrl()}" width="150" alt="">
                            <input type="hidden" name="album[]" value="${file.getUrl()}"/>
                            <button type="button" class="trash_album" >
                                <i class="fa-solid fa-trash"></i>
                            </button >
                        </li> 
                        `
                    });
                    
                    input.parents('.check_hidden_image_album').addClass('hidden');
                    image.html(html);            
                }
               
            } );
            finder.on( 'file:choose:resizedImage', function( evt ) {
                // document.getElementById( 'url' ).value = evt.data.resizedUrl;
            } );
        }
      });
    })

    function setUpCkFinder(input = null,image = null,type = null){
     
    }


      })
     </script>
    @yield('scripts')
</body>
</html>