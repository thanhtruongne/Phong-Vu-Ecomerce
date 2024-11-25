@extends('backends.layouts.layouts')


@section('page_title')

@section('breadcrumbs')
    @php
        $breadcum = [
            [
                'name' => 'Quản lý sản phâm',
                'url' => ''
            ],
            [
                'name' => 'Tạo sản phẩm',
                'url' => ''
            ],
        ];

    @endphp
<div class="row mb-3 mt-2 bg-white">
    <div class="col-md-12 px-0">
        @include('backends.layouts.components.breadcrumb',$breadcum)
    </div>
</div>
    
@endsection

@section('links')
{{-- <link href="{{asset('css/iconIconic.css')}}" rel="stylesheet" type="text/css"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('backend2/css/cusomTreeCategory.css')}}">
    <link rel="stylesheet" href="{{asset('backend2/css/treeSelect.min.css')}}">

@endsection

@section('content')
  <style>
    
    .ui-slider-handle{
            border-radius: 100% !important;
        }
        .ui-state-active,
        .ui-widget-content .ui-state-active,
        .ui-widget-header .ui-state-active,
        a.ui-button:active,
        .ui-button:active,
        .ui-button.ui-state-active:hover {
            border: none !important;
            background: #ffffff !important;
            font-weight: normal;
            color: {&quot;id&quot;:3,&quot;name&quot;:&quot;color_link&quot;,&quot;text&quot;:&quot;#9b0305&quot;,&quot;hover_text&quot;:&quot;#919191&quot;,&quot;active&quot;:null,&quot;background&quot;:null,&quot;hover_background&quot;:null,&quot;background_child&quot;:null,&quot;icon_left_menu&quot;:&quot;#000000&quot;,&quot;hover_icon_left_menu&quot;:&quot;#FFF8DC&quot;,&quot;is_gradient&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:&quot;2024-10-01T12:03:55.000000Z&quot;} !important;
        }
        .ui-widget-header{
            border: 1px solid #ffffff !important;
            background:#e70404 !important;
        }
        #minute-slider{
            height:1px;
        }
        #minute-slider .ui-slider-handle {
            top: -8px !important;
        }
    
  </style>


    <div class="row bg-white backend-container pt-3" style="margin-left: -15px;margin-right:-15px">
        <div class="col-md-12 pb-3">
            <div class="">
                <div class="row"> </div>
                    <div class="">
                        <ul class="nav nav-pills mb-4">
                            <li class="nav-item">
                                <a href="" class="nav-link active">
                                    Thông tin
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <form action="" id="form-create-product" class="form-horizontal form-ajax" enctype="multipart/form-data">
                                  <input type="hidden" name="id" value="{{$model->id}}">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                                Tên sản phẩm
                                                <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="name" value="{{$model->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                                Mô tả
                                            </label>
                                            <div class="col-md-8">
                                                <textarea name="description" class="editor" data-target="description" id="description" cols="30" rows="10">{{$model->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                               Nội dung
                                            </label>
                                            <div class="col-md-8">
                                                <textarea name="content" class="editor" data-target="content" id="content" cols="30" rows="10">{{$model->content}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                               Galley Image
                                            </label>
                                            <div class="col-md-8">
                                                <div class="text-center" style="border: 1px solid #ccc">
                                                    <div class="check_hidden_image_album {{ isset($model->album) && !empty($model->album) && $model->album != 'null' ? 'hidden' : '' }}">
                                                        <img class="ckfinder_3" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                                                        <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
                                                    </div>
            
                                                    <div class="ul_upload_view_album clearfix py-2 sortable" style="list-style-type: none">
                                                        
                                                        @if (isset($model) && !empty($model))
                                                            @php
                                                                $album =  json_decode($model->album) ?: [];
                                                            @endphp
                                                        @if (!empty($album) && count($album) > 0)
                                                            @foreach ($album as $item) 
                                                            <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                                                                <img height="120" src="{{ $item }}" width="150" alt="">
                                                                <input type="hidden" name="album[]" value="{{ $item }}"/>
                                                                <button type="button" class="trash_album btn bg-red" >
                                                                    <i class="fas fa-trash text-white" ></i>
                                                                </button >
                                                            </li>
                                                            @endforeach
                                                        @endif
                                                   
                                                     @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group" style="padding: 0 7.5px">
                                            <button id="submit-btn" type="submit" class="btn"><i class="fa fa-save"></i> Lưu</button>
                                           <a href="{{route('private-system.product')}}" class="btn">
                                                <i class="fas fa-times"></i>
                                                Hủy
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                            Hình ảnh
                                            </label>
                                            <div class="col-md-7">
                                                <div class="ckfinder_12" style="border: 1px solid #ccc;cursor: pointer;" data-type="image">
                                                    <input type="hidden" name="image"  value="{{$model->image}}">
                                                    <img class="image" style="width:100%" src={{ $model->image ?? "https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" }} alt="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                                Mã SKU
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" {{$model && $model->is_single == 2 ? 'disabled' : ''}} class="form-control integerInput" name="sku" value="{{$model->sku_code}}"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                                Số lượng
                                                <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" {{$model && $model->is_single == 2 ? 'disabled' : ''}} class="form-control integerInput" name="quantity" value="{{$model->quantity}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                                Giá tiền
                                               <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input  class="form-control number-format" {{$model && $model->is_single == 2 ? 'disabled' : ''}} value="{{$model->price ?: null}}" name="cost" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                               Danh mục sản phẩm
                                               <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                               <div class="tree_select_demo_main"></div>
                                               <input type="hidden" value="{{$model->product_category_id}}" name="category_id" id="category_id">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                               Thương hiệu sản phẩm
                                               <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <select name="brand_id" class="form-control load-brand" id="" data-placeholder="-- Thương hiệu --">
                                                    @if ($model && $model->brand)
                                                        @php
                                                            $brand = $model->brand ?? null
                                                        @endphp
                                                        <option value="{{$brand->id}}" selected>{{ $brand->name }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-8 text-right">
                                                <div class="dropdown">
                                                    <button {{$model && $model->is_single == 2 ? 'disabled' : ''}} class="btn dropdown-toggle add_attribute" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        Thêm attribute
                                                    </button>
                                                    <div class="dropdown-menu toggle_attribute">
                                                        @php        
                                                          
                                                            if($model && $model->id > 0 && is_null($model->is_single)){  
                                                               $attributes_check = $model->attributes_item->pluck('parent_id')->toArray();         
                                                            }
                                                       @endphp
                                                      
                                                        @if (isset($attributes))
                                                            @foreach ($attributes as $attribute)
                                                                <a class="dropdown-item attribute_choose {{isset($attributes_check) && !is_null($attributes_check) &&  in_array($attribute['id'],$attributes_check) ? 'disabled' : ''}}"  data-parent="{{$attribute['id']}}" >{{ $attribute['name'] }}</a>
                                                            @endforeach
                                                        @endif   
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                   
                                        <div class="render_attribute_parent">
                                             
                                        </div>
                                    </div>


                                    <div class="col-md-9">
                                        <div class="form-group row">
                                            <label for="" class="control-label col-sm-2">
                                               Sản phẩm variant
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" {{$model && $model->is_single == 2 ? 'checked' : ''}} id="is_single" {{ $model && $model->is_single == 2 ? 'disabled' : ''}} name="is_single" class="form-control mt-1">
                                                        <span class="ml-3">( Sản phẩm đơn hoặc có nhiều phần variants con. )</span>
                                                    </div>
                                                    <input type="hidden" name="attribute_varian_idx" value="{{$model && !is_null($model->is_single) ? json_encode($sku_idxs) : null}}">
                                                    {{-- <button class="btn create_variant" disabled type="button"><i class="fa fa-plus"></i> </button> --}}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- render variant {{$model && $model->is_single == 2 ? '' : 'hidden'}}   --}}
                                        <div class="variant_child form-group row {{$model->id && $model->is_single != null ? '' : 'hidden'}}">
                                            <div class="col-sm-2"></div>
                                            <div class="col-md-8">
                                                 <div class="">
                                                    <div class="text-cap">Chọn các thuộc tính variants <span class="text-danger">(*)</span></div>
                                                    <div class="render_variant_thourgh">
                                                      {{-- render --}}
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn toogle_render_variant" type="button">
                                                            <i class="fa fa-plus"></i> 
                                                            Thêm variants
                                                        </button>
                                                        <button type="button" class="btn" onclick="createVariants()">
                                                            <i class="fa fa-check-circle"></i>
                                                            Tạo variants
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>

                                    {{-- render variant table --}}
                                    <div class="col-md-9 table_action {{$model->id && $model->is_single != null ? '' : 'hidden'}}">
                                        <table class="table table-bordered variantsTable" style="margin: 20px 0px;">
                                            <thead></thead>
                                            <tbody></tbody>
                                          </table>
                                    </div>
 
                             
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div> 

@endsection

@section('scripts')
<script src="{{asset('backend2/js/treeSelect.min.js')}}"></script>
<script type="text/javascript">
        function load_attrbute(id = null){
            if(id){
                $('.load-attribute-custom_'+id).select2({
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
            }
            else {
                $('.load-attribute-custom').select2({
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
            }
        
        }

        function onClickCreateAttributeVariant(id,parent_id){
            let parent = $('.item_variant_attribute_'+ parent_id);
            let render = parent.find('.item_variant_'+ parent_id);
            let hrefItem = parent.find('.toggle_variant').find('a.dropdown-item[data-parent="'+id+'"]');
            let name = $(hrefItem).text();
            render.append(`
                <div style="padding: 0 7.5px;" class="form-group d-flex align-items-center attribute_item_variant_${id}">
                    <div style="width:30%">
                        <label for="" class="control-label fw-bold">
                            ${name}
                            <span class="text-danger">(*)</span>
                        </label>
                        <div class="">
                            <select name="attribute[${parent_id}][]" class="form-control load-attribute-custom" data-parent="${id}" data-placeholder="-- ${name} --" multiple></select>
                        </div>
                    </div>
                    <div style="margin-left:20px;"> <a onclick="removeVariant(${id})" class="btn remove_variant_item"><i class="fas fa-trash" ></i></a></div>
                </div>`);
            $(hrefItem).addClass('disabled');
            loadCustom()
        }
        let array_data_select2 = [];
        let searchParams = new URLSearchParams(window.location.search)
        let render = $('.render_variant_thourgh');
        let count = 1;

        function removeVariants(id){
            let _this = $('#remove_variant_'+id);
            let parent =  _this.parents('.wrapper_row_' + id);
            parent.remove();         
        }


        $('body').on('click','.toogle_render_variant',function(){
            let _this = $(this);    
            let parent_render = _this.siblings('.render_variant_thourgh');
            if($(parent_render).find('.wrapper_row').length){
                let last_item = $(parent_render).find('.wrapper_row:last');
                if($(last_item).find('select.on_change_load').val() == ""){
                    show_message('Vui lòng chọn dữ liệu attribute trước khi thêm mới', 'warning');
                    return false;
                }
            }   
            render_variant();   
        })

    

        function render_variant(){
            let ac_sum = count++;
            let html = '';
            $.each(@json($attributes ?? []),function(calc,attribute){
                html += `<option value="${attribute?.id}" ${array_data_select2.includes(attribute?.id) ? 'disabled' : ''} data-check="${attribute?.id}" data-parent="${attribute?.parent_id}">${attribute?.name}</option>`
                // html += `<a class="dropdown-item ${arr.includes(attribute['id']) ? 'disabled' : ''}" onclick="onClickCreateAttributeVariant(${attribute['id']},${index})" data-id="${index}" data-parent="${attribute['id']}" >${attribute['name']}</a>`
            })

            render.append(`
                <div class="row mb-4 wrapper_row_${ac_sum} catch_item">
                    <div class="col-md-4 mb-2 mb-sm-0 get_element" data-id="${ac_sum}">
                        <select name="attributes_parent[]" class="select_custom form-control on_change_load" id="" data-placeholder="-- Chọn thuộc tính --">
                            <option value=""></option>
                            ${html}
                        </select>
                    </div>
                    <div class="col-md-6 render_child_${ac_sum}" >
                         <input type="text" class="form-control" disabled>
                    </div>
                    <div  class="col-md-2">
                        <button type="button" class="btn" id="remove_variant_${ac_sum}" onclick="removeVariants(${ac_sum})"><i class="fas fa-trash"></i></button>
                    </div>
                 
                </div>`)
            load_select2();
        }
        $('body').on('change','select.on_change_load',function(e){
            let _this = $(this);
            let val = _this.val();
            let data_id = _this.parent('.get_element').data('id');

            if(val != 0) {
                _this.parents('.wrapper_row_' + data_id).find('.render_child_' + data_id).html(variants_select(val,data_id));
                getSelect2(val,data_id) 
            }
            else {
                _this.parents('.wrapper_row_' + data_id).find('.render_child_' + data_id).html(
                    '<input type="text" class="form-control" disabled>'
                );
            }
            // reloadAttribute(val,_this,data_check_id)
        })

        function variants_select(val,id){
            let html = '<select id="load_custom_att_'+id+'" class="variants-'+val+' form-control get_val_attribute" name="attribute_id['+val+'][]" multiple data-catid='+val+'></select>';
            return html;
        }

        function  getSelect2(val,data_id){
            $('#load_custom_att_' + data_id).select2({
                placeholder: 'Nhập ký tự để tìm kiếm',
                allowClear: true,
                ajax: {
                    url: base_url + '/load-ajax/loadAttribute',
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page,
                            parent_id :val
                        }
                    },
                    processResults : function(data) {
                        return {
                            results : $.map(data,function(obj,i) {
                                return obj;
                            })
                        }
                    }
                }
            })
        }

        function createVariants(){
            let main = $('.render_variant_thourgh');
            let attributeVariants = [];
            let attributeTitle = [];
            let attribute = [];
            let attrCatelogeID = []; //check duplicate
            let attribute_idxs = [];
            if($('.render_variant_thourgh').find('.catch_item').length == 0) {
                show_message('Vui lòng chọn thuộc tính','warning');
                attributeVariants = [];
                return false;
            }
            $(main).children('.catch_item').each(function(i,item){
                let attribute_cateloge_id = $(item).find('.select_custom').val();
                let attributre_cateloge_name = $(item).find('.get_element select').select2('data');
                let attribute_variant_ids = $(item).find('select.get_val_attribute').select2('data')
                let variants = {};
              
                if(attribute_cateloge_id == ""){
                    show_message('Vui lòng không bỏ trống thuộc tính '+attributre_cateloge_name[0].text+' đã tạo','warning');
                    attributeVariants = [];
                    return false;
                }
                if(attribute_variant_ids.length == 0){
                    show_message('Vui lòng không bỏ trống dữ liệu thuộc tính ' + attributre_cateloge_name[0].text +' đã tạo','error');
                    attributeVariants = [];
                    attrCatelogeID = [];
                    attribute = [];
                    attribute_idxs = [];
                    attributeVariants = [];
                    attributeTitle = []
                    return false;
                }

                let attr = [];
                let attributeIdVariants = [];
                let attribute_idx = [];
                attrCatelogeID.push(attribute_cateloge_id);
                for(let i = 0 ; i < attribute_variant_ids?.length ; i++ ) {    
                    let variants = {};
                    let item = {};
                    variants[attribute_cateloge_id] = attribute_variant_ids[i].id;  
                    item[attributre_cateloge_name[0].text] = attribute_variant_ids[i].text;
                    attr.push(item);  
                    attributeIdVariants.push(variants);
                    attribute_idx.push(attribute_variant_ids[i].id)
                }         
                attributeTitle.push(attributre_cateloge_name[0].text);
                attribute.push(attr);
                attributeVariants.push(attributeIdVariants);
                attribute_idxs[attribute_cateloge_id] = attribute_idx
                
            });

            // //check duplicate attribute_cateloge_id
            if(checkIfDuplicateExists(attrCatelogeID)){
                show_message('Trùng các thuộc tính cateloge','error');
                attributeVariants = [];
                attrCatelogeID = [];
                attribute = [];
                attributeTitle = []
                return false;
            }
            

            attribute = attribute?.reduce((previous,current) => {
                return previous.flatMap(item => current.map(val => ({...item , ...val })));
            })

            attributeVariants =  attributeVariants?.reduce((previous , current) =>  {
                return previous.flatMap(val => current.map(cur => ({...val ,...cur}) ));
            });
            
            let set_data = []
            attributeVariants?.map(function(temp,index){
                let keys = Object.keys(temp);
                let value_arr = Object.values(temp);
                let arr_data_set = [];
                attribute_idxs?.map(function(val_child,index_child){
                    if(keys.indexOf(index_child.toString()) !== -1){ // có giá trị trong array keys
                        val_child.map(function(child_temp,prefix){
                            if(value_arr.indexOf(child_temp) !== -1){
                                arr_data_set.push(prefix);
                            }
                        })
                    }
                })
                set_data.push(arr_data_set)
            })

            let input_idx = $('input[name="attribute_varian_idx"]');
            if(input_idx){
                input_idx.val(JSON.stringify(set_data));
            }
            createRowTableHead(attributeTitle)
            let trClass = [];
            attribute.forEach((val,index) =>  {
                let row = '';            
                if($('input[name="id"]').val() && @json($model->id) && @json($model->sku_variant)){
                     row = createVariantsRow(attributeVariants[index],val,@json($model->sku_variant)[index]);    
                }
                else {
                     row = createVariantsRow(attributeVariants[index],val);    
                }
                   
                //lặp qua các tr class sau đó push vào mảng
                let classModify = "tr-variant-" + Object.values(attributeVariants[index]).join(', ').replace(/, /g,'-');
                
                trClass.push(classModify);
            
                //trường hợp tránh các row trùng nhau từ variants_id và text
                if(!$("table.variantsTable tbody tr").hasClass(classModify)) {
                    $('table.variantsTable tbody').append(row);
                }
            })
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

        function createRowTableHead(attributeTitle)  {
            let $thead = $('table.variantsTable thead');
            let $row = $('<tr>');
            $row.append($('<td>').text('Hình ảnh'));
            for(let i = 0 ;i < attributeTitle.length ; i++) {
                $row.append($('<td>').text(attributeTitle[i]));
            }
            $row.append($('<td>').text('Số lượng'));
            $row.append($('<td>').text('Giá tiền'));
            $row.append($('<td>').text('Sku'));
            // $row.append($('<td>').text('Code'));
            $thead.html($row);
            
            return $thead
        }

        function  createVariantsRow(variantsId,arrtributeItem,model = null){  
            let td;
            let attributeString = Object.values(arrtributeItem).join(', ');
            let variantAttribute = Object.values(variantsId).join(', ');
            //chuyển vể dạng 1-2-3 để set vào class tr để dễ filter các bảng
            let replaceModifyClassTable = variantAttribute.replace(/, /g,'-');
            let row = $('<tr>').addClass('variant-row tr-variant-'+ replaceModifyClassTable);
            let image = ''
            if($('input[name="id"]').val() && model) {
               image = model?.album?.split(',')[0];
            }
            td = $('<td>').addClass('variants-album').append(
                $('<span>').append($('<img>').attr('src',image).attr('width','80'))
                )
            row.append(td);


            Object.values(arrtributeItem).forEach((val , index) => {
                td = $('<td>').text(val);   
                row.append(td);
            })

            td = $('<td>').addClass('hidden variants');
            let price = $('input[name=price]').val() ;
            let option = '';
            if ($('input[name="id"]').val() && model) {
                 option = [
                    {name : 'variants[qualnity][]' , class : 'variants_qualnity',val : model?.stock},
                    {name : 'variants[price][]' , class : 'variants_price',val : toVND(model?.price)},
                    {name : 'variants[sku][]' , class : 'variants_sku',val : model?.sku_code},
                    {name : 'variants[album][]' , class : 'variants_album',val : model?.album},
                    {name : 'productVariants[id][]' , val : variantAttribute},
                    {name : 'productVariants[name][]' , val : attributeString},
                ]
            }
            else{
                 option = [
                    {name : 'variants[qualnity][]' , class : 'variants_qualnity'},
                    {name : 'variants[price][]' , class : 'variants_price'},
                    {name : 'variants[sku][]' , class : 'variants_sku'},
                    {name : 'variants[album][]' , class : 'variants_album'},
                    {name : 'productVariants[id][]' , val : variantAttribute},
                    {name : 'productVariants[name][]' , val : attributeString},
                ]
            }
            $.each(option , function(index , value) {
                let input = $('<input>').attr('type','text').attr('name',value.name)?.addClass(value?.class);   
                if(value.val) {
                    input?.val(value.val);
                }
                td.append(input);
            })
            row.append(td);
            
            row.append($('<td>').addClass('variants-qualnity').text(model?.stock))
                .append($('<td>').addClass('variants-price').text(toVND(model?.price)))
                .append($('<td>').addClass('variants-sku').text(model?.sku_code))
            return row;
        }

        function checkIfDuplicateExists(arr) {
            return new Set(arr).size !== arr.length
        }

        $('body').on('click','.variant-row',function(){
            let _this = $(this);
            let variants = {};
            _this.find('td.variants input[type=text][class^="variants_"]').each(function() {
               let className = $(this).attr('class');
               variants[className] = $(this).val();
            });
            if($('.check_length_variants').length === 0) {
                _this.after(dataVariantsDyynamic(variants));
                // Data.createAlbumVariants();
                $('#sortable_books').sortable();       
            }
        })

        function mySort(x, y)
        {
            return ((x.length < y.length) ? -1 : ((x.length > y.length) ? 1 : 0));
        }

        function dataVariantsDyynamic(variants){
            let html = '';
            let imageArray =  variants.variants_album == "" ? [] : variants?.variants_album?.split(',') ;
            let price = variants?.variants_price == undefined ?  $('input[name=price]').val()  : variants?.variants_price;
            let code = $('input[name=code]').val();
            let LisetImage = updateImageVariantsTable(imageArray);
            html = `
            <tr class="check_length_variants">
                <td colspan="6" style="border: none;padding-top:20px">
                    <div style="display:flex;justify-content: space-between">
                        <div >
                            <h3 class="text-success">Hình ảnh sản phẩm</h3> 
                        </div>
                        <div>
                            <button type="button" class="btn remove_variants_data" style="margin-right: 8px">
                                <i class="fas fa-times"></i>
                                Hủy
                            </button>
                            <button type="button" class="btn saveVariantsData">
                                <i class="fa fa-save"></i>
                                Lưu dữ liệu
                            </button>
                        </div>
                    </div>       
                    <div class="render_store_data_variants">
                        <div class="updateVariants" style="font-size:16px;margin:2rem 0;">
                            <div class="font_title_album text-center">
                                <div class="check_hidden_image_album ${(imageArray?.length == 0) ? '' : 'hidden'} ">
                                    <img class="ckfinder_3" data-parent="variantsalbum" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                                    <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
                                </div>
                                <div class="ul_upload_view_album clearfix sortable" style="list-style-type: none" id="sortable_books">
                                    ${LisetImage == undefined ? ' ' : LisetImage}
                                </div>
                            </div>
                            <div style="margin-top: 20px">
                                    <div class="col-lg-10">
                                        <div class="row">
                                                <div class="col-lg-3">
                                                <label style="font-size: 14px;font-weight:500" for="">Số lượng</label>
                                                <input type="text"  value="${variants?.variants_qualnity }" class="form-control integerInput" name="qualnity" data-target="variantsQualnity"/>
                                                </div>
                                                <div class="col-lg-3">
                                                <label style="font-size: 14px;font-weight:500" for="">SKU</label>
                                                <input type="text" class="form-control integerInput" value="${variants?.variants_sku}" name="variantsSKU" data-target="variantsSKU"/>
                                                </div>
                                                <div class="col-lg-3">
                                                <label style="font-size: 14px;font-weight:500" for="">Giá</label>
                                                    <input type="text" class="form-control number-format" value="${price}" value="0" name="price" oninput="this.value=this.value.replace(/[^0-9]/g,'')" data-target="variantsPrice"/>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div
                </td>
            </tr>
            `
            return html;
        }

        function updateImageVariantsTable(album){
            let html = '';
            if(album?.length && album != 0) {
                for(let i = 0 ; i < album?.length ; i++) {
                        html = html + '<li class="list_item" style="float:left;margin: 0 12px 12px 12px">'
                        html = html + '<img height="120" src="'+ album[i] +'" width="150" alt="">'
                        html = html + '<input type="hidden" name="variantsalbum[]" value="'+ album[i] +'"/>'
                        html = html + '<button type="button" class="btn bg-red trash_album">'
                        html = html +  '<i class="fas fa-trash text-white" ></i>'
                        html = html + '</button>'
                        html = html + '</li>'
                }
                return html;
            }
    
        }

        $(document).on('click','.remove_variants_data',function(e) {
            $(this).parents('div .check_length_variants').remove();
        })

        $(document).on('click','.saveVariantsData',function(e) {
            let variants = {
                'qualnity' : $('input[name="qualnity"]').val() ?? '',
                'sku' : $('input[name="variantsSKU"]').val() ?? '',
                'price' : $('input[name="price"]').val() ?? '',
                'album' : $('input[name="variantsalbum[]"]').map(function() {
                    return $(this).val();
                }).get(),
            }
            $.each(variants,function(index , val) {
                $('.check_length_variants').prev().find('.variants_'+index).val(val);
            })
            updateVartiantsTable(variants);
            removeUpdateData();
            e.preventDefault();
        })

        function updateVartiantsTable(variants) {
            let option =  {
                'qualnity' : variants.qualnity,
                'sku' : variants.sku,
                'price' : variants.price,
            }
            $.each(option,function(index ,val) {
                $('.check_length_variants').prev().find('td.variants-'+index).html(val);
            })
            $('.check_length_variants').prev().find('td.variants-album').find('span img').attr('src',variants.album[0])
        }

        function removeUpdateData(){
            $('.check_length_variants').remove();
        }
        // function reloadAttribute(id,element,parent){
        //     let child = $(parent).find('.render_child').find('select.form-control');
        //     $(child).attr('multiple',true).html(' ');
        //     $(child).select2({
        //         placeholder: 'Nhập ký tự để tìm kiếm',
        //         ajax: {
        //             url:  base_url + '/load-ajax/loadAttribute',
        //             dataType: 'json',
        //             delay: 100,
        //             data: function(params) {
        //                 return {
        //                     search: $.trim(params.term),
        //                     page: params.page,
        //                     parent_id : id,
        //                 }
        //             },
        //             processResults : function(data) {
        //             return {
        //                 results : $.map(data,function(obj,i) {
        //                     return obj;
        //                 })
        //             }
        //             },
        //             cache: true
        //         }
        //     })         
        // }



        //trường hợp edit
        if($('input[name="id"]').val()){     
            if(@json($model) && @json($model->is_single) == 2){
                let render = $('.render_variant_thourgh');
                let attribute_name_title_table = [];
                let attribute_item_id = [];
                $.each(@json($model->attributes),function(index,value){
                    let ac_sum = count++;
                    let html = '';
                    let attribute_template = '';
                    let attribute_get_off = [];
                    $.each(value?.option,function(key,item){
                        html += `<option value="${item?.id}" selected>${item?.name}</option>`
                        attribute_get_off.push(item?.name);
                    })
                    $.each(@json($attributes ?? []),function(calc,attribute){
                        attribute_template += `<option value="${attribute?.id}" ${attribute?.id == value?.id? 'selected' : ''} data-check="${attribute?.id}" data-parent="${attribute?.parent_id}">${attribute?.name}</option>`
                    })
                    render.append(`
                        <div class="row mb-4 wrapper_row_${ac_sum} catch_item">
                            <div class="col-md-4 mb-2 mb-sm-0 get_element" data-id="${ac_sum}">
                                <select name="attributes_parent[]" class="select_custom form-control on_change_load" id="" data-placeholder="-- Chọn thuộc tính --">
                                    ${attribute_template}
                                </select>
                            </div>
                            <div class="col-md-6 render_child_${ac_sum}" >
                                <select id="load_custom_att_${ac_sum}" class="variants-${value?.id} form-control get_val_attribute" name="attribute_id[${value?.id}][]" multiple data-catid='${value?.id}'>${html}</select>
                            </div>
                            <div  class="col-md-2">
                                <button type="button" class="btn" id="remove_variant_${ac_sum}" onclick="removeVariants(${ac_sum})"><i class="fas fa-trash"></i></button>
                            </div>

                        </div>`
                    )
                    load_select2();
                    getSelect2(value?.id,ac_sum)
                    //get tiitle    
                    attribute_name_title_table.push(value?.name);
                })
                createVariants();
      
            }
            if(@json($model->attributes_item)) {
                let parent = $('.render_attribute_parent')
                $.each(@json($model->attributes_item),function(index,value) {
                    parent.append(`
                    <div class="form-group d-flex algin-items-center attribute_item">
                        <div style="width:65%">
                            <label for="" class="control-label fw-bold">
                                ${value?.parent_name}
                                <span class="text-danger">(*)</span>
                            </label>
                            <div class="">
                                <select name="attribute[]" class="form-control load-attribute-custom" data-parent="${value?.parent_id}" data-placeholder="-- ${value?.parent_name} --">
                                    <option value="${value?.id}" selected>${value?.name}</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-left:20px;"> <button type="button" class="btn remove_item_attribute"><i class="fas fa-trash" ></i></button></div>
                    </div>`);
                    load_attrbute();
                })
            }
        }


   
        let attribute_parent = $('.render_attribute_parent')
        let arrIds = [];
        $('body .attribute_choose').on('click',function(){
            let check = false;
            let _this = $(this);
            let name = _this.text();
            let id = _this.data('parent');
            $.map(arrIds,function(item,index){if(item == id) { check = true}})
            if(check){
               return;
            }
            else{
                _this.addClass('disabled');
                arrIds.push(id);
                attribute_parent.append(`
                <div class="form-group d-flex algin-items-center attribute_item">
                    <div style="width:65%">
                        <label for="" class="control-label fw-bold">
                            ${name}
                            <span class="text-danger">(*)</span>
                        </label>
                        <div class="">
                            <select name="attribute[]" class="form-control load-attribute-custom" data-parent="${id}" data-placeholder="-- ${name} --">
                                
                            </select>
                        </div>
                    </div>
                    <div style="margin-left:20px;"> <button type="button" class="btn remove_item_attribute"><i class="fas fa-trash" ></i></button></div>
                </div>`);
                load_attrbute();
            }  
        })
        

 
        $('body').on('click','.remove_item_attribute',function(){
            let _this = $(this);
            let id = _this.parents('.attribute_item').find('select').data('parent');
            let find = $('body .attribute_choose[data-parent="'+id+'"]');
            find.removeClass('disabled');
            let menu = $('body .toggle_attribute');
            arrIds = arrIds.filter(function(r){
                return r !== id;
            })
            _this.parents('.attribute_item').remove();
        })
 
        $('body').on('click','.trash_album',function(e) {       
            $(this).parents('.item_album').remove();
            if($('.ul_upload_view_album li.item_album').length == 0) {
                $('.ul_upload_view_album').prev().removeClass('hidden');
                $('.check_hidden_image_album').removeClass('hidden');
            }
            e.preventDefault();
        })


        const domElement = document.querySelector('.tree_select_demo_main')
        const treeselect = new Treeselect({
            parentHtmlContainer: domElement,
            value: @json($model) ? @json($model->product_category_id) :  [],
            options: @json($categories ?? []),
            placeholder:  '-- Chon danh mục sản phẩm --',
            isSingleSelect: true,
        })

        treeselect.srcElement.addEventListener('input', (e) => {
            $('#category_id').val(e.detail );
        })



        $('#is_single').on('click',function(){
            let _this = $(this);
            if(_this.prop('checked')){
                $('input[name="sku"]').prop('disabled',true);
                $('input[name="cost"]').prop('disabled',true);
                $('input[name="quantity"]').prop('disabled',true);
                $('input[name="categories_main_id"]').prop('disabled',true);
                
                $('.render_attribute_parent').addClass('hidden');
                $('.render_attribute_parent .attribute_item select').prop('disabled',true);
                $('body .add_attribute').prop('disabled',true);
                //variant
                $('.variant_child').removeClass('hidden');
                $('body .create_variant').prop('disabled',false)
                $('.table_action').removeClass('hidden')
            }
            else {
                $('input[name="sku"]').prop('disabled',false);
                $('input[name="cost"]').prop('disabled',false);
                $('input[name="quantity"]').prop('disabled',false);
                $('.render_attribute_parent').removeClass('hidden');
                $('.render_attribute_parent .attribute_item select').prop('disabled',false);
                $('body .add_attribute').prop('disabled',false);
                $('input[name="categories_main_id"]').prop('disabled',false);
                
                $('.variant_child').addClass('hidden')
                $('.table_action').addClass('hidden')
                $('body .create_variant').prop('disabled',true)
            }
        })

       $('#form-create-product').submit(function(e){
           e.preventDefault();   
           var formData = $(this).serialize();
            // do không lấy được input content, nên thêm mã hóa nội dung để truyền vào
            var content = CKEDITOR.instances['content'].getData();
            var desc = CKEDITOR.instances['description'].getData();
            formData += '&content=' + encodeURIComponent(content) + '&description=' + encodeURIComponent(desc) + '&type=' + searchParams.get('type')
            if($('input[name="id"]').val() && $('#is_single').prop('disabled') == true) {
                formData += '&is_single=on'
            }
            $('#submit-btn').html('<i class="fa fa-spinner fa-spin"></i> '+'Lưu').attr("disabled", true);

            saveProduct(formData);
       })

       function saveProduct(formData){
        $.ajax({
            type: 'POST',
            url: '{{ route('private-system.product.save') }}',
            data: formData,
            dataType: 'json',
            success: function(result) {
                if(result.status == 'success'){
                    show_message(result.message,result.status)
                    window.location.href = result.redirect;
                }
                else if(result.status == 'error'){
                    $('#submit-btn').html('<i class="fa fa-save"></i> Lưu').attr("disabled", false);
                    show_message(result.message,result.status);
                    return false;
                }

                $('#submit-btn').html('<i class="fa fa-save"></i> Lưu').attr("disabled", false);
            }
        }).fail(function(result) {
            $('#submit-btn').html('<i class="fa fa-save"></i> Lưu').attr("disabled", false);
            show_message('Lỗi dữ liệu', 'error');
            return false;
        });
       }

       function treeSelect2I(id){
            const domElement2 = document.querySelector('.tree_select_demo_main_category_variant_'+id)
            const treeselect2 = new Treeselect({
                parentHtmlContainer: domElement2,
                value: @json($model) ? @json($categories_main ?? []) : [],
                options: @json($category_main ?? []),
                placeholder: '-- Chon thuộc tính sản phẩm variant ' + id + ' --',
                isSingleSelect: false,
            })

            treeselect2.srcElement.addEventListener('input', (e) => {
                $('#categories_main_variant_'+id).val(e.detail );
            })
       }

       $('#btn_edit_attribute').on('click',function(){
           let _this = $(this);
           let id = _this.data('id');
           let find = $('.item_variant_'+id);
       })
      
       function loadCustom(){
            $('.load-attribute-custom').select2({
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
       }

       

     
</script>
@endsection