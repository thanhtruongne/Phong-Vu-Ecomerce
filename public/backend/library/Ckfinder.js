(function($) {
    "use strict";
    var Data = {};
   
    Data.UploadImageInput = () => {
       $('body').on('click','.ckfinder_2',function() {
            let input = $(this).find('input'); 
            console.log(input);
            Data.setupCkfinder(input,null,'image');
       })
    }

    Data.UploadImageByProduct = () => {
        $('body').on('click','.ckfinder_12',function() {
            let input = $(this).find('input');   
            let img = $(this).find('img');   
            Data.setupCkfinder(input,img);
       })
    }



    Data.UploadImageInputSystem = () => {
        $('.ckfinder_5').click(function() {
         let target = $(this).data('type');
         let input = $(this).find('input');  
         let findImage = $(this).find('img');   
         Data.setupCkfinder(input,findImage);
        })
     }
    
    // Datra
    
    Data.UploadAlbumImage = () => {
        $('body').on('click','.ckfinder_3',function() {
            let element = $(this);
            let render = $(this).parents('.check_hidden_image_album').next('.ul_upload_view_album');
            Data.setupCkfinder(element,render,'multiple');
        })
    }

    Data.DeleteImageOwner = () =>  {
        $('body').on('click','.trash_album',function(e) {       
            $(this).parents('.item_album').remove();
            if($('.ul_upload_view_album li.item_album').length == 0) $('.ul_upload_view_album').prev().removeClass('hidden');
            e.preventDefault();
        })
    }

   Data.setupCkfinder = (input = null,image = null,type = 'image') => {
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
   }

   Data.SetupCKeditor  = () => {
        $('.ckEdition').each(function() {
            let editor = $(this);
            let id = editor.data('target');
            Data.Editor4(id);
        })
   }

   Data.Editor4 = (id) => {
    CKEDITOR.replace(id);
   }

   Data.OnchangeTitlePost = () => {
    $('body').on('keyup','.onchange_title_seo_input',function(e) {
        let title_seo = $('.SEO').find('.title_seo');
       
        title_seo.html($(this).val());

        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Báo Thanh Niên: Tin tức 24h mới nhất, tin nhanh, tin nóng ...')
        }
    })

    $('body').on('keyup','.title_seo_link_meta',function(e) {
        let title_seo = $('.SEO').find('.title_seo');
       
        title_seo.html($(this).val());

        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Báo Thanh Niên: Tin tức 24h mới nhất, tin nhanh, tin nóng ...')
        }
    })
    $('body').on('keyup','.desc_seo_title',function(e) {
        let title_seo = $('.SEO').find('.desc_seo');
       
        title_seo.html($(this).val());

        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Tin tức 24h, đọc báo TN cập nhật tin nóng online Việt Nam và thế giới mới nhất trong ngày, tin nhanh thời sự, chính trị, xã hội hôm nay, tin tức, top news ...')
        }
    })

    $('body').on('keyup','.link_seo_href_title',function(e) {
        let title_seo = $('.SEO').find('.link_seo');
        title_seo.html(URL_ORINGINAL + $(this).val() + SUFFIX );
      
        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Bạn chưa có đường dẫn SEO....')
        }
    })
    //phần translate bản dịch
    $('body').on('keyup','.translate_meta_title',function(e) {
        let title_seo = $('.SEO').find('.translate_title_seo');
       
        title_seo.html($(this).val());

        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Báo Thanh Niên: Tin tức 24h mới nhất, tin nhanh, tin nóng ...')
        }
    })
    $('body').on('keyup','.translate_meta_desc',function(e) {
        let title_seo = $('.SEO').find('.translate_desc_seo');
       
        title_seo.html($(this).val());

        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Tin tức 24h, đọc báo TN cập nhật tin nóng online Việt Nam và thế giới mới nhất trong ngày, tin nhanh thời sự, chính trị, xã hội hôm nay, tin tức, top news ...')
        }
    })

    $('body').on('keyup','.translate_meta_link',function(e) {
        let title_seo = $('.SEO').find('.translate_link_seo');
        title_seo.html(URL_ORINGINAL + $(this).val() + SUFFIX );
      
        if($(this).val().length  == 0) {
            title_seo.html('Ví dụ : Bạn chưa có đường dẫn SEO....')
        }
    })
   }



   $(document).ready(function() {
        Data.UploadImageInput();
        Data.SetupCKeditor();
        Data.OnchangeTitlePost();
        Data.UploadImageByProduct()
        Data.UploadAlbumImage();
        Data.DeleteImageOwner();
        Data.UploadImageInputSystem();
   })

})(jQuery);