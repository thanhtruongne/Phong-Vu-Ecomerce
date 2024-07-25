(function($) {
    "use strict";
    var Data = {};
    //Delete
    Data.DeleteItemSoft = () => {
        $(document).ready(function() {
            $('body').on('click','.delete_item',function(e) {
                e.preventDefault();
                
                let href = $(this).prop('href');
                Swal.fire({
                    title: "Bạn có muốn xóa không ?",
                    showCancelButton: true,
                    icon: "warning",
                    confirmButtonText: "Xóa",
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Data.sendDelete(href);
                    }
                });
            })
        })
    }

    Data.sendDelete = (href) => {
           $.ajax({
            type : 'DELETE',
            url : href,
            success: function(data) {
                if(data.status == 'success') {         
                    toastr.success(data.message);
                    window.location.reload();
                } 
                else if(data.status == 'error') {
                    toastr.error(data.message);
                }
            },
            error : function(error) {

            }
           })
    }

    Data.DeleteForce = () => {
        $(document).ready(function() {
            $('body').on('click','.delete_force',function(e) {
                e.preventDefault();            
                let href = $(this).prop('href');
                Swal.fire({
                    title: "Bạn có muốn xóa vĩnh viễn không ?",
                    showCancelButton: true,
                    icon: "danger",
                    confirmButtonText: "Xóa",
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Data.sendDelete(href);
                    }
                });
            })
        })
    }

    //changestatus;
    Data.ChangeStatus = () => {
        $(document).ready(function() {
            $('body').on('change','.change_status',function(e) {
                
                let status = $(this).prop('checked');
                let option = {
                    'id' : $(this).data('id'),
                    'status' : status == true ? 1 : 0,
                    'model' : $(this).data('model'),
                }
                $.ajax({
                    type : 'GET',
                    url : '/private/system/ajax/dashboard/changestatus',
                    data : option,
                    success : function(data) {
                      if(data.status == 'success') {
                        toastr.success(data.message);
                      }
                      else if(data.status == 'error') toastr.error(data.message);
                    },
                    error : function(error) {

                    }
                })
            })
        })
    }

    Data.SendDataChangeStatus = (status,href) => {
        $.ajax({
            type : 'PUT',
            url : href,
            data : {
                status : status
            },
            success : function(data) {
                if(data.status == 'success') {
                    toastr.success(data.message);
                }
                else if(data.status == 'error') {
                    toastr.erro(data.message);
                }
            },
            error : function(error) {
                console.log(error);
            }
        })
    }


    Data.selectAllstatus = () => {
        $('body').on('click','.check_box_all_user',function(e) {
            let checked = $(this).prop('checked');
            
            if(checked) $('.check_item').closest('tr').addClass('active-bg');
            else $('.check_item').closest('tr').removeClass('active-bg');
            
            $('.check_item').prop('checked',checked);
            
        })
    }

    Data.CheckItemSelect = () => {
        $('body').on('click','.check_item',function(e) {
            let checked = $(this).prop('checked');
            if(checked) $(this).closest('tr').addClass('active-bg');
            else $(this).closest('tr').removeClass('active-bg');
            let allLengthChecked = $('input[class="check_item"]:checked').length == $('input[class="check_item"]').length;
            $('.check_box_all_user').prop('checked',allLengthChecked);
           
        })
    }
    
    Data.DeleteAllByConfigOption = () => {
        $('body').on('click','.status_all_config_option',function(e) {
            let id = [];
            $('input[class="check_item"]:checked').each(function() {
                const item = $(this);
                id.push(item.val());
            })
            let option = {
                value : $(this).data('value'),
                id : id,
                model : $(this).data('model'),
                target : $(this).data('target')
            }
            $.ajax({
                type : 'GET',
                url : '/private/system/ajax/dashboard/change-all-status',
                data : option,
                success: function(data) {        
                    if(data.status =='success') {
                        let styleCss1 = `
                        box-shadow: rgb(100, 189, 99) 0px 0px 0px 16px inset;
                        border-color: rgb(100, 189, 99);
                        background-color: rgb(100, 189, 99);
                        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s`;
                        let cssActive1 = `
                            left: 20px;
                            background-color: rgb(255, 255, 255);
                            transition: background-color 0.4s ease 0s, left 0.2s ease 0s;
                            background: #fff;
                            border-radius: 100%;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
                            height: 30px;
                            position: absolute;
                            top: 0;
                            width: 30px;
                            font-size: 85%;`;
                        let styleCss2 = `
                            background-color: rgb(255, 255, 255);
                            border-color: rgb(223, 223, 223);
                            box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;
                            transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;`;
                        let cssActive2 = `
                            left: 0px;
                            transition: background-color 0.4s ease 0s, left 0.2s ease 0s;
                        `  
                        
                        for(let i = 0 ; i < id.length ; i++) {
                            if(option.value == 1) {
                                $('.js-switch-'+id[i]).find('span.switchery').attr('style',styleCss1).find('small').attr('style',cssActive1);
                            }
                            else if(option.value == 0) {
                                $('.js-switch-'+id[i]).find('span.switchery').attr('style',styleCss2).find('small').attr('style',cssActive2);
                            }
                        }
                    }
                },
                error : function(error) {
                    console.log(error);
                }
            })
            e.preventDefault();
        })
    }

    Data.ChangeTranslateSystemLanguage = () => {
        $(document).on('change','.translate_language_system',function(){
            let _this = $(this);
            let languageId = _this.val();
            window.location.href = `/private/system/configuration/setting/translate/` + languageId;
            return false;
        })
    }


    //Menu
    Data.SaveMenuKeywordAndName = () => {
      $(document).ready(function() {
        $('.change_menu_keyword').click(function(e) {  
            let form = $('#submit_menu_keyword');
            let messages = $('span.message_timing');
            let option = {
                'name' : form.find('input[name="name"]').val() ?? null,
                'keyword' : form.find('input[name="keyword"]').val() ?? null,
                'status' : 1
            }
            console.log(option)

            $.ajax({
                type : 'POST',
                url : URL_SERVER + 'menu-cateloge/store',
                data : option,
                beforeSend: function() {
                    $('.change_menu_keyword').html('<div class="loader-1 center"><span></span></div>')
                    setTimeout(function(){
                        return true;
                      }, 3000); 
                 
                },
                success : function(data) {
                    console.log(data);
                    $('.change_menu_keyword').html('Tạo')
                    if(data.errCode == 0) {
                        messages.html(data.message);
                        $.each(data.key,function(index,value) {
                            $('div.error-'+value).text('').prev().removeClass('has-error');
                            form.find('input[name="'+value+'"]').val(' ');
                        })
                        $('.finding_select_choose_menu').append($('<option></option>').val(data?.value.id).text(data?.value.name));
                    }
                },
                error : function(xhr, status, error) {
                
                    $('.change_menu_keyword').html('Tạo')
                    //422
                    if(xhr.status == 422) {
                        let errors = xhr?.responseJSON?.errors;
                        let errorMessage = {};
                        let keyArray = Object.keys(option);
                        for(let i = 0 ; i < keyArray.length ; i++) {
                            errorMessage[keyArray[i]] = errors[keyArray[i]]?.join('') ?? '';              
                        }
                        console.log(errorMessage)
                        $.each(errorMessage,function(index,value) {
                            if(errorMessage[index] == '')   $('div.error-'+index).text('').prev().removeClass('has-error');
                            if(errorMessage[index] != '')   $('div.error-'+index).text(value+' (*)').prev().addClass('has-error');
                        })        
                    }         
                }
            })
            e.preventDefault();
        })
      })
    }

    Data.CreateInputMenuItem = () => {
        $(document).on('click','.add_item_content_menu',function(e) {
            e.preventDefault();
           let _this = $(this);
           $('.row_content').append(Data.CreatingTheRowContent()).prev().hide();
        })
    }

    Data.CreatingTheRowContent = (res = null) => {
        console.log(res)
        let row = $('<div>').addClass('content_item '+ (res?.canonical ? res?.canonical : '') + '').attr('style','height: 40px;margin:12px 0');
        let option = [
            { 'name' : 'menu[name][]', 'class' : 'col-lg-3' , 'value' : res?.name ? res?.name : '','input_class' :'form-control' },
            { 'name' :'menu[canonical][]', 'class' : 'col-lg-3' ,'value' :  res?.canonical ? res?.canonical : '','input_class' :'form-control'},
            { 'name' : 'menu[position][]', 'class' : 'col-lg-3','value' : 0 ,'input_class' :'form-control'},
            { 'name' : 'menu[image][]', 'class' : 'col-lg-2 ckfinder_2','value' : '','input_class' :'form-control' },
        ]
        option.forEach(val => {
             let input = $('<input>').attr('type','text').attr('name',val?.name).addClass(val?.input_class).val(val?.value);  
             let column = $('<div>').addClass(val?.class).append(input);
             row.append(column);
        })
        let xmark = $('<a>').attr('style','font-size: 16px').addClass('delete_menu_item_input').append('<i class="fa-solid fa-xmark"></i>');
        let trashDiv = $('<div>')
            .addClass('col-lg-1').attr('style','height: 32px;display:flex;justify-content:center;align-items:center;cursor: pointer')
            .append(xmark);
         row.append(trashDiv);
         return row;
    }

    Data.RemoveInputMenuItem = () => {
        $(document).on('click','.delete_menu_item_input',function(e) {
           
            let _this = $(this);
            _this.parents('.content_item').remove();
            Data.CheckLengthMenuItem();
            e.preventDefault();
        })
    }
    Data.CheckLengthMenuItem = () => {
        if($('.content_item').length == 0) $('.title_show_content').show();
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

    Data.ChooseItemRender = () => {
        $(document).on('click','.choose_menu_item',function(){
            let _this = $(this);
            let renderCheckbox = $('.model_checkbox_data');
            let payload = {
                'model' :  _this.data('model'),
            }
            let arrayAttribute = Data.CheckedCheckboxAttributeMenu();
            console.log(arrayAttribute);
            Data.AjaxUsingGetMenuAttribute(payload ,renderCheckbox,arrayAttribute );
            
           
        });
    }

    Data.RenderMenuAttributeCheckbox = ( res = null , subtring = null) => {
        let html  = '';
        html = `
            <div class="form-group" style="display: flex;align-items:center">
                <input type="checkbox" ${subtring != null && subtring.includes(res?.canonical) ? 'checked' : ' '} id='${res?.canonical}' value="${res?.canonical}" class="checkbox_content_data" style="margin:0">
                <label for="${res?.canonical}" style="margin:0 0 0 8px">${res?.name}</label>
            </div>`;
        return html;
    }

    Data.PaginationMenuAttribute = (links = null) => {
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
                            .text('>');
                li.append(span)
             }
             else if(val?.url) {
                let a = $('<a>').attr('href',val?.url).addClass('page-links').text(val?.label);
                li.append(a);
             }
             ul.append(li);
            })
    
            let nav = $('<nav>').append(ul);
            return nav;
        }
       
    }

    Data.CheckboxClickChoose = () => {
        $(document).on('change','.checkbox_content_data',function(){
            let _this = $(this);
             
            let response = {
                'name' : _this.next().text(),
                'canonical' : _this.val()
            }
            if(_this.prop('checked')== true) $('.row_content').append(Data.CreatingTheRowContent(response)).prev().hide();
            else  {
                $('.'+response?.canonical).remove(); 
                Data.CheckLengthMenuItem();
            }
           
            

        })
    } 

    Data.getMenuPageAttribute = () => {
       $(document).on('click','.page-links',function(e) {
            e.preventDefault();
            let _this = $(this);
            let  page = (_this.text() == '>' || _this.text() == '<') ? _this.attr('data-id') : _this.text();
            let option = {
                'model' : _this.parents('.panel-collapse').attr('id'),
                'page' : page
            }
            let target = _this.parents('.tab_menu_paginate').prev();
            Data.AjaxUsingGetMenuAttribute(option,target);
       })
    }
    
    Data.SearchingMenuAttribute = () => {
        $(document).on('keyup','.on_keyup_item_attribute',function(e) {
            let _this = $(this);
            let debounce;
            let renderList = _this.parents().siblings('.model_checkbox_data');
            let option = {
                'model' : _this.parents('.panel-body').parents('.panel-collapse').attr('id'),
                'keyword' : _this.val()
            }
            if(debounce)  clearTimeout(debounce);
             debounce = setTimeout(() => {
                 Data.AjaxUsingGetMenuAttribute(option,renderList);

            },800)
        })
    }

    Data.CheckedCheckboxAttributeMenu = () => {
       let menu  = $('.content_item ').map(function() {
           let aliasClass = $(this).attr('class').split(' ').slice(1).join(' ');
           return aliasClass
        }).get();
        return menu
    }

    Data.setUpNestedTable = () => { 
        $('#nestable').nestable({
            group: 1
        }).on('change', Data.AjaxNestedTableList);
        
    }

    Data.AjaxNestedTableList = (e) => {  
        e.preventDefault();
        var list = $(e.target);
        let data =   window.JSON.stringify(list.nestable('serialize'));
        let cateloge_id = $('#nestable').data('cateloge');
        let option = {
            'menu_cateloge_id' : cateloge_id,
            'data_json' : data,
        }
        $.ajax({
            type: 'GET',
            url : '/private/system/menu/ajax/nested-table',
            data : option,
            success : function(data) {
               console.log(data);
            },
            error : function(error) {
             console.log(error);
            }
        })
        
    }

    Data.NestedTableType = () => {
        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                    action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });    
    }

    // Data.UploadIconMenu = () => {
    //     $('body').on('click','.ckfinder_3',function() {
    //         let _this = $(this);
    //         Data.setupCkfinder(_this , null); 
    //     })
    //    }
    
    //    Data.setupCkfinder = (input = null,image = null,type = 'image') => {
    //     CKFinder.popup({
    //       chooseFiles: true,
    //       onInit : function(finder) {
    //           finder.on( 'files:choose', function( evt ) {   
    //               if(type == 'image') {
    //                   var file = evt.data.files.first();
    //                   input.val(file.getUrl());
    //                   if(image != null) {
    //                       image.attr("src",file.getUrl())
    //                   }
    //               }
    //               else {
    //                   var files = evt.data.files;
    //                   var html = '';
    //                   files.forEach( function( file, i ) {
    //                       html += `
    //                       <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
    //                           <img height="120" src="${file.getUrl()}" width="150" alt="">
    //                           <input type="hidden" name="album[]" value="${file.getUrl()}"/>
    //                           <button type="button" class="trash_album" >
    //                               <i class="fa-solid fa-trash"></i>
    //                           </button >
    //                       </li> 
    //                       `
    //                   });
                      
    //                   input.parents('.check_hidden_image_album').addClass('hidden');
    //                   image.html(html);            
    //               }
                 
    //           } );
    //           finder.on( 'file:choose:resizedImage', function( evt ) {
    //               // document.getElementById( 'url' ).value = evt.data.resizedUrl;
    //           } );
    //       }
    //     });
    //  }


   $(document).ready(function() {
       Data.DeleteItemSoft();
       Data.DeleteForce();
       Data.ChangeStatus();
       Data.selectAllstatus();
       Data.CheckItemSelect();
       Data.DeleteAllByConfigOption();
       Data.ChangeTranslateSystemLanguage();
       Data.SaveMenuKeywordAndName();
       Data.CreateInputMenuItem();
       Data.RemoveInputMenuItem();
       Data.ChooseItemRender();
       Data.CheckboxClickChoose();
       Data.getMenuPageAttribute();
       Data.SearchingMenuAttribute();
       Data.CheckedCheckboxAttributeMenu();
    //    Data.UploadIconMenu()
       //set up nested table
       Data.setUpNestedTable();
       Data.NestedTableType();
   })

})(jQuery);