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
            $('.editor').each(function() {
                let editor = $(this);
                let id = editor.data('target');
                CKEDITOR.replace(id);
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

                }
            });
            $('.sortable').sortable();

                var scrollTrigger = 60,
                backToTop = function() {
                };
        
                $('.bootstrap-table').removeClass('table-bordered');
                $(window).on('scroll', function() {
                    backToTop();
                });    

                // $('.editor').each(function() {
                //     let editor = $(this);
                //     let id = editor.data('target');
                //     CKEDITOR.replace(id);
                // })

                $('body').on('click','.ckfinder_3',function() {
                    let element = $(this);
                    let render = $(this).parents('.check_hidden_image_album').next('.ul_upload_view_album');
                    let data_name = element.data('parent');
                    CKFinder.modal({
                    chooseFiles: true,
                    // width: 800,
                    // height: 1000,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ){
                            var files = evt.data.files;
                            var html = '';
                            files.forEach( function( file, i ) {
                                html += `
                                <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                                    <img height="120" src="${file.getUrl()}" width="150" alt="">
                                    <input type="hidden" name="${data_name ? data_name : 'album'}[]" value="${file.getUrl()}"/>
                                    <button type="button" class="trash_album btn bg-red" >
                                        <i class="fas fa-trash text-white" ></i>
                                    </button >
                                </li> 
                                `
                            });
                            
                    
                            if(element.parents('.check_hidden_image_album').hasClass('hidden')){
                                element.parents('.check_hidden_image_album').removeClass('hidden')
                            }
                            else element.parents('.check_hidden_image_album').addClass('hidden');
                            render.html(html);               
                        });

                        finder.on( 'file:choose:resizedImage', function( evt ) {
                            var output = document.getElementById( elementId );
                            output.value = evt.data.resizedUrl;
                        } );
                    }
                });
                    // CKFinder.popup({
                    // chooseFiles: true,
                    // onInit : function(finder) {
                    //     finder.on( 'files:choose', function( evt ) {   

                    //             var files = evt.data.files;
                    //             var html = '';
                    //             files.forEach( function( file, i ) {
                    //                 html += `
                    //                 <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                    //                     <img height="120" src="${file.getUrl()}" width="150" alt="">
                    //                     <input type="hidden" name="album[]" value="${file.getUrl()}"/>
                    //                     <button type="button" class="trash_album btn bg-red" >
                    //                         <i class="fas fa-trash text-white" ></i>
                    //                     </button >
                    //                 </li> 
                    //                 `
                    //             });
                                
                    //             element.parents('.check_hidden_image_album').addClass('hidden');
                    //             render.html(html);              
                        
                    //     } );
                    //     finder.on( 'file:choose:resizedImage', function( evt ) {
                    //         // document.getElementById( 'url' ).value = evt.data.resizedUrl;
                    //     } );
                    // }
                    // });
                })

            $('body').on('click','.ckfinder_12',function() {
                let input = $(this).find('input');   
                let img = $(this).find('img');   
                let render = $(this).parents('.check_hidden_image_album').next('.ul_upload_view_album');
                selectFileWithCKFinder(input ,img,render);
            })

            //variant
            $('body').on('click','.ckfinder',function(){
                let element = $(this);
                let id = element.data('id');
                let render = $(this).parents('.check_hidden_image_album').next('.ul_upload_view_album');
                CKFinder.modal({
                    chooseFiles: true,
                    // width: 800,
                    // height: 1000,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ){
                            var file = evt.data.files.first();
                            var html = '';
                            files.forEach( function(file,i) {
                                html += `
                                <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                                    <img height="120" src="${file.getUrl()}" width="150" alt="">
                                    <input type="hidden" name="variant_album[${id}][]" value="${file.getUrl()}"/>
                                    <button type="button" class="trash_album btn bg-red" >
                                        <i class="fas fa-trash text-white" ></i>
                                    </button >
                                </li> 
                                `
                            });
                            element.parents('.check_hidden_image_album').addClass('hidden');
                            render.html(html);          
                        });

                        finder.on( 'file:choose:resizedImage', function( evt ) {
                            var output = document.getElementById( elementId );
                            output.value = evt.data.resizedUrl;
                        } );
                    }
                });
            })

  

            function selectFileWithCKFinder( input , img = null ,render = null, type = 'single' ) {
                CKFinder.modal({
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ) {
                            var file = evt.data.files.first();
                            input.val(file.getUrl());
                            img.removeAttr('width').addClass('w-100 object-fit-cover')
                            img.attr('src',file.getUrl());
                            
                            
                            // output.value = 
                        } );

                        finder.on( 'file:choose:resizedImage', function( evt ) {
                            var output = document.getElementById( elementId );
                            output.value = evt.data.resizedUrl;
                        } );
                    }
                });
            }




        })
        function debounce(func, delay) {
            let timer;
            return function(...args) {
                const context = this;
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(context, args), delay);
            };
        }
    </script>

    

    @yield('scripts')
</body>
</html>