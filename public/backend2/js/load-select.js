$(document).ready(function(){
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
    });

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
            headers : {
                'Access-Control-Allow-Origin': '*'
            },
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
})