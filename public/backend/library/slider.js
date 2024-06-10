(function($) {
    "use strict";
    var Data = {};
    Data.OnClickCreateThumbnail = () => {
      $(document).on('click','.btn_generate_slider',function() {
         let row = $('.wrapper_slider_thumbnail');
         console.log(Data.createRowSliderThumbnail());
         row.append(Data.createRowSliderThumbnail());
         Data.checkRowLengthSlider();
      })
   }
   
   Data.createRowSliderThumbnail = (image = null) => {
          let random = Math.ceil( Math.random() * 100);
          let row = $('<div>').addClass('thumbnail_item').attr('style','height:286px;margin:12px 0;padding:16px 0;border-bottom: 1px solid #ddd');
          let thumbnail = $('<div>').addClass('col-lg-3');
          let img = $('<img>')
          .attr('src', image ?? 'https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg')
          .attr('style','object-fit:cover')
          .addClass('ck_finder_5')
          .attr('width','150').attr('height','190');
          let inputHidden = $('<input>')
          .attr('type','hidden')
          .attr('name','slide[thumbnail][]')
          .addClass('hidden_image')
          .val(image ?? '');
          let inputHiddenRandomClass = $('<input>')
          .attr('type','hidden')
          .attr('name','slide[random_class][]')
          .val(random ?? '');
          
          thumbnail.append(img);
          thumbnail.append(inputHidden);
          thumbnail.append(inputHiddenRandomClass);
          let DataInput = $('<div>').addClass('col-lg-9').attr('style','padding-right:0;padding-left:0;');
          let optionLi = [ 
               {'class' : 'active' ,'toggle' : 'tab' , 'href' :'#tab-1-'+ random  ,'expanded' : false , 'title' :'Thông ti chung' },
               {'class' : '' ,'toggle' : 'tab' , 'href' : '#tab-2-' + random ,'expanded' : true , 'title' :'Thông ti SEO'},
            ]
          let ul = $('<ul>').addClass('nav nav-tabs');
          $.each(optionLi , function(index , val) {
            let a = $('<a>')
            .attr('href',val?.href)
            .attr('data-toggle',val?.toggle)
            .attr('aria-expanded',val?.expanded)
            .text(val?.title);
            let li = $('<li>').addClass(val?.class).append(a);
            ul.append(li);
          })

          let div = $('<div>').attr('style','border: 1px solid #ddd;border-top:none');
          let tabContent = $('<div>').addClass('tab-content');
          let optionTab = [
            { 'id' :'tab-1-'+random , 'class' : 'tab-pane', 'type' : 'INFO' },
            { 'id' : 'tab-2-'+random , 'class' : 'tab-pane', 'type' : 'SEO' }
          ]
          $.each(optionTab,function(index , item) {
            let html = Data.createTabPanelBody(item);
            tabContent.append(html);
          })
          div.append(tabContent);
          DataInput.append(ul);
          DataInput.append(div);
          row.append(thumbnail);
          row.append(DataInput);
          let span = $('<span>')
          .attr('style','position: relative; top: -236px; left: 661px;font-size: 22px;cursor: pointer')
          .addClass('delete_thumbnail_detail')
          .append('<i class="fa-solid fa-trash"></i>');
          row.append(span);
          return row;
   }
   
   Data.SetupCkfinderImageThumbnail = () => {
      $(document).on('click','.ck_finder_5',function() {
         let element = $(this).siblings('.hidden_image');
         let render = $(this).parents('.thumbnail_item').parents('.wrapper_slider_thumbnail');
         Data.CKFINDER(element,render,'multiple');
      })
   }

   Data.CKFINDER = (input , image = null,type = 'image') =>  {
      CKFinder.popup({
         chooseFiles: true,
         onInit : function(finder) {
             finder.on( 'files:choose', function( evt ) {   
                 if(type == 'image') {
                     var file = evt.data.files.first();
                     console.log(file.getUrl())
                     input.val(file.getUrl());
                     if(image != null) {
                         input.prev().attr('src',file.getUrl());
                     }
                 }
                 else {
                     var files = evt.data.files
                     image.empty();
                     let row = $('.wrapper_slider_thumbnail');
                    files.forEach( function( file, i ) {   
                        row.append( Data.createRowSliderThumbnail(file.getUrl()));
                    })
                

                 }
                
             } );
             finder.on( 'file:choose:resizedImage', function( evt ) {
                 // document.getElementById( 'url' ).value = evt.data.resizedUrl;
             } );
         }
       });
   }
   

   Data.createTabPanelBody = (data = null) => {
      let html = ''
      if(data?.type == 'INFO') {
         html = `
         <div id="${data?.id}" class="${data?.class} active">
            <div class="panel-body">
               <div class="form-group" style="padding: 0 15px">
                  <h4 for="">Mô tả</h4>
                  <textarea name="slide[desc][]" id="" cols="30" class="form-control" style="height: 72px;width:100%" rows="10"></textarea>
               </div>
               <div class="form-group" >
                  <div class="col-lg-8">
                        <input type="text"  placeholder="URL" name="slide[canonical][]" class="form-control">
                  </div>
                  <div class="col-lg-4" style="height: 34px">
                     <span>Mở ra tab mới</span>
                     <input type="checkbox" name="slide[window][]">
                  </div>
               </div>
               
            </div>
         </div> `;
      }
      else if(data?.type == 'SEO') {
         html = `
         <div id="${data?.id}" class="${data?.class}">
               <div class="panel-body">
                  <div class="form-group" style="padding: 0 15px">
                     <h4 for="">Tiêu đề ảnh</h4>
                     <input name="slide[name][]"  class="form-control"/>
                  </div>
                  <div class="form-group" style="padding: 0 15px">
                     <h4 for="">Mô tả ảnh</h4>
                     <input name="slide[alt][]"  class="form-control"/>
                  </div>
               </div>
         </div>
         `
      }
         return html;
   }

   Data.RemoveThumbnailElement = () => {
      $(document).on('click','.delete_thumbnail_detail',function() {
         let _this = $(this);
         _this.parents('.thumbnail_item').remove();
         Data.checkRowLengthSlider();
      })
   }

   Data.checkRowLengthSlider = () => {
     if( $('.thumbnail_item').length  > 0) $('.wrapper_slider_thumbnail').find('.message_empty_slider').hide(); 
     else $('.wrapper_slider_thumbnail').find('.message_empty_slider').show(); 
   }

   $(document).ready(function() {
      Data.OnClickCreateThumbnail()
      Data.SetupCkfinderImageThumbnail();
      Data.RemoveThumbnailElement();
      Data.checkRowLengthSlider();
   })

})(jQuery);