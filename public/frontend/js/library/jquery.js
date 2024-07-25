(function($) {
    "use strict";
    var Data = {};
   
   Data.OnFocusDataChangeCategory = () => {
      $(document).on('click','.on_click_change_toggle',function() {
        let _this = $(this);

        if($('.css-16sn586').hasClass('hidden')) {
            // console.log(123);
            $('.css-16sn586').removeClass('hidden');
            $('.css-1peoe6k').removeClass('hidden');
            Data.OnHoverMenuSideBar()
        }
        else {
            $('.css-16sn586').addClass('hidden');  
            $('.css-1peoe6k').addClass('hidden')
        }    
      })    

   }

   Data.setUpSlideGlide = () => {
    var glide =  new Glide('.glide',{
        type: 'carousel',
        startAt: 0,
        perView: 1,
        autoplay: 2000
    })
    glide.mount();
   }

   Data.setUpWidgetSlider = () => {
    var glide =  new Glide('.glide_widget',{
        type: 'carousel',
        startAt: 0,
        perView: 5,
    })
    glide.mount();
   }


   Data.setUpCategoryOutStandingSlider = () => {
    var glide =  new Glide('.glide_category',{
        type: 'carousel',
        startAt: 0,
        perView: 10,
    })
    glide.mount();
   }
   

   Data.OnHoverMenuSideBar = () => {
       console.log(1213123213);
    if($('.set_ui_menu')) {
         $.each($('.set_ui_menu') , function(index,val) {
             let classList = $(val).attr('data-title');
             console.log(classList);
             $(val).hover(function (e) {
                console.log(44)
                 $('.css-j61855').removeClass('hidden');
                 $('.css-j61855').find('.'+classList).removeClass('hidden')
                 $('.css-j61855').find('.'+classList).find('div.css-fej9ea').removeClass('hidden')
                 let divCenter = $('.css-j61855').find('div.css-fej9ea');

                 console.log(divCenter);

                 e.stopPropagation();
             }, function () {
                if(!$('.css-j61855').find('.'+classList).find('div.css-fej9ea').hasClass('hidden')) {             
                    // $('.css-j61855').addClass('hidden');
                    // $('.css-j61855').find('.'+classList).addClass('hidden') 
                }
                
             });
             // $(val).mouseover(function(e) {
             //     e.stopPropagation();
             //     e.preventDefault();
             //     $('.css-j61855').removeClass('hidden');
             //     $('.css-j61855').find('.'+classList).removeClass('hidden')
              
             // })
             // $(val).mouseout(function(e) {
                 
             //     $('.css-j61855').addClass('hidden');
             //     $('.css-j61855').find('.'+classList).addClass('hidden') 
             // })
         })
    }
 }

   Data.SortWrappDivMenu = () => {
    if($('.set_ui_menu').length) {
        $.each($('.set_ui_menu') , function(index,val) {
            let item = $(val).attr('data-title');
            let found = $('.css-j61855').find('div.'+item);
            //find the a href to hidden
            if($('.css-j61855').find('a.set_ui_menu').length && $('.css-j61855').find('a.set_ui_menu').attr('data-title') === item ) {
                $('.css-j61855').find('a.set_ui_menu').remove();
            }
            let diving  = found.children();
            $(diving).addClass('d-flex justify-content-evenly').attr('style','margin-top:30px');
           
            let children = found.children().children();

            $.each(children,function(key,item){
               if($(item).hasClass('css-1h3fn00')) {
                  $(item).next('div').addBack().wrapAll('<div>').addClass('');
               }
            })
            let setColor = $(diving).children();
            $.each(setColor,function(set_ui_menu , container) {
                $(container).children(":first").find('div').addClass('css-18f5to7')
            })
          
        })
    }
}

   $(document).ready(function() {
      Data.OnFocusDataChangeCategory();
      Data.setUpCategoryOutStandingSlider();
      Data.setUpSlideGlide();
      Data.setUpWidgetSlider();
      Data.OnHoverMenuSideBar();
      Data.SortWrappDivMenu();
     
   })

})(jQuery);