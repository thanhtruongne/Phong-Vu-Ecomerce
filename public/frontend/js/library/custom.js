(function($) {
    "use strict";
    var Data = {};

   Data.OnchangeTheVariantProduct = () => {
        if($('.attribute_click').length > 0) {
            $('.attribute_click').on('click',function(e) {  
                e.preventDefault();
                let attributeID = [];
                let attributeParams = [];
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
                    }
                })

               
                Data.handleLoadVariantProduct(attributeID,attributeParams);
               

            })
        }
   }
   Data.handleLoadVariantProduct = (attributeID,attributeParams = null) => {
      $.ajax({
        type: "GET",
        url : `${Server_Frontend}/ajax/dashboard/loadVariant`,
        data : {
            'attributeID' : attributeID,
            'product_Id' : $('input[name="product_id"]').val()
        },
        success : function(res) {
            if(res.data != undefined) {
                let album = res.data.album.split(",");
                let canonical = $('.find_original_name .title_product_dynamic').attr('data-canonical');
                $('#album_miltiple').html(Data.SetUpAlbumProductVariant(album));
                // set album
                Data.setUpGlideSliderProductVariant();
                //set name
                let nameData = $('.find_original_name').attr('data-name');               
                $('.find_original_name .title_product_dynamic').find('h1').html(nameData + ' ' + res.name_convert)
                $('.css-1f5a6jh').find('span.sku_after_variant').html(res.data?.sku);
                // set variant
                Data.setUpInputVariant(res?.data) ;
                let promotions = res.data?.promotions.length ?  res.data?.promotions[0] : null;
                Data.SetUpPromotionsProductVariant(promotions,res?.data?.price);
                Data.LoadURLparamsWhenChoose(canonical,attributeParams,res.data?.sku);
                return true;
            }
            else {
                    $.toast({
                        text: `   
                        <div class="d-flex" style="padding:8px 16px;display: flex;margin-left: -59px;align-items: center;font-size:15px">
                       <svg height="30" width="30" size="30" viewBox="0 0 512 512" class="me-3" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" ><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier"  fill="rgba(237,13,59,1)"stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>error-filled</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="add" fill="#000000" transform="translate(42.666667, 42.666667)"> <path d="M213.333333,3.55271368e-14 C331.136,3.55271368e-14 426.666667,95.5306667 426.666667,213.333333 C426.666667,331.136 331.136,426.666667 213.333333,426.666667 C95.5306667,426.666667 3.55271368e-14,331.136 3.55271368e-14,213.333333 C3.55271368e-14,95.5306667 95.5306667,3.55271368e-14 213.333333,3.55271368e-14 Z M262.250667,134.250667 L213.333333,183.168 L164.416,134.250667 L134.250667,164.416 L183.168,213.333333 L134.250667,262.250667 L164.416,292.416 L213.333333,243.498667 L262.250667,292.416 L292.416,262.250667 L243.498667,213.333333 L292.416,164.416 L262.250667,134.250667 Z" id="Combined-Shape"> </path> </g> </g> </g>
                       </svg>
                        ${res?.message}</div>`,
                        icon: 'error',
                        bgColor: '#fff',
                        textColor: '#333333',
                        loaderBg : 'rgba(255,17,0,1)',
                        position: 'top-right',
                        showHideTransition: 'plain',
                    
                    })

            }
            
        },  
        error : function(error) {
            return false;
        }
      })
   } 
   Data.setUpGlideSliderProductVariant = () => {

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

   Data.SetUpPromotionsProductVariant = (promotions,price) => {
    let product_price_after_discount =  promotions != null ? (promotions['product_variant_price'] - promotions['discount']) : price;
    $('.css-2zf5gn .price_original').html( Data.number_format(product_price_after_discount) + 'đ'); 
    if(promotions != null) {
        $('.css-2zf5gn .price_discount').html(Data.number_format(promotions['product_variant_price']) + 'đ')
        $('.css-2zf5gn .discount_type').html('-' + promotions['discountValue'] + ' ' + promotions['discountType'] )
    }
   
   }
    Data.setUpInputVariant = (data) => {
        console.log(data);
        let product_price_after_discount = data?.promotions?.length > 0 
        ? data?.promotions[0]['product_variant_price'] - data?.promotions[0]['discount']
        : null ;
        $('input[name="product_variant_id"]').val(data?.id);   
        $('input[name="attribute_id"]').val(data?.code);   
        $('input[name="discountValue"]').val( data?.promotions?.length > 0 ? data?.promotions[0]['discountValue'] : null);   
        $('input[name="discountType"]').val( data?.promotions?.length > 0 ? data?.promotions[0]['discountType'] : null);   
        $('input[name="price_after_discount"]').val(product_price_after_discount);  
        $('input[name="attribute_name"]').val(data?.name);  
        $('input[name="price"]').val(data?.price);      
    }

   Data.SetUpAlbumProductVariant = (galley) => {
    
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

   Data.loadDingDataTitleDynamic = () => {
    if($('a.loading_title').length) {
        $('a.loading_title').each(function(index,val) {
            let data_title = $(val).attr('data-load');    
            $(val).parents('.css-vxzt17').siblings('.css-172d5l5').find('div.title').html(data_title);
        })
    }
   }

   Data.LoadURLparamsWhenChoose = (url,params,sku_id) => {
     $.each(params,function(index,val) {
        if(!val.match(/\d/)) {
            params.push(params.splice(params.indexOf(val), 1)[0]);
        }
        let change = params.join('--');
        let content_url = url + '---' + change + '?sku=' + sku_id;
        let objectData = { sku : sku_id};
        history.pushState(objectData,'',content_url);
     })
     
   }

   Data.AddToCartClick = () => {
      $(document).on('click','.add_to_cart',function(e) {
        e.preventDefault();
        let data = {
            'id'  :  $('input[name="product_id"]').val() + (
            $('input[name="product_variant_id"]').val() !== '' ? '_' + $('input[name="product_variant_id"]').val() : '' ),
            'name' : $('.find_original_name .title_product_dynamic').find('h1').text().trim(),
            'price' :  Number($('input[name="price"]').val()),
            'qualnity' :  1,
            'discountValue' :  $('input[name="discountValue"]').val(),
            'discountType' :  $('input[name="discountType"]').val(),
            'priceSale' : Number($('input[name="price_after_discount"]').val()),
            'attribute' :  $('input[name="attribute_id"]').val(),
            'attributeName' :  $('input[name="attribute_name"]').val(),
        }
        if(data)  Data.AjaxAddToCart(data);
        
      })
   }

   Data.addTocartInFillList = () => {
    $(document).on('click','.add_to_cart_list',function(e) {
        e.preventDefault();
        let _this = $(this);
        let parent = _this.parents('.fill_parent');
        console.log($(parent).find('input[name="product_variant_id"]').val());
        let data = {
            'id'  :$(parent).find('input[name="product_id"]').val()+ '_' + $(parent).find('input[name="product_variant_id"]').val(),
            'name' : $(parent).find('.name_category_product').text().trim(),
            'price' :  Number($(parent).find('input[name="price"]').val()),
            'qualnity' :  1,
            'discountValue' :  $(parent).find('input[name="discountValue"]').val(),
            'discountType' :  $(parent).find('input[name="discountType"]').val(),
            'priceSale' : Number($(parent).find('input[name="price_after_discount"]').val()),
            'attribute' :  $(parent).find('input[name="attribute_id"]').val(),
            'attributeName' :  $(parent).find('input[name="attribute_name"]').val(),
        }
        if(data)  Data.AjaxAddToCart(data);
        
      })
   }


   Data.AjaxAddToCart = (data) => {
      $.ajax({
         type: 'GET',
         url :  `${Server_Frontend}/ajax/dashboard/addToCart`,
         data : data,
         success: function(res) {
           if(res.errCode == 2) {
            $('#count_cart').html(res?.cartCount);
            $.toast({
                text: `   
                <div class="d-flex" style="padding:8px 16px;display: flex;margin-left: -59px;align-items: center;font-size:15px">
                 <svg fill="none" viewBox="0 0 24 24" size="30" class="css-9w5ue6" style="margin-right:8px" height="30" width="30" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" fill="rgba(48,205,96,1)"></circle>
                 <path d="M15.371 9.20702L11.047 13.291L9.15068 11.499C8.85739 11.222 8.38306 11.222 8.08977 11.499C7.79755 11.775 7.79755 12.223 8.08977 12.5L10.5186 14.792C10.8098 15.068 11.2841 15.068 11.5774 14.792L16.4319 10.208C16.7242 9.93102 16.7242 9.48302 16.4319 9.20702C16.2858 9.06802 16.0931 8.99902 15.9015 8.99902C15.7098 8.99902 15.5182 9.06802 15.371 9.20702Z" fill="white"></path></svg>
                ${res?.message}</div>`,
                icon: 'success',
                bgColor: '#fff',
                textColor: '#333333',
                loaderBg : 'rgba(48,205,96,1)',
                position: 'top-right',
                showHideTransition: 'plain',
              
            })
            // $('button.add_to_cart').prop('disabled',true).addClass('opacity_active').append('<i class="fa-solid fa-check ms-2"></i>')
           }
           
         },
         error: function(error) {
              console.log(error);
         },

      })
   }


//    Data.province = () => {
//     $(document).on('change','.location',function() {
//         let option = {
//             'data' : {
//                 'location_id' : $(this).val()
//             },
//             'target' : $(this).attr('data-target')
//         }
//         Data.SubmitSendData(option);
//         Data.chooseShippingGHTK();
//     })
// }
// Data.TypingAddressCheck = () => {
//     let clear = null;
//     $('input[name="address"]').on('input',function(){
//         if(clear) clearTimeout(clear);

//         clear = setTimeout(() => {        
//             return Data.chooseShippingGHTK();   
//         }, 1500);
        
//     })
// }
// Data.chooseShippingGHTK = () => {
//     if($('.provinces').val() && $('.districts').val() && $('input[name="address"]').val()) {
//        $.ajax({
//           type: 'GET',
//           url : `${Server_Frontend}/ajax/ghtk/transportfee`,
//           data : {
//             province : $(".provinces option:selected" ).text(),
//             districts :$(".districts option:selected" ).text() ,
//             ward :$(".wards option:selected" ).text() ?? '',
//             address : $('input[name="address"]').val(),
//             value : Number($('.total_render').text().replace("đ", "").replace(/\./g, '')),
//           },
//           beforeSend: function() {
//             // setting a timeout
//             let loading = `
//             <div class="spinner-border text-primary" role="status">
//                 <span class="sr-only">Loading...</span>
//             </div>`
//             $('.shipping_price').html(loading);
//         },
//           success : function(data) {
            
//               if(data.success && data.fee?.delivery != false) {
//                 $('.shipping_price').html(' ');
//                  $('body .shipping_price').html(Data.number_format(data?.fee?.fee) + 'đ');
//                  let div = $('<div>');
//                  if(data?.fee?.insurance_fee) {
//                     let html = `
//                     <div>
//                      -- <strong> Bảo hiểm đơn hàng: </strong><span class="text-danger fw-bold">${Data.number_format(data?.fee?.insurance_fee)} đ</span>
//                     </div>`
//                     div.append(html);
//                  }
                 
//                 if(data?.fee?.extFees.length){
//                     $.each(data?.fee?.extFees,function(index,val){
//                         console.log(val.title,index)
//                         let html = `
//                         <div>
//                           -- <strong>${val.title}: </strong><span class="text-danger fw-bold">${val.display}</span>
//                         </div>          `
//                         div.append(html);
//                     })
//                 } if(data?.fee?.ship_fee_only) {
//                     let html = `
//                     <div>
//                        -- <strong> Phí vận chuyển: </strong><span class="text-danger fw-bold">${Data.number_format(data?.fee?.ship_fee_only) } đ</span>
//                     </div>`
//                     div.append(html);
//                  }
//                  $('.render_shipping_option').html(div);
//                  Data.TriggerClickDataShippingRule();
//                  Data.setInputShippingOption(data);
//               }
//               else if(data?.fee?.delivery == false && data.success == true) {
//                 let span = $('<span>').addClass('text-danger').text('Địa chỉ không hợp lệ !!!');
//                 $('.shipping_price').html(span);
//               }
//           },
//           error : function(error) {
//             $.toast({
//                 text:error?.message,
//                 icon: 'error',
//                 bgColor: '#fff',
//                 position: 'top-right',
//                 showHideTransition: 'plain',
              
//             })
//           }
          
//        })
//     }
// }
// Data.setInputShippingOption = (data) => {
//     let html = $('<div>');
//     let sum = 0 ;
//    if(data?.fee?.insurance_fee) {
//       let input1 = $('<input>').attr('type','hidden').attr('name','shipping_options[insurance_fee]').val(data?.fee?.insurance_fee);
//       sum += data?.fee?.insurance_fee
//       html.append(input1)
//    }
//    if(data?.fee?.extFees) {
//     $.each(data?.fee?.extFees,function(index,val){
//         let input2 = $('<input>').attr('type','hidden').attr('name','shipping_options[extFees]').val(val?.amount);
//          sum += val?.amount
//         html.append(input2)
        
//     })
    
//     }
//     if(data?.fee?.ship_fee_only) {
//         let input3 = $('<input>').attr('type','hidden').attr('name','shipping_options[ship_fee_only]').val(data?.fee?.ship_fee_only);
//          sum += data?.fee?.ship_fee_only;
//         html.append(input3)
//     }
//     let total = $('<input>').attr('type','hidden').attr('name','shipping_options[total]').val(sum);html.append(total)
//     $('.input_hidden_price').html(html);
//  }

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

// Data.TriggerClickDataShippingRule = () => {
//   let found_checked = $('.shipping_price').text();
//   if(found_checked) {
//     let html = `
//     <div type="subtitle" class="css-1lg3tx0">Tổng phí vận chuyển</div>
//         <div class="teko-col css-17ajfcv" style="text-align: right;">
//             <div type="subtitle" color="" style="font-size: 14px;font-weight:bold" class="shipping_attr css-nbdyuc"> ${found_checked}</div>
//         </div>
//     </div>`
//      $('.render_here_method').html(html);
//      Data.RenderPriceToTal();
//   }
 
  
// }

// Data.SubmitSendData = (option) => {
//     $.ajax({ 
//         type : 'GET', 
//         url: "/ajax/dashboard/location",
//         data: option, 
//         success : function(data) 
//         { 
//             $('.' + option.target).html(data.data);
   
//             if(district_id != '' && option.target == 'districts') {          
//                 $('.districts').val(district_id).trigger("change");
//             }
//             if(ward_id != '' && option.target == 'wards') {
//                 $('.wards').val(ward_id).trigger("change");
//             }
//         }, 
//          error : function(error) { 
//             console.log(error); 
//         }
//      })
// }

// Data.loadProvince = () => {
//     if(typeof province_id != null && province_id != '') {
//         $('.provinces').val(province_id).trigger("change");
//     } 
// }

Data.RenderPriceToTal = () => {
    let price_orginal = Number($('#price_yet_cart').text().trim().slice(0,-1).replaceAll('.', ''));
    if($('.shipping_attr').length) {
        price_orginal += Number($('.shipping_attr').text().replace('đ','').replaceAll('.', ''));
    }
    $('.css-1lg3tx0').find('.total_render').html(Data.number_format(price_orginal) + 'đ');
    let input_hidden = $('<input>').attr('type','hidden').attr('name','total').val(price_orginal);
    $('.css-1lg3tx0').find('.total_render').append(input_hidden)     
}

Data.Paginate = (links = null) => {
        console.log(links);
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

Data.AjaxUsingGetMenuAttribute = (option , target, subtring = null) => {
    $.ajax({
        type: 'GET',
        url: '/private/system/ajax/menu/getMenu',
        data : option,
        success : function(data){
            console.log(data?.response);
            if(data?.response) {
                target.html(' ');
                $('.tab_menu_paginate').html(' ');
                $.each(data?.response?.data , function(index,val) {
                    target.append(Data.RenderMenuAttributeCheckbox(val , subtring));
                })
                $('.tab_menu_paginate').append(Data.PaginationMenuAttribute(data?.response?.links));
                
            }
        
           
        },
        error : function(error) {
             console.log(error)
        },
    })
}

Data.setupRangeSlider = () => {
    var slider = document.getElementById('slider');
    var moneyFormat = wNumb({
            decimals: 3,
            thousand: ".",
            suffix: " đ"
        });
noUiSlider.create(slider, {
    start: [1000000, 40000000],  
    step : 100000,
    range: {
        'min': 0,
        'max': 80000000
    },
    format :moneyFormat,
    connect: true,
});
var snapValues = [
    document.getElementById('slider-snap-value-lower'),
    document.getElementById('slider-snap-value-upper')
];
slider.noUiSlider.on('change.one', function (values, handle) {
    var clear = null;
    if(clear) clearTimeout(clear);

    clear = setTimeout(() => {        
        return Data.filterSliderRange($(snapValues[handle]).attr('data-name'),values[handle]);  
    }, 1000);
    
});


slider.noUiSlider.on('update', function (values, handle) {
    $(snapValues[handle]).val(values[handle])
});
snapValues.addEventListener('change', function () {
    slider.noUiSlider.set(this.value);
});
}

Data.filterSliderRange = (name,value) => {
    const searchParams = new URLSearchParams(window.location.search);
    let num = Number(value.replace(' đ',' ').replaceAll('.',''));
    if(num === 0 && searchParams.has(name)) searchParams.delete(name);
    else if(searchParams.has(name)) {
        searchParams.delete(name);
        searchParams.set(name,num) 
    }
    else searchParams.set(name,num) 
    Data.setPushStateHistory(searchParams);
}   


Data.filterOnCheckBoxSidebarProdutCate = () => {
    $('body').on('change','.change_checkbox_item',function(){
       let _this = $(this);
       let attributeName = _this.attr('data-attribute');
       let attributeValue = _this.val();
       if(_this.is(':checked') == true) {
          let url = Data.AddQuery(attributeName,attributeValue);
       }
       else {
            Data.existsQueryAdd(attributeName,attributeValue);
       }

       
    })
}

Data.filterSortProductCateloge = () => {
    $('body').on('click','.checkbox_item_sort',function(){
        const searchParams = new URLSearchParams(window.location.search);
        let _this = $(this);
        let sort = _this.attr('data-type');
        let order = _this.attr('data-value');
        if(searchParams.has('sort') && searchParams.has('order')){
           searchParams.delete('sort'); searchParams.delete('order');
           searchParams.set('sort',sort);  searchParams.set('order',order);
        }
        else {
            searchParams.set('sort',sort);  searchParams.set('order',order);
        }
        Data.setPushStateHistory(searchParams);

    })
}

Data.AddQuery = (attributeName , attributeValue) => {
    const searchParams = new URLSearchParams(window.location.search);
    if(searchParams.has(attributeName)) {
        let orginalParams = searchParams.get(attributeName);
        let arrayConvert  = orginalParams + ',' + attributeValue;
        let arraySplit = arrayConvert.split(',').join(',');
        searchParams.set(attributeName,arraySplit)
    }
    else {
        searchParams.append(attributeName, attributeValue);
    }
    
    Data.setPushStateHistory(searchParams);
}

Data.existsQueryAdd = (attributeName,attributeValue ) => {
    const searchParams = new URLSearchParams(window.location.search);
    let orginalParams = searchParams.has(attributeName);
    if(orginalParams) {
        let originalValue = searchParams.get(attributeName);
        let orignalArray = originalValue.split(',');
        if(orignalArray.includes(attributeValue)) {
            orignalArray = orignalArray.filter(element => {
               return element !== attributeValue
            });
            searchParams.set(attributeName,orignalArray);
            if(searchParams.get(attributeName).length === 0){
                searchParams.delete(attributeName);
            }
            Data.setPushStateHistory(searchParams);
            
        }
    }
}
Data.setPushStateHistory = (searchParams) => {
    let newRelative =
    searchParams.toString().length > 0 
    ?  window.location.pathname + '?' + searchParams.toString()
    :  window.location.pathname;
   
    history.pushState(null,"",newRelative);
    Data.AjaxFilterCallProductCateloge(searchParams)
}


Data.AjaxFilterCallProductCateloge = (searchParams) => {
    let attemp = {};
    if(searchParams != undefined &&  searchParams.toString() !== ' '){
        searchParams.forEach((value, key) => {  
            attemp[key] = value
        });
        if($('input[name="cateloge_id"]').val().length > 0) {
            attemp['cateloge_id'] = $('input[name="cateloge_id"]').val();
        }
        $.ajax({
            type: 'GET',
            url : `${Server_Frontend}/ajax/filter/productCateloge`,
            data : attemp,
            success : function(data) {
                console.log(data.data)
                if(data.status == true) {
                    let response = data.data;
                    let html = '';
                    for(let i = 0; i < response.length ; i++) {
                       console.log(response[i].promotions)
                         html += `
<div class="" style="background: white;margin-bottom: 2px;width: calc(20% - 2px);">
    <div class="css-1msrncq fill_parent">
        <a href="${response[i]?.canonical}" class="d-block" style="text-decoration: none">
            <div class="" style="position-relative" style="margin-bottom:0.5rem">
                <div class="" style="margin-bottom: 0.25rem">
                    <div class="position-relative"  style="padding-bottom: 100%">
                        <img src="${response[i].album.split(',')[0]}"
                        class="w-100 h-100 object-fit-contain position-absolute" style="top:0px;left:0px"
                        alt="">
                        ${response[i].promotions != undefined 
                        ? 
                        `<div class="position-absolute" style="width: 94px;bottom:0;left:0">
                            <div class="css-zb7zul">
                                <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                    ${Data.number_format(+response[i].promotions?.discount)}đ 
                                </div>
                            </div>
                        </div>` 
                        :  ''}
                    </div>
                </div>
                <div class="" style="margin-bottom: 0.25rem">
                    <div type="body" color="textSecondary" class="product-brand-name css-90n0z6" style="text-transform: uppercase; display: inline;">
                       ${response[i]?.cateloge_name.toUpperCase()}
                    </div>
                </div>
                <div class="" style="height:3rem">
                    <div type="caption" class="att-product-card-title css-1uunp2d" color="textPrimary">
                        <h3 
                        class="css-1xdyrhj name_category_product">
                            ${response[i]?.name}
                        </h3>
                    </div>
                </div>
                <div class="" style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                    <div class="d-flex flex-column" style="height:2.5rem;">
                        <div type="subtitle" class="att-product-detail-latest-price css-do31rh" color="primary500">
                            ${response[i]?.price_update != undefined 
                                ?  Data.number_format(response[i]?.price_update)
                                : Data.number_format(response[i]?.price)
                            }đ
                        </div>
                        ${response[i].promotions != undefined
                            ? 
                            `<div class="d-flex" style="height:1rem">
                                <div type="caption" class="att-product-detail-retail-price css-18z00w6" color="textSecondary">${response[i]?.price} ₫</div>
                                <div type="caption" color="primary500" class="css-2rwx6s">                 
                                    -${Data.number_format(response[i]?.promotions?.discountValue)} ${response[i]?.promotions?.discountType}
                                </div>
                            </div>
                            `
                            :''
                        }
                 
                    </div>
                </div>
            </div>
        </a>
        <div class="">
            <input type="hidden" name="product_id" value="${response[i].product_id}">
            <input type="hidden" name="product_variant_id" value="${response[i].product_variant_id}">
            <input type="hidden" name="qualnity" value="1">
            <input type="hidden" name="price" value="${response[i].price}">
            <input type="hidden" name="price_after_discount" value="${response[i].price_update ?? response[i].price }">
            <input type="hidden" name="discountValue" value="${response[i].promotions?.discountValue ?? null}  ">
            <input type="hidden" name="discountType" value="${response[i].promotions?.discountType ?? null }">
            <input type="hidden" name="attribute_id" value="${response[i].code}">
            <input type="hidden" name="attribute_name" value="${response[i].product_variant_name}">
        
        </div>
        <button height="2rem" color="primary500" class="css-16gdkk6 add_to_cart_list" type="button">
            <div type="body" class="button-text css-ct8m8z" color="primary500">Thêm vào giỏ</div>
            <span style="margin-left: 0px;">
                <div class="css-157jl91"></div>
            </span>
        </button> 
    </div>
</div>
                         `

                    }
   $('.render_method_products').html(html)
                }
            },
            error : function(error) {
                console.log(error);
            }
        })
    }
}



Data.checkTriggerCheckboxParams = () => {
    
}



   $(document).ready(function() {
      
        Data.addTocartInFillList();
        Data.loadDingDataTitleDynamic();
        Data.OnchangeTheVariantProduct();
        Data.AddToCartClick();
        Data.checkTriggerCheckboxParams();
        Data.RenderPriceToTal();
        // Data.TypingAddressCheck();
        Data.filterOnCheckBoxSidebarProdutCate();
        Data.filterSortProductCateloge();
        //step error
        // Data.province();
        // Data.loadProvince();
        Data.setupRangeSlider();
         
      
   })

})(jQuery);