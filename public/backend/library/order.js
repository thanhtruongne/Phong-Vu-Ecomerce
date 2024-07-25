(function($) {
    "use strict";
    var Data = {};
   Data.OnChangeInfoUser = () => {
        $(document).on('click','.chanage_edit_the_user',function() {
             let _this = $(this);
             let toogle = _this.siblings('.toogle_check_close');
             console.log(toogle)
             if($(toogle).hasClass('none_toggle')) {
                _this.addClass('none_toggle');
                $(toogle).removeClass('none_toggle')
             }
             let foundTheRender = $('.render_info_user');
             let option = {
                'data' : {
                    'location_id' : $('input[name="province_code"]').val(),
                    'district_id' : $('input[name="district_code"]').val(),
                    'ward_id' : $('input[name="ward_code"]').val(),
                },
                'target' : $(this).attr('data-target')
            }
           
             let data = {
                'name' : $('input[name="name"]').val(),
                'email' : $('input[name="email"]').val(),
                'phone' : $('input[name="phone"]').val(),
                'address' : $('input[name="address"]').val(),
                'province_code' : $('input[name="province_code"]').val(),
                'district_code' : $('input[name="district_code"]').val(),
                'ward_code' : $('input[name="ward_code"]').val(),
                'desc' : $('input[name="desc"]').val(),
            };
            let html =  `
            <div class="" style="margin-bottom:14px">
                <strong>Tên: </strong>
                <input type="text" class="form-control" name="name" value="${data?.name ?? ''}"/>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Email: </strong>
                <input type="text" class="form-control" name="email" value="${data?.email ?? ''}"/>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Điện thoại: </strong>
               <input type="text" class="form-control" name="phone" value="${data?.phone ?? ''}"/>
            </div>
             <div class="" style="margin-bottom:14px">
                <strong>Ghi chú: </strong>
                 <textarea class="form-control" style="height:100px" name="desc" id="" cols="30" rows="10"> ${data?.desc ?? ''}</textarea>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Địa chỉ: </strong>
               <input type="text" class="form-control" name="address" value="${data?.address ?? ''}"/>
            </div>
            `
            $('.address_code_dynamic').attr('style','display:block');
            // Data.SubmitSendData(option);\
            $('.provinces').val($('input[name="province_code"]').val()).trigger("change");
            foundTheRender.html(html);
        })
   }
   Data.province = () => {
    $(document).on('change','.location',function() {
        let option = {
            'data' : {
                'location_id' : $(this).val(),
                // 'district_id' : $('input[name="district_code"]').val(),
                // 'ward_id' : $('input[name="ward_code"]').val(),
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
            console.log(option)
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

    Data.toogleCheck = () => {
       $(document).on('click','.toogle_check_close',function() {
            let _this = $(this);
            let toogle = _this.prev('.chanage_edit_the_user');
            if($(toogle).hasClass('none_toggle')) {
                _this.addClass('none_toggle');
                $(toogle).removeClass('none_toggle')
            }
            let data = {
                'name' : $('input[name="name"]').val(),
                'email' : $('input[name="email"]').val(),
                'phone' : $('input[name="phone"]').val(),
                'address' : $('input[name="address"]').val(),
                'province_code' : $('input[name="province_code"]').val(),
                'district_code' : $('input[name="district_code"]').val(),
                'ward_code' : $('input[name="ward_code"]').val(),
                'desc' : $('input[name="desc"]').val(),
            };
            console.log(data);
            let html =  `
             <div class="" style="margin-bottom:14px">
                <strong>Tên: </strong>
                <span>${data?.name}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Email: </strong>
               <span>${data?.email}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Điện thoại: </strong>
               <span>${data?.phone}</span>
            </div>
            <div class="" style="margin-bottom:14px">
                <strong>Ghi chú: </strong>
                <textarea readonly class="form-control" name="desc" style="height:100px" id="" cols="20" rows="10">${data?.desc ?? ''}</textarea>
            </div>`
            let foundTheRender = $('.render_info_user');
            $('.address_code_dynamic').attr('style','display:none');
            $(foundTheRender).html(html);
       })
    }

    Data.ChangeTheShippingOrder = () => {
        $(document).on('change','.change_shipping',function(){
            let _this = $(this);
            $.ajax({
                type: 'GET',
                url : '/private/system/ajax/order/change',
                data : {
                    val : _this.val(),
                    name : _this.attr('name'),
                    code : _this.attr('data-code')
                },
                success : function(data) {
                   if(data?.code == 0) {
                        toastr.success( data?.message,'Thông báo');
                   }
                   else toastr.error(data?.message,'Thông báo');
                },
                error : function(error) {
                    console.log(error);
                }
            })
        })
    }
    Data.ChangeTheConfirmOrder = () => {
        $(document).on('change','.change_confirm',function(){
            let _this = $(this);
            $.ajax({
                type: 'GET',
                url : '/private/system/ajax/order/change',
                data : {
                    val : _this.val(),
                    name : _this.attr('name'),
                    code : _this.attr('data-code')
                },
                success : function(data) {
                   if(data?.code == 0) {
                        toastr.success( data?.message,'Thông báo');
                   }
                   else toastr.error(data?.message,'Thông báo');
                },
                error : function(error) {
                    console.log(error);
                }
            })
        })
    }


    Data.SendEmail = () => {
        $(document).on('click','.submit_send_mail_invoice',function(){
           
             let code = $(this).attr('data-code');
             let email = $(this).attr('data-email');
             let href = $(this).attr('data-href');
             let count =  +$('.send_mail_count').text();
             $.ajax({
                type: 'POST',
                url : href,
                data : {
                    'code' : code,'email' : email
                },
                beforeSend : function(){
                   $('.loading').addClass('loader');
                },
                success: function(data){
                    console.log(data)
                  if(data.code == 0){
                    $('.loading').removeClass('loader');
                    console.log(123)
                    $('.submit_send_mail_invoice')
                    .removeClass('btn-danger').addClass('btn-primary')
                    .attr('style','color:#ccc').html('Send mail invoice success')
                   
                    console.log(count)
                    $('.send_mail_count').text(count + 1);
                  }
                },
                error : function(error) {
                   console.log(error)
                }
             })
        })
    }

   $(document).ready(function() {
    Data.OnChangeInfoUser();
    Data.province();
    Data.toogleCheck();
    Data.ChangeTheShippingOrder();
    Data.ChangeTheConfirmOrder();
    Data.SendEmail()
   })

})(jQuery);