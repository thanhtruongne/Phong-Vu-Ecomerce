
 

    $('.load-product-categories-by-code').select2({
        allowClear: true,
        dropdownAutoWidth : true,
        width: '100%',
        placeholder: function(params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: base_url + '/load-ajax/loadProductCategiresByCode',
            dataType: 'json',
            data: function (params) {

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    code: $(this).data('code'),
                };

                return query;
            }
        }

    })

    $('.load-attribute').select2({
        allowClear: true,
        dropdownAutoWidth : true,
        width: '100%',
        placeholder: function(params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: base_url + '/load-ajax/loadAttribute',
            dataType: 'json',
            data: function (params) {

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    parent_id: $(this).data('parent'),
                };

                return query;
            }
        }

    })

    function load_attribute_by_type(){
        $('.load-attributes-type').select2({
            // allowClear: true,
            dropdownAutoWidth : true,
            width: '100%',
            placeholder: function(params) {
                return {
                    id: null,
                    text: params.placeholder,
                }
            },
            ajax: {
                method: 'GET',
                url: base_url + '/load-ajax/loadAttributeByType',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: $.trim(params.term),
                        page: params.page,
                        type: $(this).data('parent'),
                    };
    
                    return query;
                }
            }
        })
        // .on("select2:select",function(e){
        //     $.each(this.options, function (i, item) {
        //        let val = $(item).val();
        //        if(value.includes(val)){
        //             console.log(item,value,val);
        //             $(item).prop("disabled", true); 
        //        }
        //     });
        //     $(this).trigger('change.select2');
        // })
    }

    function load_select2(){
        $('.select2').select2({
            allowClear: true,
            dropdownAutoWidth : true,
            width: '100%',
            placeholder: function(params) {
                return {
                    id: null,
                    text: params.placeholder,
                }
            },
        })
        // .on("select2:change", function (e) {
        //     var selected_element = $(e.currentTarget);
        //     var select_val = selected_element.val();
        //     console.log(selected_element,select_val)
        //     $.each(this.options, function (i, item) {
        //         console.log($(item).val())   
        //         if($(item).val() == ""){
        //             console.log(item);
        //         }
        //         // if (item.checked) {
        //         //     $(item).prop("disabled", true); 
        //         // }
        //     });
        // });
    }
    load_select2();
