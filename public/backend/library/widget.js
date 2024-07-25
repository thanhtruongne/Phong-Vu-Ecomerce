(function($) {
    "use strict";
    var Data = {};
    Data.OnChangeTheSearchBar = () => {
        $(document).on('keyup','.search_model_keyword',function() {
            let _this = $(this);
            if($('input[name="model"]:checked').length == 0) {
                _this.val(' ');
                alert('Vui lòng chọn model target');
                return false;
            }
            let debounce;
            let option = {
                'model' : $('input[name="model"]:checked').val(),
                'keyword' : _this.val(),
                'table' : $('input[name="model"]:checked').val()
            }
            if(option?.keyword != '' && option?.keyword.length >= 2) {
                if(debounce)  clearTimeout(debounce);
                debounce = setTimeout(() => {
                    Data.AjaxUsingGetMenuAttribute(option);
   
               },400)
            }
           
        })
    }


    Data.AjaxUsingGetMenuAttribute = (option) => {
        console.log(option);
        $.ajax({
            type: 'GET',
            url: '/private/system/ajax/dashboard/widget/model',
            data : option,
            success : function(data){
                if(data?.length > 0) {
                    $('.search_model_result').removeClass('hidden');
                    $('.search_model_result').html('');
                    $.each(data,function(index , val) {
                        $('.search_model_result').append(Data.createRowSearchingModel(val));
                    })
                }
                else {
                    $('.search_model_result').addClass('hidden');
                }
            },
            error : function(error) {
                 console.log(error)
            },
        })
    }
    Data.createRowSearchingModel = (data = null) => {
        let html = 
        `
        <div  
        class="item_search_icon"
        id="check-${data?.id}-${data?.canonical}"
        style="padding: 12px 16px;font-size:13px;display:flex;justify-content:space-between" 
        data-canonical="${data?.canonical}"
        data-image="${data?.image}"
        data-name="${data?.name}"
        data-id="${data?.id}">
            <div>        
                ${data?.name}
            </div>  
            <div class="auto_icon_check">
             
            </div>
        </div>
        `;
        return html;
    }

    Data.ClickSearchingDataModel = () => {
        $('body').on('click','.item_search_icon',function() {
            let _this = $(this);
            let option = {
                'name' : _this.attr('data-name'),
                'image' : _this.attr('data-image'),
                'id' : _this.attr('data-id'),
                'canonical' : _this.attr('data-canonical'),
            }   
            if($('.model_table_search_result').find('#check-'+option?.id+'-'+option?.canonical).length == 1) {
               alert('Attribute đã tồn tại');
               return false;
            }
            $('.model_table_search_result').append(Data.CreateTheDataAfterSearching(option));   
            _this.find('.auto_icon_check').html('<i class="fa-solid fa-check"></i>');
        })
    }

    Data.CreateTheDataAfterSearching = (option) => {
        let html =
        `
        <div 
        class="item_result" 
        id="check-${option?.id}-${option?.canonical}"
        data-id="${option?.id}"
        data-canonical="${option?.canonical}"
        data-name="${option?.name}"
        data-image="${option?.image}"
        style="margin:12px 0;display: flex;justify-content:space-between;align-items:center">
            <div style="display: flex;align-items:center">
                <div style="margin-right: 12px" class="thumbnail_image">
                    <img width="50" height="50" src="${option?.image}" alt="">
                    <input type="hidden" name="model_id[id][]" value="${option?.id}"/>
                    <input type="hidden" name="model_id[image][]" value="${option?.image}"/>
                    <input type="hidden" name="model_id[name][]" value="${option?.name}"/>
                    <input type="hidden" name="model_id[canonical][]" value="${option?.id}"/>
                </div>
                <div>
                    <h4>${option?.name}</h4>
                </div>
            </div>
            <div class="iconic_render">
                <i class="fa-solid fa-xmark"></i>
            </div>

        </div>
        `;return html;
    }
    
    Data.RemoveAttributeChoose = () => {
        $('body').on('click','.iconic_render',function() {
            let _this = $(this);
            let id = _this.parents('.item_result').attr('data-id');
            let canonical = _this.parents('.item_result').attr('data-canonical');
            _this.parents('.item_result')
            .parents('.model_table_search_result')
            .prev().find('#check-'+id+'-'+canonical).find('.auto_icon_check').html('');
            _this.parents('.item_result').remove();
        })
    }



    Data.ConvertTheStringSnake = (string) => {
        return string.replace(/\W+/g, " ")
                    .split(/ |\B(?=[A-Z])/)
                    .map(word => word.toLowerCase())
                    .join('_');
    }
    Data.RadioChooseItem = () => {
        $('body').on('change','.radio_change_model',function() {
            let _this = $(this);
            let debounce;
            let option = {
                'model' : _this.val(),
                'table' : $('input[name="model"]:checked').val()
            }
            if(debounce)  clearTimeout(debounce);
            debounce = setTimeout(() => {
                Data.AjaxUsingGetMenuAttribute(option);

           },400)
        })
    }


   $(document).ready(function() {
        Data.OnChangeTheSearchBar();
        Data.RadioChooseItem();
        Data.ClickSearchingDataModel();
        Data.RemoveAttributeChoose();
   })

})(jQuery);