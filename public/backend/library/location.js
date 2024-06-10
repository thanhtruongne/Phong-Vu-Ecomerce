(function($) {
    "use strict";
    var Data = {};
    


    Data.province = () => {
        $(document).on('change','.location',function() {
            let option = {
                'data' : {
                    'location_id' : $(this).val()
                },
                'target' : $(this).attr('data-target')
            }
            Data.SubmitSendData(option);
        })
    }

    Data.SubmitSendData = (option) => {
        $.ajax({ 
            type : 'GET', 
            url: "/private/system/ajax/get-location",
            data: option, 
            success : function(data) 
            { 
                $('.' + option.target).html(data.data);
       
                if(district_id != '' && option.target == 'districts') {          
                    $('.districts').val(district_id).trigger("change");
                }
                if(ward_id != '' && option.target == 'wards') {
                    $('.wards').val(ward_id).trigger("change");
                }
            }, 
             error : function(error) { 
                console.log(error); 
            }
         })
    }

    Data.loadProvince = () => {
        if(province_id != '') {
            $('.provinces').val(province_id).trigger("change");
        } 
    }

    


   $(document).ready(function() {
      Data.province();
      Data.loadProvince();
   })







})(jQuery);