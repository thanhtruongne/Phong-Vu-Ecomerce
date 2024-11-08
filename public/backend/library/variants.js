// (function($) {
//     "use strict";
//     var Data = {};

//    Data.setUpVariantsAttribute =() => {
//     $('body').on('click','.label_attribute_variants',function() {
//         let _this = $(this);
//         let price = $('input[name=price]').val();
//         let code = $('input[name=code_product]').val();
//         if(price == '' && code == '') {
//             alert('Vui lòng nhập dữ liệu mã sản phẩm và giá tiền mặc định');return false;
//         }
//         if(_this.children('input[name="accept_variants_attribute"]:checked').length) {
//             $('.label_choose_attribute').removeClass('hidden');
//             $('.vartiant_body').removeClass('hidden');
//             $('.foot_variants').removeClass('hidden');
//         }
//         else {
//             $('.label_choose_attribute').addClass('hidden');
//             $('.vartiant_body').addClass('hidden');
//             $('.foot_variants').addClass('hidden');
//         }
//     })
//    }
   
//    Data.renderAttributeHTML = (attributeCateloges) => {
//     let html = ''; 
//             html = html + '<div class="variant_item" style="height: 60px;margin-bottom:12px">'
//                 html = html + '<div class="col-lg-3">'
//                         html = html + '<select name="attributeCateloge[]" id="" class="vartiant_choose niceSelect" style="width: 100%;margin-bottom:20px">'
//                             html = html + '<option value="0">Chọn thuộc tính</option>'
//                             for(let i = 0 ; i < attributeCateloges.length ; i++) {
//                                 html = html + `<option value="${attributeCateloges[i].id}">${attributeCateloges[i].name}</option>`;
//                             }
//                         html = html + '</select>'
//                 html = html + '</div>'

//                 html = html + '<div class="col-lg-7">'
//                     html = html + '<input type="text" class="form-control" disabled style="height: 42px">'
//                 html = html + '</div>'
//                 html = html + '<div class="col-lg-1">'
//                    html = html +  '<button class="btn btn-danger remove_element_attribute" type="button" style="height:42px">'
//                         html = html +' <i class="fa-solid fa-dumpster"></i>'
//                     html = html + '</button>'
//                 html = html + '</div>'
//             html = html + '</div>';
//      return html;   
//    }

//    Data.addAttrubiteVariants = () => {
//     $('body').on('click','.button_add_attribute_variants',function() {
//         let html = Data.renderAttributeHTML(attributeCateloges);
//         let body = $('.variant_list_render');
//         body.append(html);
//         $('table.variantsTable thead').html('');
//         $('table.variantsTable tbody').html('');
//         //tránh event duplicate lỗi
//         Data.CheckLengthTheAttribute()   
//         Data.DisabledChooseItemAttribute();
//     })
//    }

//    Data.removeAttributeElement = () => {
//      $('body').on('click','.remove_element_attribute',function() {
//         let _this = $(this)
//         _this.parents('.variant_item').remove(); 
//         Data.CheckLengthTheAttribute()    
//         Data.DisabledChooseItemAttribute();
       
//      })
//    }

//    Data.OnChangeNiceSelectCheck = () => {
//        $('body').on('change','.vartiant_choose',function() {
//         //viết hàm choose variant
//         let attributeCatelogeId = $(this).val();
//             if(attributeCatelogeId != 0) {
//                 $(this).parent('.col-lg-3').siblings('.col-lg-7').html( Data.Select2variants(attributeCatelogeId));
//                 $('.selectVariants').each(function() {
//                     Data.getSelect2($(this));
//                 })
//             }
//             else {
//                 $(this).parent('.col-lg-3').siblings('.col-lg-7').html(
//                     ' <input type="text" class="form-control" disabled style="height: 42px">'
//                 );
//             }
//          Data.DisabledChooseItemAttribute();
//          Data.CheckLengthTheAttribute();
//        })
//    }

//    Data.DisabledChooseItemAttribute = () => {
//      let id = [];
//      $('.vartiant_choose').each(function() {
//          let _this = $(this);
//          let selected = _this.find(':selected').val();
//          if( +selected != 0 && +selected != NaN) {
//             id.push(+selected);
//          }   
        
//      })
//         // xóa các disabled trc khi change]
//         $('.vartiant_choose').find('option').removeAttr('disabled');
//         for(let i = 0 ; i < id.length ; i++) {
//             $('.vartiant_choose').find('option[value='+ id[i] +']').prop('disabled',true);
//         }
//         $('.niceSelect').niceSelect('destroy');
//         $('.niceSelect').niceSelect();
//         $('.vartiant_choose').find('option').removeAttr('disabled');
       
//    }

//    Data.CheckLengthTheAttribute = () => {
//     let CompareLength = $('.variant_item').length;
//     if(CompareLength >= attributeCateloges.length) {
//         $('.button_add_attribute_variants').remove();
//     }
//     else if(CompareLength < attributeCateloges.length) {
//         let button =  '<button type="button" class="btn btn-outline-info button_add_attribute_variants"> Thêm biến thể </button>';
//         $('.foot_variants').html(button);
//     }
//    }
//    //sử dụng ajax select2 ajax(remote data);
//    Data.Select2variants = (attributeCatelogeID) => {
//       let html = '<select class="selectVariants variants-'+attributeCatelogeID+' form-control" name="attribute['+attributeCatelogeID+'][]" multiple data-catid='+attributeCatelogeID+'></select>';
//       return html;
//    }
   
//    //set hàm select class select2 khi onchange choose variants
//    Data.getSelect2 = (object) => {
//        let option = {
//           'attributeCatelogeID' : + object.attr('data-catid')
//        };
//        $(object).select2({
//           minimumInputLength: 2,
//           placeholder: 'Nhập khoảng 2 ký tự để tìm kiếm',
//           ajax: {
//             url: 'http://localhost:8000/private/system/ajax/attribute/getAttributeCateloge',
//             dataType: 'json',
//             delay: 250,
//             data: function(params) {
//                 return {
//                     search: params.term,
//                     id : option['attributeCatelogeID']
//                 }
//             },
//             processResults : function(data) {
//                return {
//                 results : $.map(data,function(obj,i) {
//                     return obj;
//                 })
//                }
//             },
//             cache: true
//           }
//        })
//    }
//    Data.OnchangeSelectVariants = () => {
//     $(document).on('change','.selectVariants',function() {
//         //set up các attribute lại với nhau
//         Data.createVariants();
//     })
//    }
 
//    Data.createVariants = () => {
//         let attribute = [];
//         let attributeTitle = [];
//         //lấy các id của attribute
//         //ex : [1 : {1,2,4}]
//         let attributeVariants = [];
//         $('.variant_item').each(function() {
//             let attributeCatelogeID = $(this).find('.vartiant_choose').val();
//             let optionText = $(this).find('.vartiant_choose option:selected').text();
//             let attributeData = $(this).find('.variants-'+attributeCatelogeID).select2('data');
            
//             let attr = [];
//             let attributeIdVariants = [];
//             for(let i = 0 ; i < attributeData?.length ; i++ ) {    
//                 let item = {};
//                 let variants = {};
//                 variants[attributeCatelogeID] =attributeData[i].id;
//                 item[optionText] = attributeData[i].text;
//                 attr.push(item);  
//                 attributeIdVariants.push(variants);
              
//             }
//             attributeTitle.push(optionText);
//             attribute.push(attr);
//             attributeVariants.push(attributeIdVariants);
//         })

//         attribute = attribute.reduce((previous,current) => {
//             //chưa hiểu lắm 
//             //lọc các attribute riêng lẻ ra các phiên bản có 1 attribute riêng
//            return previous.flatMap(item => current.map(val => ({...item , ...val })));
//         })

//         attributeVariants =  attributeVariants.reduce((previous , current) =>  {
//           return previous.flatMap(val => current.map(cur => ({...val ,...cur}) ));
//         });
//         //tạo phẩn thead table
//         Data.createRowTableHead(attributeTitle);
//         let trClass = [];
//         attribute.forEach((val,index) =>  {
//            let row =  Data.createVariantsRow(val,attributeVariants[index]);        
//            //lặp qua các tr class sau đó push vào mảng
//            let classModify = "tr-variant-" + Object.values(attributeVariants[index]).join(', ').replace(/, /g,'-');
          
//            trClass.push(classModify);
    
//            //trường hợp tránh các row trùng nhau từ variants_id và text
//            if(!$("table.variantsTable tbody tr").hasClass(classModify)) {
//             $('table.variantsTable tbody').append(row);
//            }
//         })

//         //render lại các row khi change vairants thêm hay thay dổi
//         $('table.variantsTable tbody tr').each(function() {
//             const row = $(this);
//             const classRow = row.attr('class');
//             //chuyển về thành mảnh
//             if(classRow) {
//                 let arrayRow = classRow.split(' ');
//                 let check = false;
//                 arrayRow.forEach((val , index) => {
//                     if(val === 'variant-row') return;
//                     else if(!trClass.includes(val)) check = true;
//                 })
//                 if(check == true) row.remove();

//             }
//         })
//    }


//    Data.createRowTableHead = (attributeTitle) => {
//        let $thead = $('table.variantsTable thead');
//        let $row = $('<tr>');
//        $row.append($('<td>').text('Hình ảnh'));
//        for(let i = 0 ;i < attributeTitle.length ; i++) {
//            $row.append($('<td>').text(attributeTitle[i]));
//        }
//        $row.append($('<td>').text('Số lượng'));
//        $row.append($('<td>').text('Giá tiền'));
//        $row.append($('<td>').text('Sku'));
//        $row.append($('<td>').text('Code'));
//        $thead.html($row);
      
//        return $thead
//    }

//    Data.createVariantsRow = (arrtributeItem,variantsId) => {
//       let attributeString = Object.values(arrtributeItem).join(', ');
//       let td;
//       let variantAttribute = Object.values(variantsId).join(', ');
//       //chuyển vể dạng 1-2-3 để set vào class tr để dễ filter các bảng
//       let replaceModifyClassTable = variantAttribute.replace(/, /g,'-');
//       let $row = $('<tr>').addClass('variant-row tr-variant-'+ replaceModifyClassTable);
//       td = $('<td>').addClass('variants-album').append(
//          $('<span>').append($('<img>').attr('src','http://localhost:8000/public/ckfinder/userfiles/images/Post/433610459-1399019177654607-8456780266104156853-n-1711118388-214344.jpg').attr('width','80'))
//         )
//         $row.append(td);
//         Object.values(arrtributeItem).forEach((val , index) => {
//             td = $('<td>').text(val);   
//             $row.append(td);
//         })

//       td = $('<td>').addClass('hidden variants');
//       let price = $('input[name=price]').val() ;
//       let code = $('input[name=code_product]').val() + '-' + replaceModifyClassTable;;
//       let option = [
//             {name : 'variants[qualnity][]' , class : 'variants_qualnity'},
//             {name : 'variants[price][]' , class : 'variants_price'},
//             {name : 'variants[sku][]' , class : 'variants_sku'},
//             {name : 'variants[code][]' , class : 'variants_code','regex' :code },
//             {name : 'variants[file_name][]' , class : 'variants_file_name'},
//             {name : 'variants[file_url][]' , class : 'variants_file_url'},
//             {name : 'variants[album][]' , class : 'variants_album'},
//             {name : 'productVariants[name][]' , val : attributeString},
//             {name : 'productVariants[id][]' , val : variantAttribute},
//        ]
    
//       $.each(option , function(index , value) {
//         let input = $('<input>').attr('type','text').attr('name',value.name)?.addClass(value?.class);
//          if(value.regex) {
//             input.val(value.regex)
//         }
//         if(value.val) {
//             input?.val(value.val);
//         }
//         td.append(input);
//       })
//       $row.append(td);
     
//       $row.append($('<td>').addClass('variants-qualnity').text('-'))
//         .append($('<td>').addClass('variants-price').text('-'))
//         .append($('<td>').addClass('variants-sku').text(price))
//         .append($('<td>').addClass('variants-code').text(code));
//       return $row;
//    }

//    Data.createAlbumVariants = () => {
//     $('.ckfinder').on('click',function() {
//       let _this = $(this);
//       let render = _this.parents('.font_check_variants_image').siblings('.upload_list_variants_image');
//       let parent = _this.parents('.font_check_variants_image');
//       Data.setupCkfinder(parent , render); 
//     })
//    }

//    Data.setupCkfinder = (input = null,image = null) => {
//         CKFinder.popup({
//         chooseFiles: true,
//         onInit : function(finder) {
//             finder.on('files:choose', function( evt ) {          
//                     var files = evt.data.files;
//                     var html = '';
//                     files.forEach( function( file, i ) {
//                         html += `
//                         <li class="list_item" style="float:left;margin: 0 12px 12px 12px">
//                             <img height="120" src="${file.getUrl()}" width="150" alt="">
//                             <input type="hidden" name="variantsalbum[]" value="${file.getUrl()}"/>
//                             <button type="button" class="delete_item_trash" >
//                                 <i class="fa-solid fa-trash"></i>
//                             </button >
//                         </li>
//                         `
//                     });
//                     input.addClass('hidden');
//                     image.removeClass('hidden');
//                     $('#sortable_books').sortable();
//                     image.html(html);  
                   
                
//             } );
//             finder.on( 'file:choose:resizedImage', function( evt ) {
//                 // document.getElementById( 'url' ).value = evt.data.resizedUrl;
//             } );
//         }
//         });
//    }


//    Data.StoreDataVariants = (variants = null ) => {
    
//      let html = '';
//      let imageArray =  variants.variants_album == "" ? [] : variants?.variants_album?.split(',') ;
//      console.log(imageArray)
//      let price = $('input[name=price]').val();
//       let code = $('input[name=code]').val();
//      let LisetImage = Data.updateImageVariantsTable(imageArray);
//       html = `
//       <tr class="check_length_variants">
//         <td colspan="6" style="border: none;padding-top:20px">
//             <div style="display:flex;justify-content: space-between">
//                 <div >
//                     <h3 class="text-success">DANH SÁCH CÁC PHIÊN BẢN SẢN PHẨM</h3> 
//                 </div>
//                 <div>
//                     <button class="btn btn-danger remove_variants_data" style="margin-right: 8px">Hủy</button>
//                     <button type="button" class="btn btn-primary saveVariantsData">Lưu dữ liệu</button>
//                 </div>
//             </div>       
//             <div class="render_store_data_variants">
//                 <div class="updateVariants" style="font-size:16px;margin:2rem 0;">
//                     <div class="font_title_album text-center">
//                         <div class="font_check_variants_image ${(imageArray?.length == 0) ? '' : 'hidden'} ">
//                             <img class="ckfinder" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
//                             <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
//                         </div>
//                         <div class="upload_list_variants_image ${(imageArray?.length) ? '' : 'hidden'} clearfix" style="list-style-type: none" id="sortable_books">
//                               ${LisetImage}
//                         </div>
//                     </div>
//                     <div style="margin-top: 20px">
//                         <div class="row">
//                                 <div class="col-lg-2">
//                                 <label  for="" class=""style="font-size: 14px;font-weight:500">QL tồn kho</label>
//                                 <input type="checkbox" ${variants?.variants_qualnity ? 'checked' : ''} class="js-switch" name="inventory" data-target="variantsInventory"/>
//                             </div>
//                             <div class="col-lg-10">
//                                 <div class="row">
//                                         <div class="col-lg-3">
//                                         <label style="font-size: 14px;font-weight:500" for="">Số lượng</label>
//                                         <input type="number" min="0" ${variants?.variants_qualnity ? '' : 'disabled' } value="${variants?.variants_qualnity }" class="form-control disabled" name="qualnity" data-target="variantsQualnity"/>
//                                         </div>
//                                         <div class="col-lg-3">
//                                         <label style="font-size: 14px;font-weight:500" for="">SKU</label>
//                                         <input type="text" class="form-control" value="${variants?.variants_sku}" name="sku" data-target="variantsSKU"/>
//                                         </div>
//                                         <div class="col-lg-3">
//                                         <label style="font-size: 14px;font-weight:500" for="">Giá</label>
//                                         <input type="text" class="form-control" value="${variants?.variants_price == '' ? price : variants?.variants_price}" value="0" name="price" min="0" data-target="variantsPrice"/>
//                                         </div>
//                                         <div class="col-lg-3">
//                                         <label style="font-size: 14px;font-weight:500" for="">Barcode</label>
//                                         <input type="text" class="form-control" value="${variants?.variants_code  == '' ? code : variants?.variants_code }" name="code" data-target="variantsQualnity"/>
//                                         </div>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                     <div style="margin-top: 20px">
//                         <div class="row">
//                                 <div class="col-lg-2">
//                                 <label  for="" class=""style="font-size: 14px;font-weight:500">QL file</label>
//                                 <input type="checkbox" ${variants?.variants_file_name  ? 'checked' : ''} class="js-switch" name="file" data-target="file"/>
//                             </div>
//                             <div class="col-lg-10">
//                                     <div class="row">
//                                             <div class="col-lg-5">
//                                         <label style="font-size: 14px;font-weight:500" for="">Tên file</label>
//                                             <input type="text" ${variants?.variants_file_name ? '' : 'disabled'} value="${variants?.variants_file_name}" class="form-control disabled" name="variants_file_name" data-target="variantsFileName"/>
//                                             </div>
//                                             <div class="col-lg-5">
//                                         <label style="font-size: 14px;font-weight:500" for="">Đường dẫn</label>
//                                             <input type="text" ${variants?.variants_file_url ? '' : 'disabled'}  value="${variants?.variants_file_url}" class="form-control disabled" name="variants_file_url" data-target="variantsFileURL"/>
//                                             </div>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </td>
//     </tr>
//       `
//         return html;
//    }

//    Data.RemoveVariantsAlbum = () => {
//     $('body').on('click','.delete_item_trash',function() {
//         let _this = $(this);
//         _this.parents('.list_item').remove();
//         let parentsWrapper = $('#sortable_books li.list_item').length;
//         if(parentsWrapper == 0) {
//             $('.font_check_variants_image').removeClass('hidden');
//         }
//         else {
//             $('.font_check_variants_image').addClass('hidden');
//         }
//     })
//    }

//    Data.ChooseJsSwitchquery = () => {
//        $('.js-switch').on('change',function() {
//            let _this = $(this);
//            let isChecked = _this.prop('checked');
//            if(isChecked == true)  {
//                 _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').removeAttr('disabled');
//            }
//            else {
//              _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').attr('disabled',true);
//            }
//        })
//    }
   
//    Data.SetupJsSwitchquery = () => {
//         var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

//         elems.forEach(function(html) {
//             var switchery = new Switchery(html);
//         });
//    }

//    Data.cancelDataVariants = () => {
//         $(document).on('click','.remove_variants_data',function(e) {
//             $(this).parents('div .check_length_variants').remove();
//         })
//    }
   
//    Data.SubmitDataCreateVariants = () => {
//      $(document).on('click','.saveVariantsData',function(e) {
//         let variants = {
//             'qualnity' : $('input[name="qualnity"]').val() ?? '',
//             'sku' : $('input[name="sku"]').val() ?? '',
//             'price' : $('input[name="price"]').val() ?? '',
//             'code' : $('input[name="code"]').val() ?? '',
//             'file_name' : $('input[name="variants_file_name"]').val() ?? '',
//             'file_url' : $('input[name="variants_file_url"]').val() ?? '',
//             'album' : $('input[name="variantsalbum[]"]').map(function() {
//                 return $(this).val();
//             }).get(),
//         }
//         console.log(variants)
//         $.each(variants,function(index , val) {
//             $('.check_length_variants').prev().find('.variants_'+index).val(val);
//         })
//         Data.updateVartiantsTable(variants);
//         Data.removeUpdateData();
//         e.preventDefault();
//      })
//    }

//    Data.updateVartiantsTable = (variants) => {
//         let option =  {
//             'qualnity' : variants.qualnity,
//             'sku' : variants.sku,
//             'price' : variants.price,
//             'code' : variants.code
//         }
//         $.each(option,function(index ,val) {
//             $('.check_length_variants').prev().find('td.variants-'+index).html(val);
//         })
//         console.log(variants.album);
//         $('.check_length_variants').prev().find('td.variants-album').find('span img').attr('src',variants.album[0])
//    }

//    Data.removeUpdateData = () => {
//         $('.check_length_variants').remove();
//    }

//    Data.showDataVariantsAfterCreate = () => {
//         $(document).on('click','.variant-row',function(e) {
//             let _this = $(this);
//             let variants = {};
//             _this.find('td.variants input[type=text][class^="variants_"]').each(function() {
//                let className = $(this).attr('class');
//                variants[className] = $(this).val();
//             });
//             if($('.check_length_variants').length === 0) {
//                 _this.after(Data.StoreDataVariants(variants));
//                 Data.SetupJsSwitchquery();
//                 Data.createAlbumVariants();
//                 $('#sortable_books').sortable();
//                 Data.ChooseJsSwitchquery();
               
//             }
            
//         })
//    }

//    Data.updateImageVariantsTable = (album) => {
//     let html = '';
//     console.log(album);
//       if(album?.length && album != 0) {
//            for(let i = 0 ; i < album?.length ; i++) {
//                 html = html + '<li class="list_item" style="float:left;margin: 0 12px 12px 12px">'
//                 html = html + '<img height="120" src="'+ album[i] +'" width="150" alt="">'
//                 html = html + '<input type="hidden" name="variantsalbum[]" value="'+ album[i] +'"/>'
//                 html = html + '<button type="button" class="delete_item_trash" >'
//                 html = html + '<i class="fa-solid fa-trash"></i>'
//                 html = html + '</button >'
//                 html = html + '</li>'
//            }
//            return html;
//       }
    
//    }

//    Data.setUpSelect2WhileUpdate = (callback) => {
//         if($('.selectVariants').length) {
//             let count = $('.selectVariants').length;
//            $('.selectVariants').each(function(index , val) {
//               let _this = $(this);
//               let attributeTitle = JSON.parse(atob(attribute));           
//               let attributeCatelogeId = _this.attr('data-catid')
//               console.log(attributeTitle,$attributeCatelogeId)
//             //   console.log(JSON.parse(JSON.parse(atob(attribute))), attributeCatelogeId)
//             //xử lý data bằng ajax
//               if(attribute != '') {
//                 $.get('http://localhost:8000/private/system/ajax/attribute/GetAttribute',{
//                     attribute : attributeTitle,
//                     attributeCatelogeId : attributeCatelogeId
//                 },
//                     function(data) {
//                         console.log(data);
//                         if(data.items != 'undefined' && data.items.length) {
//                             for(let i = 0 ; i < data.items.length ; i++) {
//                                 // tạo ra các option bàng new Option sau đó trigger change để change select2
//                                 var option = new Option(data.items[i]?.name,data.items[i]?.id,true,true);
//                                 _this.append(option).trigger('change');                
//                             }                    
//                         }
//                         //sử dụng phần call back để render lại các bảng table choose khi validate
//                         if(--count === 0 && callback) {
//                             //khi tru72 các select2 thành callback
//                             callback();
//                         }
//                     })
//               }
//               Data.getSelect2(_this) 
//             })        
//         }
//     }

//    Data.ProductVariants = () => {
//       let variants = JSON.parse(atob(variant));
//       console.log(variants);
     
//       $('.variant-row').each(function(index , val) {
        
//         let _this = $(this);
//         let option = [
//             {name : 'variants[qualnity][]' , class: 'variants_qualnity',value : variants.qualnity[index] },
//             {name : 'variants[price][]' , class: 'variants_price',value : variants.price[index] },
//             {name : 'variants[sku][]' , class: 'variants_sku',value : variants.sku[index] },
//             {name : 'variants[code][]' , class: 'variants_code',value : variants.code[index] },
//             {name : 'variants[album][]' , class: 'variants_album',value : variants.album[index] },
//             {name : 'variants[file_name][]' , class: 'variants_file_name',value : variants.file_name[index] },
//             {name : 'variants[file_url][]' , class: 'variants_file_url',value : variants.file_url[index] },
//         ]

//         for(let i = 0 ; i < option.length ; i++) {
//            _this.find('.' + option[i].class).val(option[i].value);
//         }
//         let album = variants.album[index].split(',');
//         _this.find('td.variants-album').find('span img').attr('src', album.length > 0 ? album[0] : 
//         'http://localhost:8000/public/ckfinder/userfiles/images/Post/433610459-1399019177654607-8456780266104156853-n-1711118388-214344.jpg');
//         _this.find('td.variants-qualnity').html(variants.qualnity[index]);
//         _this.find('td.variants-price').html(variants.price[index]);
//         _this.find('td.variants-sku').html(variants.sku[index]);
//         _this.find('td.variants-code').html(variants.code[index]);
//       })
//    }





//    $(document).ready(function() {
//         Data.setUpVariantsAttribute();
//         Data.addAttrubiteVariants();
//         Data.OnChangeNiceSelectCheck();
//         Data.removeAttributeElement();
//         Data.CheckLengthTheAttribute();
//         Data.OnchangeSelectVariants();
//         Data.createAlbumVariants();
//         Data.RemoveVariantsAlbum();
//         Data.ChooseJsSwitchquery();
//         Data.cancelDataVariants();
//         Data.SubmitDataCreateVariants();
//         Data.showDataVariantsAfterCreate();
//         Data.setUpSelect2WhileUpdate( 
//             () => {
//                 Data.ProductVariants();
//             }
//         );
//    })

// })(jQuery);

(function($) {
    "use strict";
    var Data = {};

   Data.setUpVariantsAttribute =() => {
    $('body').on('click','.label_attribute_variants',function() {
        let _this = $(this);
        let price = $('input[name=price]').val();
        let code = $('input[name=code_product]').val();
        if(price == '' && code == '') {
            alert('Vui lòng nhập dữ liệu mã sản phẩm và giá tiền mặc định');return false;
        }
        if(_this.children('input[name="accept_variants_attribute"]:checked').length) {
            $('.label_choose_attribute').removeClass('hidden');
            $('.vartiant_body').removeClass('hidden');
            $('.foot_variants').removeClass('hidden');
        }
        else {
            $('.label_choose_attribute').addClass('hidden');
            $('.vartiant_body').addClass('hidden');
            $('.foot_variants').addClass('hidden');
        }
    })
   }
   
   Data.renderAttributeHTML = (attributeCateloges) => {
    let html = ''; 
            html = html + '<div class="variant_item" style="height: 60px;margin-bottom:12px">'
                html = html + '<div class="col-lg-3">'
                        html = html + '<select name="attributeCateloge[]" id="" class="vartiant_choose niceSelect" style="width: 100%;margin-bottom:20px">'
                            html = html + '<option value="0">Chọn thuộc tính</option>'
                            for(let i = 0 ; i < attributeCateloges.length ; i++) {
                                html = html + `<option value="${attributeCateloges[i].id}">${attributeCateloges[i].name}</option>`;
                            }
                        html = html + '</select>'
                html = html + '</div>'

                html = html + '<div class="col-lg-7">'
                    html = html + '<input type="text" class="form-control" disabled style="height: 42px">'
                html = html + '</div>'
                html = html + '<div class="col-lg-1">'
                   html = html +  '<button class="btn btn-danger remove_element_attribute" type="button" style="height:42px">'
                        html = html +' <i class="fa-solid fa-dumpster"></i>'
                    html = html + '</button>'
                html = html + '</div>'
            html = html + '</div>';
     return html;   
   }

   Data.addAttrubiteVariants = () => {
    $('body').on('click','.button_add_attribute_variants',function() {
        let html = Data.renderAttributeHTML(attributeCateloges);
        let body = $('.variant_list_render');
        body.append(html);
        $('table.variantsTable thead').html('');
        $('table.variantsTable tbody').html('');
        //tránh event duplicate lỗi
        Data.CheckLengthTheAttribute()   
        Data.DisabledChooseItemAttribute();
    })
   }

   Data.removeAttributeElement = () => {
     $('body').on('click','.remove_element_attribute',function() {
        let _this = $(this)
        _this.parents('.variant_item').remove(); 
        Data.CheckLengthTheAttribute()    
        Data.DisabledChooseItemAttribute();
       
     })
   }

   Data.OnChangeNiceSelectCheck = () => {
       $('body').on('change','.vartiant_choose',function() {
        //viết hàm choose variant
        let attributeCatelogeId = $(this).val();
        if(attributeCatelogeId != 0) {
            $(this).parent('.col-lg-3').siblings('.col-lg-7').html( Data.Select2variants(attributeCatelogeId));
            $('.selectVariants').each(function() {
                Data.getSelect2($(this));
            })
        }
        else {
            $(this).parent('.col-lg-3').siblings('.col-lg-7').html(
                ' <input type="text" class="form-control" disabled style="height: 42px">'
            );
        }
         Data.DisabledChooseItemAttribute();
         Data.CheckLengthTheAttribute();
       })
   }

   Data.DisabledChooseItemAttribute = () => {
     let id = [];
     $('.vartiant_choose').each(function() {
         let _this = $(this);
         let selected = _this.find(':selected').val();
         if( +selected != 0 && +selected != NaN) {
            id.push(+selected);
         }   
        
     })
        // xóa các disabled trc khi change]
        $('.vartiant_choose').find('option').removeAttr('disabled');
        for(let i = 0 ; i < id.length ; i++) {
            $('.vartiant_choose').find('option[value='+ id[i] +']').prop('disabled',true);
        }
        $('.niceSelect').niceSelect('destroy');
        $('.niceSelect').niceSelect();
        $('.vartiant_choose').find('option').removeAttr('disabled');
       
   }

   Data.CheckLengthTheAttribute = () => {
    let CompareLength = $('.variant_item').length;
    if(CompareLength >= attributeCateloges.length) {
        $('.button_add_attribute_variants').remove();
    }
    else if(CompareLength < attributeCateloges.length) {
        let button =  '<button type="button" class="btn btn-outline-info button_add_attribute_variants"> Thêm biến thể </button>';
        $('.foot_variants').html(button);
    }
   }
   //sử dụng ajax select2 ajax(remote data);
   Data.Select2variants = (attributeCatelogeID) => {
      let html = '<select class="selectVariants variants-'+attributeCatelogeID+' form-control" name="attribute['+attributeCatelogeID+'][]" multiple data-catid='+attributeCatelogeID+'></select>';
      return html;
   }
   
   //set hàm select class select2 khi onchange choose variants
   Data.getSelect2 = (object) => {
       let option = {
          'attributeCatelogeID' : + object.attr('data-catid')
       };
       $(object).select2({
          minimumInputLength: 2,
          placeholder: 'Nhập khoảng 2 ký tự để tìm kiếm',
          ajax: {
            url: 'http://localhost:8000/private/system/ajax/attribute/getAttributeCateloge',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    id : option['attributeCatelogeID']
                }
            },
            processResults : function(data) {
               return {
                results : $.map(data,function(obj,i) {
                    return obj;
                })
               }
            },
            cache: true
          }
       })
   }
   Data.OnchangeSelectVariants = () => {
    $(document).on('change','.selectVariants',function() {
        //set up các attribute lại với nhau
        Data.createVariants();
    })
   }
 
   Data.createVariants = () => {
        let attribute = [];
        let attributeTitle = [];
        //lấy các id của attribute
        //ex : [1 : {1,2,4}]
        let attributeVariants = [];
        $('.variant_item').each(function() {
            let attributeCatelogeID = $(this).find('.vartiant_choose').val();
            let optionText = $(this).find('.vartiant_choose option:selected').text();
            let attributeData = $(this).find('.variants-'+attributeCatelogeID).select2('data');
            
            let attr = [];
            let attributeIdVariants = [];
            for(let i = 0 ; i < attributeData?.length ; i++ ) {    
                let item = {};
                let variants = {};
                variants[attributeCatelogeID] =attributeData[i].id;
                item[optionText] = attributeData[i].text;
                attr.push(item);  
                attributeIdVariants.push(variants);
              
            }
            attributeTitle.push(optionText);
            attribute.push(attr);
            attributeVariants.push(attributeIdVariants);
        })

        attribute = attribute.reduce((previous,current) => {
            //chưa hiểu lắm 
            //lọc các attribute riêng lẻ ra các phiên bản có 1 attribute riêng
           return previous.flatMap(item => current.map(val => ({...item , ...val })));
        })

        attributeVariants =  attributeVariants.reduce((previous , current) =>  {
          return previous.flatMap(val => current.map(cur => ({...val ,...cur}) ));
        });
        //tạo phẩn thead table
        Data.createRowTableHead(attributeTitle);
        let trClass = [];
        attribute.forEach((val,index) =>  {
           let row =  Data.createVariantsRow(val,attributeVariants[index]);        
           //lặp qua các tr class sau đó push vào mảng
           let classModify = "tr-variant-" + Object.values(attributeVariants[index]).join(', ').replace(/, /g,'-');
          
           trClass.push(classModify);
    
           //trường hợp tránh các row trùng nhau từ variants_id và text
           if(!$("table.variantsTable tbody tr").hasClass(classModify)) {
            $('table.variantsTable tbody').append(row);
           }
        })

        //render lại các row khi change vairants thêm hay thay dổi
        $('table.variantsTable tbody tr').each(function() {
            const row = $(this);
            const classRow = row.attr('class');
            //chuyển về thành mảnh
            if(classRow) {
                let arrayRow = classRow.split(' ');
                let check = false;
                arrayRow.forEach((val , index) => {
                    if(val === 'variant-row') return;
                    else if(!trClass.includes(val)) check = true;
                })
                if(check == true) row.remove();

            }
        })
   }


   Data.createRowTableHead = (attributeTitle) => {
       let $thead = $('table.variantsTable thead');
       let $row = $('<tr>');
       $row.append($('<td>').text('Hình ảnh'));
       for(let i = 0 ;i < attributeTitle.length ; i++) {
           $row.append($('<td>').text(attributeTitle[i]));
       }
       $row.append($('<td>').text('Số lượng'));
       $row.append($('<td>').text('Giá tiền'));
       $row.append($('<td>').text('Sku'));
       $row.append($('<td>').text('Code'));
       $thead.html($row);
      
       return $thead
   }

   Data.createVariantsRow = (arrtributeItem,variantsId) => {
      let attributeString = Object.values(arrtributeItem).join(', ');
      let td;
      let variantAttribute = Object.values(variantsId).join(', ');
      //chuyển vể dạng 1-2-3 để set vào class tr để dễ filter các bảng
      let replaceModifyClassTable = variantAttribute.replace(/, /g,'-');
      let $row = $('<tr>').addClass('variant-row tr-variant-'+ replaceModifyClassTable);
      td = $('<td>').addClass('variants-album').append(
         $('<span>').append($('<img>').attr('src','http://localhost:8000/public/ckfinder/userfiles/images/Post/433610459-1399019177654607-8456780266104156853-n-1711118388-214344.jpg').attr('width','80'))
        )
        $row.append(td);
        Object.values(arrtributeItem).forEach((val , index) => {
            td = $('<td>').text(val);   
            $row.append(td);
        })

      td = $('<td>').addClass('hidden variants');
      let price = $('input[name=price]').val() ;
      let code = $('input[name=code_product]').val() + '-' + replaceModifyClassTable;;
      let option = [
            {name : 'variants[qualnity][]' , class : 'variants_qualnity'},
            {name : 'variants[price][]' , class : 'variants_price'},
            {name : 'variants[sku][]' , class : 'variants_sku'},
            {name : 'variants[code][]' , class : 'variants_code','regex' :code },
            {name : 'variants[file_name][]' , class : 'variants_file_name'},
            {name : 'variants[file_url][]' , class : 'variants_file_url'},
            {name : 'variants[album][]' , class : 'variants_album'},
            {name : 'productVariants[name][]' , val : attributeString},
            {name : 'productVariants[id][]' , val : variantAttribute},
       ]
    
      $.each(option , function(index , value) {
        let input = $('<input>').attr('type','text').attr('name',value.name)?.addClass(value?.class);
         if(value.regex) {
            input.val(value.regex)
        }
        if(value.val) {
            input?.val(value.val);
        }
        td.append(input);
      })
      $row.append(td);
     
      $row.append($('<td>').addClass('variants-qualnity').text('-'))
        .append($('<td>').addClass('variants-price').text('-'))
        .append($('<td>').addClass('variants-sku').text(price))
        .append($('<td>').addClass('variants-code').text(code));
      return $row;
   }

   Data.createAlbumVariants = () => {
    $('.ckfinder').on('click',function() {
      let _this = $(this);
      let render = _this.parents('.font_check_variants_image').siblings('.upload_list_variants_image');
      let parent = _this.parents('.font_check_variants_image');
      Data.setupCkfinder(parent , render); 
    })
   }

   Data.setupCkfinder = (input = null,image = null) => {
        CKFinder.popup({
        chooseFiles: true,
        onInit : function(finder) {
            finder.on('files:choose', function( evt ) {          
                    var files = evt.data.files;
                    var html = '';
                    files.forEach( function( file, i ) {
                        html += `
                        <li class="list_item" style="float:left;margin: 0 12px 12px 12px">
                            <img height="120" src="${file.getUrl()}" width="150" alt="">
                            <input type="hidden" name="variantsalbum[]" value="${file.getUrl()}"/>
                            <button type="button" class="delete_item_trash" >
                                <i class="fa-solid fa-trash"></i>
                            </button >
                        </li>
                        `
                    });
                    input.addClass('hidden');
                    image.removeClass('hidden');
                    $('#sortable_books').sortable();
                    image.html(html);  
                   
                
            } );
            finder.on( 'file:choose:resizedImage', function( evt ) {
                // document.getElementById( 'url' ).value = evt.data.resizedUrl;
            } );
        }
        });
   }


   Data.StoreDataVariants = (variants = null ) => {
    
     let html = '';
     let imageArray =  variants.variants_album == "" ? [] : variants?.variants_album?.split(',') ;
     console.log(imageArray)
     let price = $('input[name=price]').val();
      let code = $('input[name=code]').val();
     let LisetImage = Data.updateImageVariantsTable(imageArray);
      html = `
      <tr class="check_length_variants">
        <td colspan="6" style="border: none;padding-top:20px">
            <div style="display:flex;justify-content: space-between">
                <div >
                    <h3 class="text-success">DANH SÁCH CÁC PHIÊN BẢN SẢN PHẨM</h3> 
                </div>
                <div>
                    <button class="btn btn-danger remove_variants_data" style="margin-right: 8px">Hủy</button>
                    <button type="button" class="btn btn-primary saveVariantsData">Lưu dữ liệu</button>
                </div>
            </div>       
            <div class="render_store_data_variants">
                <div class="updateVariants" style="font-size:16px;margin:2rem 0;">
                    <div class="font_title_album text-center">
                        <div class="font_check_variants_image ${(imageArray?.length == 0) ? '' : 'hidden'} ">
                            <img class="ckfinder" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                            <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
                        </div>
                        <div class="upload_list_variants_image ${(imageArray?.length) ? '' : 'hidden'} clearfix" style="list-style-type: none" id="sortable_books">
                              ${LisetImage}
                        </div>
                    </div>
                    <div style="margin-top: 20px">
                        <div class="row">
                                <div class="col-lg-2">
                                <label  for="" class=""style="font-size: 14px;font-weight:500">QL tồn kho</label>
                                <input type="checkbox" ${variants?.variants_qualnity ? 'checked' : ''} class="js-switch" name="inventory" data-target="variantsInventory"/>
                            </div>
                            <div class="col-lg-10">
                                <div class="row">
                                        <div class="col-lg-3">
                                        <label style="font-size: 14px;font-weight:500" for="">Số lượng</label>
                                        <input type="number" min="0" ${variants?.variants_qualnity ? '' : 'disabled' } value="${variants?.variants_qualnity }" class="form-control disabled" name="qualnity" data-target="variantsQualnity"/>
                                        </div>
                                        <div class="col-lg-3">
                                        <label style="font-size: 14px;font-weight:500" for="">SKU</label>
                                        <input type="text" class="form-control" value="${variants?.variants_sku}" name="sku" data-target="variantsSKU"/>
                                        </div>
                                        <div class="col-lg-3">
                                        <label style="font-size: 14px;font-weight:500" for="">Giá</label>
                                        <input type="text" class="form-control" value="${variants?.variants_price == '' ? price : variants?.variants_price}" value="0" name="price" min="0" data-target="variantsPrice"/>
                                        </div>
                                        <div class="col-lg-3">
                                        <label style="font-size: 14px;font-weight:500" for="">Barcode</label>
                                        <input type="text" class="form-control" value="${variants?.variants_code  == '' ? code : variants?.variants_code }" name="code" data-target="variantsQualnity"/>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 20px">
                        <div class="row">
                                <div class="col-lg-2">
                                <label  for="" class=""style="font-size: 14px;font-weight:500">QL file</label>
                                <input type="checkbox" ${variants?.variants_file_name  ? 'checked' : ''} class="js-switch" name="file" data-target="file"/>
                            </div>
                            <div class="col-lg-10">
                                    <div class="row">
                                            <div class="col-lg-5">
                                        <label style="font-size: 14px;font-weight:500" for="">Tên file</label>
                                            <input type="text" ${variants?.variants_file_name ? '' : 'disabled'} value="${variants?.variants_file_name}" class="form-control disabled" name="variants_file_name" data-target="variantsFileName"/>
                                            </div>
                                            <div class="col-lg-5">
                                        <label style="font-size: 14px;font-weight:500" for="">Đường dẫn</label>
                                            <input type="text" ${variants?.variants_file_url ? '' : 'disabled'}  value="${variants?.variants_file_url}" class="form-control disabled" name="variants_file_url" data-target="variantsFileURL"/>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
      `
        return html;
   }

   Data.RemoveVariantsAlbum = () => {
    $('body').on('click','.delete_item_trash',function() {
        let _this = $(this);
        _this.parents('.list_item').remove();
        let parentsWrapper = $('#sortable_books li.list_item').length;
        if(parentsWrapper == 0) {
            $('.font_check_variants_image').removeClass('hidden');
        }
        else {
            $('.font_check_variants_image').addClass('hidden');
        }
    })
   }

   Data.ChooseJsSwitchquery = () => {
       $('.js-switch').on('change',function() {
           let _this = $(this);
           let isChecked = _this.prop('checked');
           if(isChecked == true)  {
                _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').removeAttr('disabled');
           }
           else {
             _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').attr('disabled',true);
           }
       })
   }
   
   Data.SetupJsSwitchquery = () => {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
   }

   Data.cancelDataVariants = () => {
        $(document).on('click','.remove_variants_data',function(e) {
            $(this).parents('div .check_length_variants').remove();
        })
   }
   
   Data.SubmitDataCreateVariants = () => {
     $(document).on('click','.saveVariantsData',function(e) {
        let variants = {
            'qualnity' : $('input[name="qualnity"]').val() ?? '',
            'sku' : $('input[name="sku"]').val() ?? '',
            'price' : $('input[name="price"]').val() ?? '',
            'code' : $('input[name="code"]').val() ?? '',
            'file_name' : $('input[name="variants_file_name"]').val() ?? '',
            'file_url' : $('input[name="variants_file_url"]').val() ?? '',
            'album' : $('input[name="variantsalbum[]"]').map(function() {
                return $(this).val();
            }).get(),
        }
        console.log(variants)
        $.each(variants,function(index , val) {
            $('.check_length_variants').prev().find('.variants_'+index).val(val);
        })
        Data.updateVartiantsTable(variants);
        Data.removeUpdateData();
        e.preventDefault();
     })
   }

   Data.updateVartiantsTable = (variants) => {
        let option =  {
            'qualnity' : variants.qualnity,
            'sku' : variants.sku,
            'price' : variants.price,
            'code' : variants.code
        }
        $.each(option,function(index ,val) {
            $('.check_length_variants').prev().find('td.variants-'+index).html(val);
        })
        console.log(variants.album);
        $('.check_length_variants').prev().find('td.variants-album').find('span img').attr('src',variants.album[0])
   }

   Data.removeUpdateData = () => {
        $('.check_length_variants').remove();
   }

   Data.showDataVariantsAfterCreate = () => {
        $(document).on('click','.variant-row',function(e) {
            let _this = $(this);
            let variants = {};
            _this.find('td.variants input[type=text][class^="variants_"]').each(function() {
               let className = $(this).attr('class');
               variants[className] = $(this).val();
            });
            if($('.check_length_variants').length === 0) {
                _this.after(Data.StoreDataVariants(variants));
                Data.SetupJsSwitchquery();
                Data.createAlbumVariants();
                $('#sortable_books').sortable();
                Data.ChooseJsSwitchquery();
               
            }
            
        })
   }

   Data.updateImageVariantsTable = (album) => {
    let html = '';
    console.log(album);
      if(album?.length && album != 0) {
           for(let i = 0 ; i < album?.length ; i++) {
                html = html + '<li class="list_item" style="float:left;margin: 0 12px 12px 12px">'
                html = html + '<img height="120" src="'+ album[i] +'" width="150" alt="">'
                html = html + '<input type="hidden" name="variantsalbum[]" value="'+ album[i] +'"/>'
                html = html + '<button type="button" class="delete_item_trash" >'
                html = html + '<i class="fa-solid fa-trash"></i>'
                html = html + '</button >'
                html = html + '</li>'
           }
           return html;
      }
    
   }

   Data.setUpSelect2WhileUpdate = (callback) => {
        if($('.selectVariants').length) {
            let count = $('.selectVariants').length;
           $('.selectVariants').each(function(index , val) {
              let _this = $(this);
              let attributeTitle = JSON.parse(atob(attribute));           
              let attributeCatelogeId = _this.attr('data-catid')
            //   console.log(JSON.parse(JSON.parse(atob(attribute))), attributeCatelogeId)
            //xử lý data bằng ajax
              if(attribute != '') {
                $.get('http://localhost:8000/private/system/ajax/attribute/GetAttribute',{
                    attribute : attributeTitle,
                    attributeCatelogeId : attributeCatelogeId
                },
                    function(data) {
                        console.log(data);
                        if(data.items != 'undefined' && data.items.length) {
                            for(let i = 0 ; i < data.items.length ; i++) {
                                // tạo ra các option bàng new Option sau đó trigger change để change select2
                                var option = new Option(data.items[i]?.name,data.items[i]?.id,true,true);
                                _this.append(option).trigger('change');                
                            }                    
                        }
                        //sử dụng phần call back để render lại các bảng table choose khi validate
                        if(--count === 0 && callback) {
                            //khi tru72 các select2 thành callback
                            callback();
                        }
                    })
              }
              Data.getSelect2(_this) 
            })        
        }
    }

   Data.ProductVariants = () => {
      let variants = JSON.parse(atob(variant));
      $('.variant-row').each(function(index , val) {
        let _this = $(this);
        let option = [
            {name : 'variants[qualnity][]' , class: 'variants_qualnity',value : variants.qualnity[index] },
            {name : 'variants[price][]' , class: 'variants_price',value : variants.price[index] },
            {name : 'variants[sku][]' , class: 'variants_sku',value : variants.sku[index] },
            {name : 'variants[code][]' , class: 'variants_code',value : variants.code[index] },
            {name : 'variants[album][]' , class: 'variants_album',value : variants.album[index] },
            {name : 'variants[file_name][]' , class: 'variants_file_name',value : variants.file_name[index] },
            {name : 'variants[file_url][]' , class: 'variants_file_url',value : variants.file_url[index] },
        ]

        for(let i = 0 ; i < option.length ; i++) {
           _this.find('.' + option[i].class).val(option[i].value);
        }
        let album = variants.album[index].split(',');
        _this.find('td.variants-album').find('span img').attr('src', album.length > 0 ? album[0] : 
        'http://localhost:8000/public/ckfinder/userfiles/images/Post/433610459-1399019177654607-8456780266104156853-n-1711118388-214344.jpg');
        _this.find('td.variants-qualnity').html(variants.qualnity[index]);
        _this.find('td.variants-price').html(variants.price[index]);
        _this.find('td.variants-sku').html(variants.sku[index]);
        _this.find('td.variants-code').html(variants.code[index]);
      })
   }





   $(document).ready(function() {
        Data.setUpVariantsAttribute();
        Data.addAttrubiteVariants();
        Data.OnChangeNiceSelectCheck();
        Data.removeAttributeElement();
        Data.CheckLengthTheAttribute();
        Data.OnchangeSelectVariants();
        Data.createAlbumVariants();
        Data.RemoveVariantsAlbum();
        Data.ChooseJsSwitchquery();
        Data.cancelDataVariants();
        Data.SubmitDataCreateVariants();
        Data.showDataVariantsAfterCreate();
        Data.setUpSelect2WhileUpdate( 
            () => {
                Data.ProductVariants();
            }
        );
   })

})(jQuery);