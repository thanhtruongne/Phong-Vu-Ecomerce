
    if($('.attribute_click').length > 0) {
        $('.attribute_click').on('click',function(e) {
            e.preventDefault();
            let attributeID = [];
            let attributeParams = [];
            let attributeIndex  = [];
            let _this = $(this);
            //each
                $.each(_this.parents('.css-vxzt17').find('a'),function(index,val) {
                if($(val).hasClass('active_border')) {
                    $(val).removeClass('active_border');
                }
                })
            _this.addClass('active_border');
            _this.parents('.css-vxzt17').siblings('.css-172d5l5').find('div.title').html(_this.text().trim())
            //add id
            $.each($('.attribute_click'),function(key,item) {
                if($(item).hasClass('active_border')) {
                    attributeID.push($(item).attr('data-id'));
                    attributeParams.push($(item).attr('data-name'));
                    attributeIndex.push($(item).attr('data-index'));
                }
            })
            handleLoadVariantProduct(attributeID,attributeParams,attributeIndex);


        })
    }



   function handleLoadVariantProduct(attributeID,attributeParams = null,attributeIndex = null) {
      $.ajax({
        type: "GET",
        url :  Server_Frontend + 'ajax/load-variant',
        data : {
            'attributeIndex' : attributeIndex,
            'product_Id' : $('input[name="product_id"]').val(),
            'sku_id' : $('input[name="product_variant_id"]').val(),
            'sku_code' : $('input[name="sku_code"]').val(),
        },
        success : function(res) {
            if(res.data != undefined) {
                let data = res?.data;
                // let canonical = $('.find_original_name .title_product_dynamic').attr('data-canonical');
                $('#album_miltiple').html(SetUpAlbumProductVariant(data?.album));
                // set album
                setUpGlideSliderProductVariant();
                //set name
                $('.find_original_name .title_product_dynamic').find('h1').html(data?.name)
                $('.css-1f5a6jh').find('span.sku_after_variant').html(data?.sku);
                // set variant
                setUpInputVariant(res?.data) ;
                // let promotions = res.data?.promotions.length ?  res.data?.promotions[0] : null;
                SetUpPromotionsProductVariant(data?.promotion,data?.price);
                LoadURLparamsWhenChoose(data?.slug,data?.sku);
                return true;
            }
            // else {
            // }

        },
        error : function(error) {
            return false;
        }
      })
   }



   function setUpGlideSliderProductVariant() {

                $("#img_01").elevateZoom({

                    constrainType: "height",

                    constrainSize: 274,

                    zoomType: "lens",

                    containLensZoom: true,

                    gallery: 'gallery_01',

                    cursor: 'pointer',

                    galleryActiveClass: "active"

                });

                $("#img_01").bind("click", function(e) {

                    var ez = $('#img_01').data('elevateZoom');

                    $.fancybox(ez.getGalleryList());

                    return false;

                });

   }


   function SetUpPromotionsProductVariant(promotions,price)  {
    let product_price_after_discount =  promotions != null ?  (price - promotions[0].amount)  : price;
    $('.css-2zf5gn .price_original').html(number_format(product_price_after_discount) + 'đ');
    if(promotions != null) {
        $('.css-2zf5gn .price_discount').html(number_format(price) + 'đ')
        $('.css-2zf5gn .discount_type').html('-' + number_format(100 - ((product_price_after_discount / price) * 100),2) + '%');
    }

   }
    function setUpInputVariant(data) {
        let image = data?.album[0]
        let price_after_sale = data?.promotion[0] ?  data?.price - data?.promotion[0]?.amount : null;
        $('input[name="product_variant_id"]').val(data?.id);
        $('input[name="product_id"]').val(data?.product_id);
        $('input[name="sku_code"]').val(data?.sku);
        $('input[name="price"]').val(data?.price);
        $('input[name="image"]').val(image);
        $('input[name="price_after_discount"]').val(price_after_sale);
    }

   function SetUpAlbumProductVariant(galley) {

    let thumbnail = '';
    $.each(galley,function(index,val) {
        thumbnail += `
            <div class="css-4ok7dy">
                <a href="${val}"
                data-zoom-image="${val}"
                data-image="${val}" height="50px" width="50px" class="css-1dje825">
                    <img

                id="img_01"
                    src="${val}" loading="lazy" decoding="async" alt="iPhone 15 Pro Max 512GB" style="width: 100%; height: 50px; object-fit: contain;">
                </a>
            </div>
        `
    })
    let imageShow = `
        <div class="" style="cursor: pointer;position: relative;margin-bottom: 0.5rem;">
            <div class="css-j4683g">
                <img
                id="img_01"
                data-zoom-image="${galley[0]}"
                style="width: 100%;height: 100%;object-fit: contain;"
                src="${galley[0]}" alt="">
            </div>
        </div>`
    let album = `
        <div id="gallery_01" style="display: flex;justify-content: flex-start;gap: 0.5rem;">
             ${thumbnail}
        </div>`;

    let results = `
         <div>
            ${imageShow}
            ${album}
         </div> `
    return results;


   }

   function number_format(number, decimals = 0, dec_point = '.', thousands_sep = '.'){
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

   function loadDingDataTitleDynamic() {
    if($('a.loading_title').length) {
        $('a.loading_title').each(function(index,val) {
            let data_title = $(val).attr('data-load');
            $(val).parents('.css-vxzt17').siblings('.css-172d5l5').find('div.title').html(data_title);
        })
    }
   }

   function LoadURLparamsWhenChoose(slug,sku_id) {
    //  $.each(params,function(index,val) {
    //     if(!val.match(/\d/)) {
    //         params.push(params.splice(params.indexOf(val), 1)[0]);
    //     }
    //     let change = params.join('--');

    //  })
     let content_url = slug + '--' + sku_id ;
     let objectData = { sku : sku_id};
     history.pushState(objectData,'',content_url);
   }

    $(document).on('click','.add_to_cart',function(e) {
        e.preventDefault();
        let data = {
            'id'  :  $('input[name="product_id"]').val(),
            'sku_id'  :  $('input[name="product_variant_id"]').val(),
            'sku_code' : $('input[name="sku_code"]').val(),
            'name' : $('.find_original_name .title_product_dynamic').find('h1').text().trim(),
            'sku_idx' :   $('input[name="sku_idx"]').val(),
            'image' :   $('input[name="image"]').val(),
            'qualnity' :  1,
            'price' :  Number($('input[name="price"]').val()),
            'price_after_discount' : Number($('input[name="price_after_discount"]').val()),
            'product_category_id' : $('input[name="product_category_id"]').val(),
            'promotion_name' : $('input[name="promotion_name"]').val(),
            'promotion_amount' : Number($('input[name="promotion_amount"]').val()),
            'brand' : $('input[name="brand"]').val(),
        }
        if(data) AjaxAddToCart(data);

    })

   function AjaxAddToCart(data) {
      $.ajax({
         type: 'POST',
         url :  `${Server_Frontend}ajax/addToCart`,
         data : data,
         success: function(data) {
            if(data?.status == 'success'){
                show_message(data?.message,data?.status);
                let count_cart = $('span#count_cart');
                let sum = count_cart.text();
                count_cart.html(+sum + data?.count);
                return false;
            } else {
                show_message(data?.message,data?.status);
                return false;
            }
         },
         error: function(error) {
            show_message('Có lỗi xảy ra','error');
            return false;
         },

      })
   }


    $(document).on('change','.location',function() {
        let option = {
            'data' : {
                'location_id' : $(this).val()
            },
            'target' : $(this).attr('data-target')
        }
        if(option?.target != 'provinces') {
            SubmitSendData(option);
        }
        chooseShippingGHTK();
    })


        let clear = null;
        $('input[name="receiver_address"]').on('input',function(){
            if(clear) clearTimeout(clear);

            clear = setTimeout(() => {
                return chooseShippingGHTK();
            }, 1500);

        })

    function chooseShippingGHTK() {
    if($('.provinces').val() && $('.districts').val() && $('input[name="receiver_address"]').val()) {
       $.ajax({
          type: 'GET',
          url : Server_Frontend  + 'ajax/ghtk/transportfee',
          data : {
            province : $(".provinces option:selected" ).text(),
            districts :$(".districts option:selected" ).text() ,
            ward :$(".wards option:selected" ).text() ?? '',
            address : $('input[name="receiver_address"]').val(),
            value : Number($('.total_render').text().replace("đ", "").replace(/\./g, '')),
          },
          beforeSend: function() {
            // setting a timeout
            $('.shipping_price').html('<i class="fa fa-spinner fa-spin"></i>');
        },
          success : function(data) {

              if(data.success && data.fee?.delivery != false) {
                $('.shipping_price').html(' ');
                 $('body .shipping_price').html(number_format(data?.fee?.fee) + 'đ');
                 let div = $('<div>');
                 if(data?.fee?.insurance_fee) {
                    let html = `
                    <div>
                     -- <strong> Bảo hiểm đơn hàng: </strong><span class="text-danger fw-bold">${number_format(data?.fee?.insurance_fee)} đ</span>
                    </div>`
                    div.append(html);
                 }

                if(data?.fee?.extFees.length){
                    $.each(data?.fee?.extFees,function(index,val){
                        let html = `
                        <div>
                          -- <strong>${val.title}: </strong><span class="text-danger fw-bold">${val.display}</span>
                        </div>          `
                        div.append(html);
                    })
                } if(data?.fee?.ship_fee_only) {
                    let html = `
                    <div>
                       -- <strong> Phí vận chuyển: </strong><span class="text-danger fw-bold">${number_format(data?.fee?.ship_fee_only) } đ</span>
                    </div>`
                    div.append(html);
                 }
                 $('.render_shipping_option').html(div);
                 TriggerClickDataShippingRule();
                 setInputShippingOption(data);
              }
              else if(data?.fee?.delivery == false && data.success == true) {
                let span = $('<span>').addClass('text-danger').text('Địa chỉ không hợp lệ !!!');
                $('.shipping_price').html(span);
              }
          },
          error : function(error) {
            show_message(error?.message,'error');
            return false;
          }

       })
    }
}
function setInputShippingOption(data) {
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
    let total = $('<input>').attr('type','hidden').attr('name','freight_amount').val(sum);html.append(total)
    $('.input_hidden_price').html(html);
 }

function number_format(number, decimals = 0, dec_point = '.', thousands_sep = '.') {
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

function TriggerClickDataShippingRule()  {
  let found_checked = $('.shipping_price').text();
  if(found_checked) {
    let html = `
    <div type="subtitle" class="css-1lg3tx0">Tổng phí vận chuyển</div>
        <div class="teko-col css-17ajfcv" style="text-align: right;">
            <div type="subtitle" color="" style="font-size: 14px;font-weight:bold" class="shipping_attr css-nbdyuc"> ${found_checked}</div>
        </div>
    </div>`
     $('.render_here_method').html(html);
     RenderPriceToTal();
  }


}

function SubmitSendData(option) {
    $.ajax({
        type : 'GET',
        url: Server_Frontend +  "ajax/location",
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
    triggerSelect();
}

function loadProvince()  {
    if(province_id != '') {
        $('.provinces').val(province_id).trigger("change");
    }
}

function  RenderPriceToTal(){
    let price_orginal = Number($('#price_yet_cart').text().trim().slice(0,-1).replaceAll('.', ''));
    if($('.shipping_attr').length) {
        price_orginal += Number($('.shipping_attr').text().replace('đ','').replaceAll('.', ''));
    }
    $('.css-1lg3tx0').find('.total_render').html(number_format(price_orginal) + 'đ');
    let input_hidden = $('<input>').attr('type','hidden').attr('name','total_amount').val(price_orginal);
    $('.css-1lg3tx0').find('.total_render').append(input_hidden)
}

function Paginate(links = null)  {
        if(links?.length > 3) {
            let ul = $('<ul>').addClass('pagination');

            let nextTurnPage , prevTurnPage;
            $.each(links , function(index,val) {
             let liClass = 'page-item';
            if(val?.active) {
                liClass += ' active';
                nextTurnPage = links[index + 1] ?? 1;
                prevTurnPage = links[index - 1] ?? 1;
            }
             if(val?.url ==  null) liClass += ' disabled';
             let li = $('<li>').addClass(liClass);


             if(val?.label == 'pagination.previous'){

                let span = $('<a>')
                .attr('href',prevTurnPage?.url ?? (val?.active == true ? val?.url : links[index - 1]?.url))
                .attr('data-id',prevTurnPage?.label)
                .attr('rel','prev')
                .attr('aria-label','pagination.previous')
                .addClass('page-linkss')
                .text('<');
                li.append(span)
             }
             else if(val?.label == 'pagination.next') {
                let span = $('<a>')
                            .attr('href',nextTurnPage?.url)
                            .addClass('page-linkss')
                            .attr('rel','next')
                            .attr('data-id',nextTurnPage?.label)
                            .attr('aria-label','pagination.next')
                            .text('>');
                li.append(span)
             }
             else if(val?.url) {
                let a = $('<a>').attr('href',val?.url).addClass('page-linkss').text(val?.label);
                li.append(a);
             }
             ul.append(li);
            })

            let nav = $('<nav>').append(ul);
            return nav;
        }

}

function AjaxUsingGetMenuAttribute(option , target, subtring = null)  {
    $.ajax({
        type: 'GET',
        url: '/private/system/ajax/menu/getMenu',
        data : option,
        success : function(data){
            if(data?.response) {
                target.html(' ');
                $('.tab_menu_paginate').html(' ');
                $.each(data?.response?.data , function(index,val) {
                    target.append(RenderMenuAttributeCheckbox(val , subtring));
                })
                $('.tab_menu_paginate').append(PaginationMenuAttribute(data?.response?.links));

            }


        },
        error : function(error) {
             console.log(error)
        },
    })
}


//select2
$('.load-provinces').select2({
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
        url: Server_Frontend +  "ajax/provinces",
        dataType: 'json',
        data: function (params) {
            var query = {
                search: $.trim(params.term),
                page: params.page,
            };
            return query;
        }
    }
})
function triggerSelect(){
    $('.select_district').select2({
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
}



