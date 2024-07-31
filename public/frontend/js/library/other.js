(function($) {
    "use strict";
    var Data = {};
    Data.SubmitSendData = (option) => {
        $.ajax({ 
            type : 'GET', 
            url: "/ajax/dashboard/location",
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
    Data.province = () => {
        $(document).on('change','.location',function() {
            console.log(123);
            let option = {
                'data' : {
                    'location_id' : $(this).val()
                },
                'target' : $(this).attr('data-target')
            }
            Data.SubmitSendData(option);
            Data.chooseShippingGHTK();
        })
    }
    Data.loadProvince = () => {
        if(typeof province_id != null && province_id != '') {
            $('.provinces').val(province_id).trigger("change");
        } 
    }

    Data.chooseShippingGHTK = () => {
        if($('.provinces').val() && $('.districts').val() && $('input[name="address"]').val()) {
           $.ajax({
              type: 'GET',
              url : `${Server_Frontend}/ajax/ghtk/transportfee`,
              data : {
                province : $(".provinces option:selected" ).text(),
                districts :$(".districts option:selected" ).text() ,
                ward :$(".wards option:selected" ).text() ?? '',
                address : $('input[name="address"]').val(),
                value : Number($('.total_render').text().replace("đ", "").replace(/\./g, '')),
              },
              beforeSend: function() {
                // setting a timeout
                let loading = `
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`
                $('.shipping_price').html(loading);
            },
              success : function(data) {
                
                  if(data.success && data.fee?.delivery != false) {
                    $('.shipping_price').html(' ');
                     $('body .shipping_price').html(Data.number_format(data?.fee?.fee) + 'đ');
                     let div = $('<div>');
                     if(data?.fee?.insurance_fee) {
                        let html = `
                        <div>
                         -- <strong> Bảo hiểm đơn hàng: </strong><span class="text-danger fw-bold">${Data.number_format(data?.fee?.insurance_fee)} đ</span>
                        </div>`
                        div.append(html);
                     }
                     
                    if(data?.fee?.extFees.length){
                        $.each(data?.fee?.extFees,function(index,val){
                            console.log(val.title,index)
                            let html = `
                            <div>
                              -- <strong>${val.title}: </strong><span class="text-danger fw-bold">${val.display}</span>
                            </div>          `
                            div.append(html);
                        })
                    } if(data?.fee?.ship_fee_only) {
                        let html = `
                        <div>
                           -- <strong> Phí vận chuyển: </strong><span class="text-danger fw-bold">${Data.number_format(data?.fee?.ship_fee_only) } đ</span>
                        </div>`
                        div.append(html);
                     }
                     $('.render_shipping_option').html(div);
                     Data.TriggerClickDataShippingRule();
                     Data.setInputShippingOption(data);
                  }
                  else if(data?.fee?.delivery == false && data.success == true) {
                    let span = $('<span>').addClass('text-danger').text('Địa chỉ không hợp lệ !!!');
                    $('.shipping_price').html(span);
                  }
              },
              error : function(error) {
                $.toast({
                    text:error?.message,
                    icon: 'error',
                    bgColor: '#fff',
                    position: 'top-right',
                    showHideTransition: 'plain',
                  
                })
              }
              
           })
        }
    }
    Data.TriggerClickDataShippingRule = () => {
        let found_checked = $('.shipping_price').text();
        if(found_checked) {
          let html = `
          <div type="subtitle" class="css-1lg3tx0">Tổng phí vận chuyển</div>
              <div class="teko-col css-17ajfcv" style="text-align: right;">
                  <div type="subtitle" color="" style="font-size: 14px;font-weight:bold" class="shipping_attr css-nbdyuc"> ${found_checked}</div>
              </div>
          </div>`
           $('.render_here_method').html(html);
           Data.RenderPriceToTal();
        }
       
        
      }

      
Data.RenderPriceToTal = () => {
    let price_orginal = Number($('#price_yet_cart').text().trim().slice(0,-1).replaceAll('.', ''));
    if($('.shipping_attr').length) {
        price_orginal += Number($('.shipping_attr').text().replace('đ','').replaceAll('.', ''));
    }
    $('.css-1lg3tx0').find('.total_render').html(Data.number_format(price_orginal) + 'đ');
    let input_hidden = $('<input>').attr('type','hidden').attr('name','total').val(price_orginal);
    $('.css-1lg3tx0').find('.total_render').append(input_hidden)     
}
Data.number_format = (number, decimals = 0, dec_point = '.', thousands_sep = '.') => {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
} 
Data.setInputShippingOption = (data) => {
    let html = $('<div>');
    let sum = 0 ;
   if(data?.fee?.insurance_fee) {
      let input1 = $('<input>').attr('type','hidden').attr('name','shipping_options[insurance_fee]').val(data?.fee?.insurance_fee);
      sum += data?.fee?.insurance_fee
      html.append(input1)
   }
   if(data?.fee?.extFees) {
    $.each(data?.fee?.extFees,function(index,val){
        let input2 = $('<input>').attr('type','hidden').attr('name','shipping_options[extFees]').val(val?.amount);
         sum += val?.amount
        html.append(input2)
        
    })
    
    }
    if(data?.fee?.ship_fee_only) {
        let input3 = $('<input>').attr('type','hidden').attr('name','shipping_options[ship_fee_only]').val(data?.fee?.ship_fee_only);
         sum += data?.fee?.ship_fee_only;
        html.append(input3)
    }
    let total = $('<input>').attr('type','hidden').attr('name','shipping_options[total]').val(sum);html.append(total)
    $('.input_hidden_price').html(html);
 }
 Data.TypingAddressCheck = () => {
    let clear = null;
    $('input[name="address"]').on('input',function(){
        if(clear) clearTimeout(clear);

        clear = setTimeout(() => {        
            return Data.chooseShippingGHTK();   
        }, 1500);
        
    })
}

   $(document).ready(function() {
       Data.TypingAddressCheck();
        Data.province();
        Data.loadProvince();
     
   })

})(jQuery);