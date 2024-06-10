(function($) {
    "use strict";
    var Data = {};
    var promotion = [];
   Data.ChooseNoDateForPromotion = () => {
       $(document).on('click','.no_date_promotion',function() {
            let _this  = $(this);
            if(_this.prop('checked') == true) {
                _this.parents('div').prev().find('input[name="endDate"]').val('').attr('disabled',true);
            }
            else {
                _this.parents('div').prev().find('input[name="endDate"]').val('').removeAttr('disabled');
            }
       })
   }

   Data.ChooseSourceApply = () => {
      $(document).on('click','.choose_apply_source',function() {
            let _this = $(this);
            let option = {
                'model' : _this.attr('data-model')
            }
           
            if(_this.attr('data-id') == 'choose_apply') {
                $.ajax({
                    type: 'GET',
                    url : '/private/system/ajax/dashboard/promotion/source',
                    data : option,
                    success : function(data) {
    
                        if(data.length > 0) {
                            _this.parents('div')
                            .siblings('.choose_customer_hidden_change')
                            .html('');
                            let divAppend = _this.parents('div')
                            .siblings('.choose_customer_hidden_change')
                            .removeClass('hidden')
                            .append(Data.RenderSelect2Multiple(data,'applyValue[]','source'))
                             Data.setUpBackSelect2();
                        }
                    
                    },
                    error : function(error) {
                        
                    }
                })
                
            }
            else {
                _this.parents('div').siblings('.choose_customer_hidden_change').addClass('hidden').html('')

            }
      })
   }

   Data.ChooseSourceCustomer = () => {
    $(document).on('click','.customer',function() {
          let _this = $(this);
          let option = [
            {
                'id' : 'staff_take_care',
                'name' : 'Nhân viên chăm sóc và hỗ trợ'
            },
            {
                'id' : 'customer_birthday',
                'name' : 'Theo ngày sinh'
            },
            {
                'id' : 'customer_group',
                'name' : 'Theo nhóm khách hàng'
            },
            {
                'id' : 'customer_gender',
                'name' : 'Theo giới tính'
            },
          ]
        
          if(_this.attr('data-id') == 'customer') {
            _this.parents('div').siblings('.render_this_select2').html('');
             _this.parents('div')
                    .siblings('.render_this_select2')
                    .removeClass('hidden')
                    .append(Data.RenderSelect2Multiple(option,'CustomerValue[]'))
                Data.setUpBackSelect2();
          }
          else {
              _this.parents('div').siblings('.render_this_select2').addClass('hidden').html('')

          }
    })
 }

   Data.RenderSelect2Multiple = (data , name , type = null) => {

    
        let row = $('<div>');
        let select = $('<select>')
                        .addClass(`select2 form-control ${type != null && type == 'source' ? '' : 'onchange_delicate_this'}`)
                        .attr('multiple',true)
                        .attr('name',name);
                 
        $.each(data,function(index ,val) {
            let option = $('<option>'). attr('data-model',val?.id).val(val?.id).text(val?.name);
            select.append(option);
        })                        
        row.append(select);
        return row;

   }

   Data.setUpBackSelect2 = () => {
    $('.select2').select2({
        tags: true,
        placeholder: "Chọn dữ liệu",
        allowClear: true,
        width: '100%'
      });
   }

   Data.setUpDateTimePicker = () => {
        $('.datepicker').datetimepicker({
            timepicker: true,
            format : 'd/m/Y H:i',
            minDate : new Date()
        });
   }

   Data.AddMorePromotion = () => {
        $(document).on('click','.add_promotion_price',function() {
             let _this = $(this);
             let table = _this.parents('div').prev().find('tbody');
             table.append(Data.renderTableRowPromotion());
             Data.setUpBackSelect2();
        })
   }

   Data.OnChangeMethodSelectPromotion = () => {
      $(document).on('change','.method_select_promotion',function() {
       
            let _this = $(this);
            let model = JSON.parse(_this.attr('data-product')) ;
          
            switch(_this.val()) {
                case 'order_amount_range' :
                    console.log('cas2')
                    $('.render_here_method').html('')
                    Data.renderOderAmountRange();
                    break; 
                case 'product_and_qualnity' :  
                console.log('case')                
                    $('.render_here_method').html('');
                    console.log($('.render_here_method'))
                    $('.render_here_method').html(Data.renderProductAndQualnity(model));
                    break; 
                case 'product_and_range' :
                    $('.render_here_method').html('')
                    break; 
                case 'discount_by_qulalnity' :
                    $('.render_here_method').html('')
                    break;
                default : 
                    $('.render_here_method').html('')
                    break;    
            }
      })
      let dataOld = $('input[name="preload_promotionMethod"]').val();
        if(dataOld.length && typeof dataOld != null) {
            $('.method_select_promotion').val(dataOld).trigger('change');
        }
   
   }

   Data.renderProductAndQualnity = (option) => {
          let html = '';
          let optional = '';
          for (const [key, value] of Object.entries(option)) {
            optional += `<option value="${key}">${value}</option>`;
          }
          html = `
          <div class="promotion_container">
            <div class="choose_version_product">
                <select name="discountMethodProduct" class="form-control select2 choose_product_promo" id="">        
                    <option value="">Chọn sản phẩm khuyến mãi</option>
                     ${optional}
                </select>   
            </div>
            <div  style="margin-top:20px ">
                
            </div>
          </div>
          `;
          return html;
   }

   Data.renderOderAmountRange = () => {
    let html ; 
       html = `
       <div class="order_amount">
            <table class="table table-bordered">
                <thead>
                <tr >
                    <th style="background-color: #fff">Giá trị từ </th>
                    <th style="background-color: #fff">Giá trị sau </th>                   
                    <th style="background-color: #fff"></th>
                    <th style="background-color: #fff">Chiết khấu</th> 
                    <th style="background-color: #fff"></th> 
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-lg-4">
                            <input type="text" value="0" name="promotion_order[amountFrom][]" class="form-control">
                        </td>
                        <td class="col-lg-4">
                            <input type="text" value="0" name="promotion_order[amountTo][]" class="form-control">
                        </td>
                        <td class="col-lg-2">
                            <input type="text" name="promotion_order[amountValue][]" value="0" class="form-control">
                        </td>
                        <td class="col-lg-4">
                            <select name="promotion_order[amountType][]" id="" class="form-control select2">
                                <option value="1">%</option>
                                <option value="2">VND</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-secondary">
                                    <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div>
                <button type="button" class="btn btn-primary add_promotion_price">Thêm mã khuyến mãi</button>
            </div>
        </div>
       `
       $('.render_here_method').html(html);
   }

   Data.CheckSubmitOrderAmountRange = () => {
    let html = '';
      if(
        $('input[name="order_range_promotion_detail"]').val() !== 'null' &&
        $('input[name="preload_promotionMethod"]').val() == 'order_amount_range'
    ) 
        {
            let tr = '';
            let data = JSON.parse($('input[name="order_range_promotion_detail"]').val()) || {
              'amountFrom' : ['0'],
              'amountTo' : ['0'],
              'amountValue' : ['0'],
              'amountType' : ['%'],
            };
            for(let i = 0 ; i < data?.amountFrom?.length ; i++) {
              let amountFrom = data?.amountFrom[i];
              let amountTo = data?.amountTo[i];
              let amountType = data?.amountType[i];
              let amountValue = data?.amountValue[i];
      
              tr += `
                  <tr>
                      <td class="col-lg-4">
                          <input type="text" value="${amountFrom}" name="promotion_order[amountFrom][]" class="form-control">
                      </td>
                      <td class="col-lg-4">
                          <input type="text" value="${amountTo}" name="promotion_order[amountTo][]" class="form-control">
                      </td>
                      <td class="col-lg-2">
                          <input type="text" name="promotion_order[amountValue][]" value="${amountValue}" class="form-control">
                      </td>
                      <td class="col-lg-4">
                          <select name="promotion_order[amountType][]" id="" class="form-control select2">
                              <option ${amountType == '%' ? 'selected' : ''} value="%">%</option>
                              <option ${amountType == 'VND' ? 'selected' : ''} value="VND">VND</option>
                          </select>
                      </td>
                      <td>
                          <button type="button" class="btn btn-secondary">
                                  <i class="fa-solid fa-trash"></i>
                          </button>
                      </td>
                  </tr>
              `
            }
             html = `
            <div class="order_amount">
                  <table class="table table-bordered">
                      <thead>
                      <tr >
                          <th style="background-color: #fff">Giá trị từ </th>
                          <th style="background-color: #fff">Giá trị sau </th>                   
                          <th style="background-color: #fff"></th>
                          <th style="background-color: #fff">Chiết khấu</th> 
                          <th style="background-color: #fff"></th> 
                      </tr>
                      </thead>
                      <tbody>
                         ${tr}
                      </tbody>
                  </table>
      
                  <div>
                      <button type="button" class="btn btn-primary add_promotion_price">Thêm mã khuyến mãi</button>
                  </div>
              </div>`
              $('.render_here_method').html(html);
            }
   }
    

   Data.CheckProductPromotionQuanity = () => {
    let html = '';
    console.log($('input[name="product_and_quanity"]').val())
    if(
        $('input[name="preload_promotionMethod"]').val() == 'product_and_qualnity' &&
        $('input[name="product_and_quanity"]').val() == 'Product' 
    ) {
        let data = JSON.parse($('input[name="order_range_promotion_detail"]').val());
        let model = $('input[name="product_and_quanity"]').val();
        console.log(model);
        Data.AjaxReturnPromotionProductById($('input[name="promotion_id"]').val(),data,model);
 
    }
    
   }

   Data.AjaxReturnPromotionProductById = (id,payload,model) => {
    $.ajax({
        type: 'GET',
        url : '/private/system/ajax/dashboard/promotion/product/getInterview',
        data : {
            id : id
        },
        success : function(data) {
            let html  = '';
            if(data) {
                promotion = data;
                html = `
                <table class="table table-bordered">
                    <thead>
                        <tr >
                            <th style="background-color: #fff">Sản phẩm choose </th>
                            <th style="background-color: #fff">Tối thiểu </th>                   
                            <th style="background-color: #fff">Giới hạn KM</th>
                            <th style="background-color: #fff"></th> 
                            <th style="background-color: #fff">Chiết khấu</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-lg-4">
                                <input type="text"
                                    data-toggle="modal"
                                    href="#modal-form" 
                                    data-model="${model}" 
                                    class="change_keyup_promotion_select2 form-control">
                            </td>
                            <td class="col-lg-2">
                                <input type="number" name="product_quanity_promotion[qualnity]" value="${payload['qualnity']}" class="form-control ">
                            </td>
                            <td class="col-lg-2">
                                <input type="number" name="product_quanity_promotion[price]"  value="${payload['price']}" class="form-control ">
                            </td>
                            <td class="col-lg-2">
                                <input type="text" name="product_quanity_promotion[promotion]"  value="${payload['promotion']}" class="form-control ">
                            </td>
                            <td class="col-lg-2">
                            <select name="product_quanity_promotion[type]" class="form-control  select2" id="">
                                    <option ${payload['type'] == '%' ? 'selected' : '' } value="%">%</option>
                                    <option ${payload['type'] == 'VND' ? 'selected' : '' }  value="VND">VND</option>
                            </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:20px" class="render_while_choose_product_promotion clearfix">       
                    ${Data.loadBadgeProductPromotion(data ,model )}
                </div>`
    
                $('.choose_product_promo').parents('.choose_version_product').siblings('div').html(html);
            }
           
        },
        error : function(error) {
            console.log(error)
        }
       })
   }

   Data.renderTableRowPromotion = () => {
      let row = $('<tr>');
      let option = [
        {'type' : 'text' , 'input_class' : 'form-control' , 'class' : 'col-lg-4' , 'name' : 'promotion_order[amountFrom][]' , 'value' : 0},
        {'type' : 'text' , 'input_class' : 'form-control' , 'class' : 'col-lg-4' , 'name' : 'promotion_order[amountTo][]' , 'value' : 0},
        {'type' : 'text' , 'input_class' : 'form-control' , 'class' : 'col-lg-2' , 'name' : 'promotion_order[amountValue][]' , 'value' : 0},
      ]
      $.each(option , function(index , val) {
        let td = $('<td>').addClass(val?.class);
        let input  = $('<input>').addClass(val?.input_class).attr('name',val?.name).val(val?.value).attr('type',val?.type);
        td.append(input);
        row.append(td);
      })

      let select = $('<select>').addClass('form-control select2').attr('name','promotion_order[amountType][]');
      let optionSelect2 = [
        {'id' : '%' , 'currency' : '%'},{'id' : 'VND' , 'currency' : 'VND'},
      ]
      let tdSelect2 = $('<td>').addClass('col-lg-4');
      $.each(optionSelect2 , function(index , val) {
        let options  = $('<option>').val(val?.id).text(val?.currency);
        select.append(options);
      })
      tdSelect2.append(select)
      row.append(tdSelect2);
      let tdTrash = $('<td>');
      let btn = $('<button>')
      .attr('type','button')
      .addClass('btn btn-secondary delete_trash_promotion')
      .html('<i class="fa-solid fa-trash"></i>');
      tdTrash.append(btn);
      row.append(tdTrash);
      return row;
   }

   Data.RemoveThisPromotionTitle = () => {
     $(document).on('click','.delete_trash_promotion',function() {
        let _this = $(this);
           _this.parents('tr').remove();
     })
   }


   Data.ChooseProductPromo = () => {
        $(document).on('change','.choose_product_promo',function() {
            let _this = $(this);
            let model = _this.val();
            _this.parents('.choose_version_product').siblings('div').html('');
             promotion = [];
            _this.parents('.choose_version_product').siblings('div').html(Data.renderProductQualnitySub(model));
        })
        let product_and_quanity = $('input[name="product_and_quanity"]').val();
        console.log(product_and_quanity)
        if(product_and_quanity.length && typeof product_and_quanity !== null) {
           
            $('.choose_product_promo').val(product_and_quanity).trigger('change');
        }
   }

   Data.renderProductQualnitySub = (model) =>{
    let html = '';
    html = `
        <table class="table table-bordered">
            <thead>
                <tr >
                    <th style="background-color: #fff">Sản phẩm choose </th>
                    <th style="background-color: #fff">Tối thiểu </th>                   
                    <th style="background-color: #fff">Giới hạn KM</th>
                    <th style="background-color: #fff"></th> 
                    <th style="background-color: #fff">Chiết khấu</th> 
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-lg-4">
                        <input type="text"
                            data-toggle="modal"
                            href="#modal-form" 
                            data-model="${model}" 
                            class="change_keyup_promotion_select2 form-control">
                    </td>
                    <td class="col-lg-2">
                        <input type="number" name="product_quanity_promotion[qualnity]" class="form-control ">
                    </td>
                    <td class="col-lg-2">
                        <input type="number" name="product_quanity_promotion[price]" class="form-control ">
                    </td>
                    <td class="col-lg-2">
                        <input type="text" name="product_quanity_promotion[promotion]" class="form-control ">
                    </td>
                    <td class="col-lg-2">
                    <select name="product_quanity_promotion[type]" class="form-control select2" id="">
                            <option value="%">%</option>
                            <option value="VND">VND</option>
                    </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="margin-top:20px" class="render_while_choose_product_promotion clearfix">       
            
        </div>
    `
    return html;
   }

   Data.loadBadgeProductPromotion = (data , model) => {
     let html = '';
     if(data.length > 0) {
        if(model == 'Product') {
            $.each(data , function(index,val) {
                html += `
                <span 
                data-checked="${val.checked}"
                data-id="${val?.id}"
                style="margin:12px 8px;font-size:15px;float: left;padding: 8px;" 
                class="label label-success">
                    <input type="hidden" name="product_id[]" value="${val?.id}"/>
                    <input type="hidden" name="product_variant_id[]" value="${val?.variant_id ?? 0}"/>
                    <input type="hidden" name="model[]" value="${model}"/>
                    ${val.name.slice(0, 20)}...
                    
                    <i style="margin-left:4px" class="fa-solid fa-xmark delete_promotion_product"></i>
                </span>`
             })
        }
        else if(model == 'ProductCateloge') {
            $.each(data , function(index,val) {
                html += `
                <span 
                data-id="${val?.id}"
                style="margin:12px 8px;font-size:15px;float: left;padding: 8px;" 
                class="label label-success">
                <input type="hidden" name="product_id[]" value="${val?.id}"/>
                <input type="hidden" name="product_variant_id[]" value="${val?.variant_id ?? 0}"/>
                <input type="hidden" name="model[]" value="${model}"/>
                    ${val.name.slice(0, 20)}...
                    <i style="margin-left:4px" class="fa-solid fa-xmark delete_promotion_product_cateloge"></i>
                </span>`
             })
        }
       
     }
    
     return html;
   }

    Data.ConvertTheStringSnake = (string) => {
        return string.replace(/\W+/g, " ")
                    .split(/ |\B(?=[A-Z])/)
                    .map(word => word.toLowerCase())
                    .join('_');
    }


   Data.AjaxUsingPromotion = (option, renderOption = []) => {
    $.ajax({
        type: 'GET',
        url: '/private/system/ajax/dashboard/promotion/product',
        data : option,
        beforeSend: function() {
            // setting a timeout
            $('#modal-form').find('.loading').removeClass('hidden');
        },
        success : function(data){
            $('#modal-form').find('.loading').addClass('hidden');;
          if(data) {
            let model = $('.change_keyup_promotion_select2').attr('data-model');
            let render = model == 'Product' ? 
                Data.ObjectProductPromotion(data.data,renderOption) : 
                Data.ObjectCatelogeProductPromotion(data.data,renderOption);
            let links = data?.links;
            $('#modal-form').find('.data_render_product_promotion').html(render);
            $('#modal-form').find('.paganation_render').html(Data.PaginationPromotion(links,model));
          }
          else {
            
            $('#modal-form').find('.data_render_product_promotion').html('<h4 style="margin-top:20px">Không tìm thấy sản phẩm</h4>')
          }
         
        },
        error : function(error) {
             console.log(error)
        },
    })
    }

    Data.ObjectCatelogeProductPromotion = (option,data) => {
        let html = '';  
        let check = [];
        if(data.length > 0) {
            $.each(data,function(key,item) {
                check.push(item?.checked);
            })
        }
        $.each(option , function(index , val) {
            html += `
            <div
             class="data_item_promotion_cateloge" 
            data-id="${val?.id}"
            data-name="${val?.name}"
            style="display:flex;justify-content:space-between;height: 96px;
                  margin: 12px 0 ;border-bottom: 1px solid #ccc;">
                  <div class="data_item" style="width:60%;
                  display:flex;justify-content:space-between;align-items:center">
                      <div style="width:5%">
                          <input type="checkbox" name="product_cateloge_id">
                      </div>
                      <div style="width:20%" class="image_thumbnail">
                          <img width="80" src="${val?.image}" alt="">
                      </div>
                      <div  style="width:70%" class="desc_translate_promotion">
                          <h4>${val?.name}</h4>
                      </div>
                  </div>
              </div>`
         })
         return html;
    }

   Data.setUpMultipleSelect2Search = () => {
        $('.multipleSelect2').select2({
            placeholder: "Nhập 2 từ khóa để tìm kiếm",
        })
   } 

   Data.ObjectProductPromotion = (option , data = []) => {
       let html = '';
       let check = [];
       if(data.length > 0) {
            $.each(data,function(key,item) {
                check.push(item?.checked);
            })
       }
       $.each(option , function(index , val) {
        let variantIdCheck = val?.id+'_'+val?.variant_id ;
        html += `
        <div
         class="data_item_promotion" 
        data-id="${val?.id}"
        data-name="${val?.variant_name_translate}"
        data-variantId="${val?.variant_id}"
        style="display:flex;justify-content:space-between;height: 96px;
              margin: 12px 0 ;border-bottom: 1px solid #ccc;">
              <div class="data_item" style="width:60%;
              display:flex;justify-content:space-between;align-items:center">
                  <div style="width:5%">
                      <input type="checkbox" ${check.includes(variantIdCheck) == true ? 'checked' : ''} class="SendDataPromotion" id="product_${val?.id}_${val?.variant_id}" value="${val?.id}" name="product_id">
                      <input type="hidden" value="${val?.variant_id}" name="product_variant_id">
                  </div>
                  <div style="width:20%" class="image_thumbnail">
                      <img width="80" src="${val?.image}" alt="">
                  </div>
                  <div  style="width:70%" class="desc_translate_promotion">
                      <h4>${val?.variant_name_translate}</h4>
                      <div class="text-info">
                          <span>
                              Mã SP:
                          </span>
                          <p style="display:inline">${val?.sku}</p>
                      </div>
                  </div>
              </div>
              <div class="" style="width:40%;position: relative;top: 37px;">
                  <div class="price" style="text-align: right">
                  <span>${val?.price} VND</span>
                  </div>
                  <div class="image_thumbnail" style="text-align: right">
                      <span>
                          Tồn kho : <p style="display: inline-block" class="text-info">${val?.qualnity}</p>
                      </span>
                      <span style="margin: 0 8px">|</span>
                      <span>
                      Có thể bán : <p style="display: inline-block" class="text-info">${val?.qualnity}</p>
                      </span>
                  </div>
              
              </div>
          </div>`
     })
     
       return html;
   }
   
   Data.OnKeyUpPromotion = () => {
        $(document).on('keyup','.on_keyup_promotion_product',function() {
            let _this = $(this);
            let debounce;
            let model = $('.choose_product_promo').val();
            let option = {
                'keyword' : _this.val(),
                'model' : model
            }   
            if(option?.keyword == '' || option?.keyword.length >= 2) {
                if(debounce)  clearTimeout(debounce);
                debounce = setTimeout(() => {
                    Data.AjaxUsingPromotion(option);
   
               },1000)
            }
        })
   }

   Data.OnchangeOpenModalFindProduct = () => {
      $(document).on('click','.change_keyup_promotion_select2',function() {
            let _this = $(this);
            let model = _this.attr('data-model');
            let option = {
                'model' : model
            }
          
            Data.AjaxUsingPromotion(option,promotion);
            Data.renderProductQualnitySub(model)
            $('.render_while_choose_product_promotion').html(Data.loadBadgeProductPromotion(promotion,model))
      })
   }

   Data.PaginationPromotion = (links = null , model = null) => {
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
            .attr('data-model',model)
            .addClass('page-links')
            .text('<');
            li.append(span)
         }
         else if(val?.label == 'pagination.next') {
            let span = $('<a>')
                        .attr('href',nextTurnPage?.url)
                        .addClass('page-links')
                        .attr('rel','next')
                        .attr('data-id',nextTurnPage?.label)
                        .attr('aria-label','pagination.next')
                        .attr('data-model',model)
                        .text('>');
            li.append(span)
         }
         else if(val?.url) {
            let a = $('<a>').attr('href',val?.url).attr('data-model',model).addClass('page-links').text(val?.label);
            li.append(a);
         }
         ul.append(li);
        })

        let nav = $('<nav>').append(ul);
        return nav;
    }

    }

    Data.getPromotionageAttribute = () => {
        $(document).on('click','.page-links',function(e) {
                e.preventDefault();
                let _this = $(this);
                let  page = (_this.text() == '>' || _this.text() == '<') ? _this.attr('data-id') : _this.text();
                let option = {
                    'model' : _this.attr('data-model'),
                    'page' : page
                }
                console.log(option);
                Data.AjaxUsingPromotion(option);
        })
    }

    Data.CheckedcheckboxProductPromotion = () => {
        $(document).on('click','.data_item_promotion',function(e) {    
            e.preventDefault();
            let _this = $(this);
            let model = $('.choose_product_promo').val();
            let checked = _this.find('input[type=checkbox]').prop('checked');
            let option = {
                'id' :  _this.attr('data-id'),
                'variant_id' : _this.attr('data-variantId'),
                'name' : _this.attr('data-name'),
                'checked' : _this.attr('data-id') + '_' + _this.attr('data-variantId')
            }
            if(checked) {

                promotion =  promotion.filter(ccc => ccc.checked !== option.checked)
                _this.find('input[type=checkbox]').prop('checked',false);
            }
            else {
                promotion.push(option)
                _this.find('input[type=checkbox]').prop('checked',true);
            }
        })
    }
    
    Data.SubmitForRenderBadgeProductPromotion = () => {
        $(document).on('click','.submit_product_promotion',function(e) {
            let _this = $(this);
            let model = $('.choose_product_promo').val();
            if(promotion.length > 0) {
                $('.choose_version_product').siblings('div').html( Data.renderProductQualnitySub(model,promotion));
            }
            $('.render_while_choose_product_promotion').html(Data.loadBadgeProductPromotion(promotion,model))
           
        })
    }  

    Data.DeleteBadgePromotiopnProduct = () => {
        $(document).on('click','.delete_promotion_product',function(e) {
            let _this = $(this);
            let checked = _this.parents('span').attr('data-checked');
            promotion = promotion.filter(item => item.checked !== checked);
            _this.parents('span').remove();
        })
    }
    
    Data.DeleteBadgePromotiopnProductCateloge = () => {
        $(document).on('click','.delete_promotion_product_cateloge',function(e) {
            let _this = $(this);
            let id = _this.parents('span').attr('data-id');
            promotion = promotion.filter(item => item.id !== id);
            _this.parents('span').remove();
        })
    }
    Data.ClickProductCatelogePromotion = () => {
        $(document).on('click','.data_item_promotion_cateloge',function(e) {
            e.preventDefault();
            let _this = $(this);
            let model = $('.choose_product_promo').val();
            let checked = _this.find('input[type=checkbox]').prop('checked');
            let option = {
                'id' :  _this.attr('data-id'),
                'name' : _this.attr('data-name'),
                
            }
            if(checked) {
                 promotion =  promotion.filter(ccc => ccc.id !== option.id)
                _this.find('input[type=checkbox]').prop('checked',false);
            }
            else {
                promotion.push(option)
                _this.find('input[type=checkbox]').prop('checked',true);
            }
        })
    }

    Data.OnchangeChooseCustomerCatelogePromotion = () => {
       $(document).on('change','.onchange_delicate_this',function(e) {
            e.preventDefault();
            let _this = $(this);
            let option = {
                'val' : _this.val(),
                'label' : _this.select2('data')
            }
            $('.wrapperCondition').each(function() {
                let _this_promotion = $(this);
                let Itemclass = _this_promotion.attr('class').split(' ')[2];
                if(option?.val.includes(Itemclass) == false) {
                    _this_promotion.remove();
                }
            })
            for(let i = 0 ; i< option.val.length ; i++) {
                Data.AjaxFoundThePromotionCustomerCateloge(option.val[i] , option.label[i].text);
            }
           
          
       })
       let data = $('input[name="ConditionItemSelected"]').val();
       console.log(data);
       if(data.length && $('.onchange_delicate_this').length && data !== null) {
           let parseData = JSON.parse(data);
           $('.onchange_delicate_this').val(parseData).trigger('change')
       }
    }
    Data.AjaxFoundThePromotionCustomerCateloge = (value , label) => {
        if(!$('.render_attrbute_promotion').find('.'+value).length > 0) {
            let option = {
                'name' : value,
                'label' : label
            }
            $.ajax({
                type: 'GET',
                url : '/private/system/ajax/dashboard/promotion/customer/cateloge',
                data : option,
                success : function(data) {
                    if(data) {
                        $.each(data,function(index,item) {
                            let row = $('<div>').addClass(`wrapperCondition form-group ${option?.name}`).attr('style','margin-top: 8px;padding: 0 15px');
                            let select = Data.RenderSelect2MultipleAttribute(item,option?.name,option?.label);      
                            row.append(select);     
                            $('.render_this_select2').siblings('.render_attrbute_promotion').append(row);                             
                            Data.setUpBackSelect2()                                      
                        })
                    }
                },
                error : function(error) {
                     console.log(error)
                }
            })
        }
      
    }

    Data.SwitchCaseNameSelect2Customer = (name) => {
        let data = '';
        switch(name) {
            case  'Nhân viên chăm sóc và hỗ trợ':
              data = 'staff_take_care';
              break;
            case 'Theo ngày sinh' :
                data =  'customer_birthday';
                break;
            case 'Theo nhóm khách hàng' :
                data =  'customer_group';
                break;
            case 'Theo giới tính' :
                data ='customer_gender';
                break;
        }
        return data;
    }

    Data.RenderSelect2MultipleAttribute = (data , name , type = null) => {
        let row = $('<div>');
        let label = $('<label>').addClass('control-label').text(type);
        row.append(label);
        let select = $('<select>')
            .addClass('select2 form-control')
            .attr('multiple',true)
            .attr('name',name + '[]');
        let conditionItemSelect = $(`input[name="condition_input_${name}"]`);
        let conditionDataArray = [];
        if(conditionItemSelect.length) {
            conditionDataArray = JSON.parse(conditionItemSelect.val());
        }

        $.each(data,function(index ,val) {
            let option = $('<option>'). attr('data-model',val?.name).val(val?.id).text(val?.name);
            select.append(option);
        })          
        select.val(conditionDataArray).trigger('change');                
        row.append(select);
        return row;

   }



    $(document).ready(function() {
        Data.ChooseNoDateForPromotion();
        Data.setUpDateTimePicker();
        Data.ChooseSourceApply();
        Data.ChooseSourceCustomer();
        Data.AddMorePromotion();
        Data.RemoveThisPromotionTitle();
        Data.OnChangeMethodSelectPromotion();
        Data.ChooseProductPromo();
        Data.OnKeyUpPromotion();
        Data.OnchangeOpenModalFindProduct();
        Data.getPromotionageAttribute();
        Data.CheckedcheckboxProductPromotion();
        Data.SubmitForRenderBadgeProductPromotion();
        Data.DeleteBadgePromotiopnProduct();
        Data.DeleteBadgePromotiopnProductCateloge();
        Data.ClickProductCatelogePromotion();
        Data.OnchangeChooseCustomerCatelogePromotion();
        Data.CheckSubmitOrderAmountRange();
        Data.CheckProductPromotionQuanity();
    })

})(jQuery);