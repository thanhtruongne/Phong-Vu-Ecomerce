(function($) {
    "use strict";
    var Data = {};
    Data.ChangePaymentMethod = () => {
        $(document).on('click','.change_method_payment',function(e) {
            e.preventDefault();
            let _this = $(this);
            let div_check = $('<div>').addClass('css-18wywdr');
            let input_hidden = $('<input/>').attr('type','hidden').attr('name','method').val(_this.attr('data-id'));
            let span_check = $('<span>').addClass('css-mpv07g')
            .html('<svg fill="none" viewBox="0 0 24 24" size="20" class="css-1kpmq" color="#fff" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M5 12.4545L9.375 17L19 7" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>')
            $.each($('.parent_method').find('.change_method_payment'), function(index,val) {
                if($(val).find('.check_item_method').hasClass('css-1014eaz')) {
                    $(val).find('.check_item_method').removeClass('css-1014eaz').addClass('css-64rk53')
                    $(val).find('.css-18wywdr').remove();$(val).find('.css-mpv07g').remove();
                    $(val).find('input').remove();
                    
                }
            })
            _this.find('.check_item_method').addClass('css-1014eaz').removeClass('css-64rk53');
            _this.append(div_check);_this.append(span_check);
            _this.find('input[type="hidden"]').remove();
            _this.append(input_hidden);
        })
    }



   

    $(document).ready(function() {
        Data.ChangePaymentMethod()
        
    })

})(jQuery);