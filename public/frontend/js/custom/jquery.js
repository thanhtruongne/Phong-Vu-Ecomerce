    function show_message(message,status){
        Swal.fire({
            text: message,
            icon: status
        })
    }

    function debounce(func, delay) {
        let timer;
        return function(...args) {
            const context = this;
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(context, args), delay);
        };
    }

    

    var arr = [0, 12000000];
    var Timer;
    const baseUrl = window.location.origin + window.location.pathname;
    let searchParams = new URLSearchParams(window.location.search);
    
    function renderProductCategoryFirstTime(option = null){
        let render = {};
        let price_range = {};
        let productCategory = $('input[name="productCategory"]').val();    
        searchParams.forEach(function(value,key){
            if (!Array.isArray(render[key]) && (key != 'price_lte' && key != 'price_gte')) {
                render[key] = []; 
            } else {
                price_range[key] = []; 
            }
            if(key != 'price_lte' && key != 'price_gte') {
                render[key] = value;
            } else {
                price_range[key] = value;
            }
          
        })
        $.each(render,function(key,attempt) {
            if(key != 'price_lte' && key != 'price_gte'){
                render[key] = attempt?.split(',');
            }
        });
        AjaxGetProductByFilterParams({
            attempt : render,
            ...price_range ,
            clear : null,
            product_category_id : productCategory
        });
    }

    $(document).on('click','.on_click_change_toggle',function() {
        let _this = $(this);
       
        if($('#data_class').hasClass('hidden')) {
            $('#data_class').removeClass('hidden');
            $('.css-1peoe6k').removeClass('hidden');
           OnHoverMenuSideBar()
        }
        else {
            $('#data_class').addClass('hidden');  
            $('.css-1peoe6k').addClass('hidden')
        }    
        
        SortWrappDivMenu();
    })    

    function OnHoverMenuSideBar(){
        if($('.set_ui_menu')) {
            $.each($('.set_ui_menu') , function(index,val) {
                let classList = $(val).attr('data-title');
                $(val).hover(function (e) {
                    $('.css-j61855').removeClass('hidden');
                    $('.css-j61855').find('.'+classList).removeClass('hidden')
                    $('.css-j61855').find('.'+classList).find('div.css-fej9ea').removeClass('hidden')
                    let divCenter = $('.css-j61855').find('div.css-fej9ea');
                    e.stopPropagation();
                }, function () {
                    if(!$('.css-j61855').find('.'+classList).find('div.css-fej9ea').hasClass('hidden')) {              
                    } 
                });
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

    function toVND (value) {
        // value = value.toString().replace(/\./g, "");
        const formatted = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
          })
          .format(value)
          .replace("₫", "")
          .trim();
        
        return formatted;
    }
    //productCategory
    $('.on_change_ajax').on('change',function(){
        clearTimeout(Timer);
        Timer = setTimeout(function(){           
            doingWhileFilter();
        }, 600)    
    })
    let filter_price = {};
    function doingWhileFilter(option = null){
        let data = {};
        let productCategory = $('input[name="productCategory"]').val();    
        $('.on_change_ajax').each(function(index,value){
            if( $(value) && $(value).prop('checked')){
                let value = $(this).val();
                let slug = $(this).parents('.ul_parent').siblings().data('id');
                if (!Array.isArray(data[slug])) {
                    data[slug] = []; 
                }
                data[slug]?.push(value);
            } else { 
                window.history.pushState({},'',baseUrl);       
            }
        })
        if(option) {
            filter_price[option?.key] = option?.value;
        }
        if(data || filter_price) {
            let string = '';
            $.each(data,function(key,attempt) {
                if(attempt){
                  string += key + '=' +attempt?.join(',') + '&';
                }
            })

            $.each(filter_price,function(index,item){
                if(item){
                  string += index + '=' + item + '&';
                }
            })  
            AjaxGetProductByFilterParams({
                attempt : data,
                ...filter_price ,
                clear : string == null ? 1 : null,
                product_category_id : productCategory
            });
            window.history.pushState(data,'','?'+string?.slice(0,-1).trim());
        }
    }


    function AjaxGetProductByFilterParams(option){ 
        $.ajax({
            type: 'GET',
            url : Server_Frontend + 'get-product-by-category-filter',
            data : option,
            success : function(data) {
                if(data?.status == 'success' && data?.rows) {
                  let render = $('#render_data');
                  let html = '';
                  $.each(data?.rows,function(index,value){
                    let name =  value?.sku_id ?  value?.variant_name : value?.product_name;                                
                    let promotion = value?.sku_id ? value?.variant_promotion_price : value?.promotion[0]; 
                    let image =  value?.sku_id ?  value?.variant_album : value?.image;
                    let price =  value?.sku_id ? value?.variant_price : value?.price;
                    let price_promtion_save = value?.promotion  ? (+price - +promotion?.amount) : null;
                    let slug =  value?.sku_id ?  value?.variant_slug : value?.slug;
                    let sku = value?.sku_id ?  value?.variant_sku : value?.product_sku;
                    let url  = '/'+slug + '--' + sku; 
                    html +=`
                    <div class="" style="background: white;margin-bottom: 2px;width: calc(20% - 2px);">
                        <div class="css-1msrncq fill_parent">
                            <a href="${url}" class="d-block" style="text-decoration: none">
                                <div class="" style="position-relative" style="margin-bottom:0.5rem">
                                    <div class="" style="margin-bottom: 0.25rem">
                                        <div class="position-relative"  style="padding-bottom: 100%">
                                            <img src="${image}"
                                            class="w-100 h-100 object-fit-contain position-absolute" style="top:0px;left:0px"
                                            alt="">
                                            ${ promotion ? 
                                                `<div class="position-absolute" style="width: 94px;bottom:0;left:0">
                                                    <div class="css-zb7zul">
                                                        <div style="font-size: 10px;font-weight: 700;color: #ffd591;">TIẾT KIỆM</div>
                                                        <div style="font-size: 13px;line-height: 18px;font-weight: 700;color: #FFFFFF;">
                                                           ${toVND(promotion?.amount)}
                                                        </div>
                                                    </div>
                                                </div>`
                                            : ''}
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="css-90n0z6 text-uppercase">
                                           ${value?.brand_name}
                                        </div>
                                    </div>
                                    <div class="my-2">
                                        <div class="css-1uunp2d">
                                            <h3 class="css-1xdyrhj">${name}</h3>
                                        </div>
                                    </div>
                                    <div class="" style="position: relative;margin-top: 0.25rem;padding-right: unset;margin-bottom: 0.25rem;">
                                        <div class="d-flex flex-column" style="height:2.5rem;">
                                            <div type="subtitle" class="att-product-detail-latest-price css-do31rh" color="primary500">  ${toVND(price)} ₫</div>
                                            ${promotion ? `
                                                <div class="d-flex" style="height:1rem">
                                                    <div type="caption" class="att-product-detail-retail-price css-18z00w6" color="textSecondary"> ${toVND(price_promtion_save)} đ</div>
                                                    <div type="caption" color="primary500" class="css-2rwx6s">  - ${(100 - ((+price_promtion_save / +price) * 100)).toFixed(2) } %</div>
                                                </div>   
                                            ` : ''}
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <button height="2rem" color="primary500" class="css-16gdkk6 add_to_cart_list" type="button">
                                <div type="body" class="button-text css-ct8m8z" color="primary500">Thêm vào giỏ</div>
                                <span style="margin-left: 0px;">
                                    <div class="css-157jl91"></div>
                                </span>
                            </button> 
                        </div>
                    </div>
                    `;
                  })
                  render.html(html);
                } else {
                    return false;
                }
            },
            error : function(error) {
                console.log(error);
                return false;
            }
            
         })
    }

    var slider = document.getElementById('slider');
    var moneyFormat = wNumb({
        decimals: 3,
        thousand: ".",
        suffix: " đ"
    });

    noUiSlider.create(slider, {
        start: arr,  
        step : 1000000,
        range: {
            'min': 0,
            'max': 100000000
        },
        format :moneyFormat,
        connect: true,
    });
    var snapValues = [
        document.getElementById('slider-snap-value-lower'),
        document.getElementById('slider-snap-value-upper')
    ];
    slider.noUiSlider.on('change', function(values, handle) {
        snapValues[handle].innerHTML = values[handle];
        let key_string = +handle == 1 ? 'price_lte' : 'price_gte';
        clearTimeout(Timer);
        Timer = setTimeout(function(){         
            doingWhileFilter(            
                {
                    key : key_string,
                    value : arr.includes(check_validate_range_price(snapValues[1].innerHTML)) ? null : (+values[handle]?.replace("đ", "")?.replaceAll(".", "").trim() == 0 ? null : values[handle]?.replace("đ", "")?.replaceAll(".", "").trim())
                }
              
            );
        }, 600)  
    });

    function check_validate_range_price(price){
        let format = price?.replace("đ", "")?.replaceAll(".", "").trim();
        return +format;
    }


  
    

