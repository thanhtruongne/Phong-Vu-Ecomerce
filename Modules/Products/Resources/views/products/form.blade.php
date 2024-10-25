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
                                                <textarea name="desc" class="editor" data-target="desc" id="desc" cols="30" rows="10">{{$model->desc}}</textarea>
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
                                                    <div class="check_hidden_image_album {{ isset($model->galley) && !empty($model->galley) && $model->galley != 'null' ? 'hidden' : '' }}">
                                                        <img class="ckfinder_3" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                                                        <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
                                                    </div>
                                                    <div class="ul_upload_view_album clearfix py-2 sortable" style="list-style-type: none">
                                                        
                                                        @if (isset($model) && !empty($model))
                                                            @php
                                                                $album =  json_decode($model->galley) ?: [];
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
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                               Sản phẩm variant
                                            </label>
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" {{$model && $model->is_single == 2 ? 'checked' : ''}} id="is_single" name="is_single" class="form-control mt-1">
                                                        <span class="ml-3">( Sản phẩm đơn hoặc có nhiều phần variants con. )</span>
                                                    </div>
                                                    <button class="btn create_variant" disabled type="button"><i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- render variant --}}
                                        <div class="form-group variant_child {{$model && $model->is_single == 2 ? '' : 'hidden'}} ">
                                             {{-- @if (isset($model->product_variant) && count($model->product_variant) > 0)
                                                 @foreach ($model->product_variant as $variant)
                                                     
                                                 @endforeach
                                             @endif --}}
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
                                                <input type="text" {{$model && $model->is_single == 2 ? 'disabled' : ''}} class="form-control integerInput" name="sku" value="{{$model->sku}}"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-8 control-label">
                                                Số lượng
                                                <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" {{$model && $model->is_single == 2 ? 'disabled' : ''}} class="form-control integerInput" name="qualnity" value="{{$model->qualnity}}">
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
                                               <input type="hidden" value="{{$model->product_cateloge_id}}" name="category_id" id="category_id">
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
                                                            $attributes = \Modules\Products\Entities\Attribute::whereNull('parent_id')->get();
                                                            if($model && $model->id > 0){
                                                                foreach ($model->attributes as $key => $item) {
                                                                    $attribute = \Modules\Products\Entities\Attribute::where('id',$item->id)->first();
                                                                    $item->parent_name = $attribute->ancestors->first()->name;
                                                                }   
                                                            }
                                                       @endphp
                                                        @if (isset($attributes))
                                                            @foreach ($attributes as $attribute)
                                                                <a class="dropdown-item attribute_choose" data-parent="{{$attribute->id}}" >{{ $attribute->name }}</a>
                                                            @endforeach
                                                        @endif   
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                   
                                        <div class="render_attribute_parent">
                                              {{-- @if ($model->attributes && $model->attributes->count() > 0)
                                                  @foreach ($model->attributes->pluck('name','id') as $key => $item)
                                                        @php
                                                            $attribute = \Modules\Products\Entities\Attribute::where('id',$key)->first();
                                                        @endphp
                                                        <div class="form-group d-flex algin-items-center attribute_item">
                                                            <div style="width:65%">
                                                                <label for="" class="control-label fw-bold">
                                                                        {{$attribute->ancestors->first()->name ?: null}}
                                                                    <span class="text-danger">(*)</span>
                                                                </label>
                                                                <div class="">
                                                                    <select name="attribute[]" class="form-control load-attribute-custom" data-parent="{{$attribute->parent_id}}" data-placeholder="--   {{$attribute->name}}--">
                                                                        <option value="{{$key}}" selected>{{$item}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div style="margin-left:20px;"> <button type="button" class="btn remove_item_attribute"><i class="fas fa-trash" ></i></button></div>
                                                        </div>
                                                  @endforeach
                                              @endif --}}
                                        </div>
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
<script>

    $(document).ready(function(){
        function load_attrbute(id = null){
            if(id){
                $('#load-attribute-custom_'+id).select2({
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
        //trường hợp edit
        if($('input[name="id"]').val()){
       
          if(@json($model) && @json($model->is_single) != 2){
              let render = $('.render_attribute_parent');
              $.each(@json($model->attributes),function(index,value){
                  console.log(value);
                  render.append(`
                      <div class="form-group d-flex algin-items-center attribute_item">
                          <div style="width:65%">
                              <label for="" class="control-label fw-bold">
                                  ${value.parent_name}
                                  <span class="text-danger">(*)</span>
                              </label>
                              <div class="">
                                  <select name="attribute[]" class="form-control" id="load-attribute-custom_${value.id}" data-parent="${value.parent_id}" data-placeholder="-- ${value.parent_name} --"> 
                                       <option value="${value.id}" selected>${value.name}</option>
                                  </select>
                              </div>
                          </div>
                          <div style="margin-left:20px;"> <button type="button" class="btn remove_item_attribute"><i class="fas fa-trash" ></i></button></div>
                      </div>`);
                      load_attrbute(value.id);
                  })
          }
          else {
           //render variant
            let variants = @json($model->product_variant);
            let renderAttribute = $('.variant_child');
            let countStep = 0;
            $.each(variants,function(index,value){
                let attributeHtml = '';
                let html = '';
                let arr = [];
                //load attributes variant
                $.each(variants.attribute,function(key,item){
                    countStep++;
                    arr.push(item.id)
                    attributeHtml .= `
                        <div style="padding: 0 7.5px;" class="form-group d-flex align-items-center attribute_item_variant_${countStep}">
                            <div style="width:30%">
                                <label for="" class="control-label fw-bold">
                                    ${item.parent_name}
                                    <span class="text-danger">(*)</span>
                                </label>
                                <div class="">
                                    <select name="attribute[${index}][]" class="form-control load-attribute-custom" data-parent="${item.parent_id}" data-placeholder="-- ${item.parent_name} --">
                                        <option value=""${item.id}" selected>${item.name}</option>
                                    </select>
                                </div>
                            </div>
                            <div style="margin-left:20px;"> <a onclick="removeVariant(${countStep})" class="btn remove_variant_item"><i class="fas fa-trash" ></i></a></div>
                        </div> `
                })
                // load variant
                $.each(@json($attributes),function(calc,attribute){
                    html += `<a class="dropdown-item ${arr.includes(attriubte['id']) ? 'disabled' : ''}" onclick="onClickCreateAttributeVariant(${item['id']},${index})" data-id="${index}" data-parent="${item['id']}" >${item['name']}</a>`
                })
                //load hình ảnh
                // let album = JSON.parse()
                let album = '';
                $(value.album,function(i,image){
                  album.=`
                    <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                        <img height="120" src="${image}" width="150" alt="">
                        <input type="hidden" name="variant_album[${index}][]" value="${image}"/>
                        <button type="button" class="trash_album btn bg-red" >
                            <i class="fas fa-trash text-white" ></i>
                        </button >
                    </li>
                  `
                })

                renderAttribute.append(`
                    <div class="form-group row variant_item_attribute_pa item_variant_attribute_${index}" >
                        <div class="col-sm-2">
                                <div>
                                    Variant <span class="text-danger">(*)</span> 
                                </div>  
                            </div>
                        <div class="col-md-8" style="border:1px solid #ccc; border-radius:8px;padding:15px;">
                            <div class="form-group item_variant_${index}">
                            
                            </div>   
                            <div>
                                <div class="form-group item_variant_attribute_${index}">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">
                                            Mã SKU
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control integerInput" value="${value.sku}" name="sku[${index}]">
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">
                                        Số lượng
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control  value="${value.qualnity}" integerInput" name="qualnity[${index}]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">
                                        Giá tiền
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <div class="col-md-8">
                                        <input  class="form-control number-format" value="${value.price}" name="cost[${index}]" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">
                                        Galley Image
                                    </label>
                                    <div class="col-md-12">
                                        <div class="text-center" style="border: 1px solid #ccc">
                                            <div class="check_hidden_image_album">
                                                <img class="ckfinder" data-id="${index}" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                                            </div>
                                            <div class="ul_upload_view_album clearfix py-2 sortable" style="list-style-type: none">
                                                    ${album}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        
                        </div>    
                        <div class="dropdown ml-2">
                            <button class="btn dropdown-toggle" type="button" data-id="${index}" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-plus"></i> 
                                    Attribute
                            </button>
                            <div class="dropdown-menu toggle_variant">
                                ${html}
                            </div>
                        </div>   
                    </div>
                `)
               
            })
          }
      }
    })
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
            value: @json($model) ? @json($model->product_cateloge_id) :  [],
            options: @json($categories),
            placeholder: '-- Chon danh mục sản phẩm --',
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
                $('input[name="qualnity"]').prop('disabled',true);
                $('.render_attribute_parent').addClass('hidden');
                $('.render_attribute_parent .attribute_item select').prop('disabled',true);
                $('body .add_attribute').prop('disabled',true);
                //variant
                $('.variant_child').removeClass('hidden');
                $('body .create_variant').prop('disabled',false)
            }
            else {
                $('input[name="sku"]').prop('disabled',false);
                $('input[name="cost"]').prop('disabled',false);
                $('input[name="qualnity"]').prop('disabled',false);
                $('.render_attribute_parent').removeClass('hidden');
                $('.render_attribute_parent .attribute_item select').prop('disabled',false);
                $('body .add_attribute').prop('disabled',false);
                $('.variant_child').addClass('hidden')
                $('body .create_variant').prop('disabled',true)
            }
        })
        let count = 1;

       //variant
       $('body .create_variant').on('click',function(){
          let parent = $('.variant_child');
          let sumAvg = count++;
          let html = '';
          $.each(@json($attributes),function(index,item){
            html += `<a class="dropdown-item " onclick="onClickCreateAttributeVariant(${item['id']},${sumAvg})" data-id="${sumAvg}" data-parent="${item['id']}" >${item['name']}</a>`
          })
          parent.append(`
           <div class="form-group row variant_item_attribute_pa item_variant_attribute_${sumAvg}" >
                <div class="col-sm-2">
                        <div>
                            Variant <span class="text-danger">(*)</span> 
                        </div>  
                    </div>
                <div class="col-md-8" style="border:1px solid #ccc; border-radius:8px;padding:15px;">
                    <div class="form-group item_variant_${sumAvg}">
                       
                    </div>   
                    <div>
                        <div class="form-group item_variant_attribute_${sumAvg}">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">
                                    Mã SKU
                                </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control integerInput" name="sku[${sumAvg}]">
                                </div>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">
                                Số lượng
                                <span class="text-danger">(*)</span>
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control integerInput" name="qualnity[${sumAvg}]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">
                                Giá tiền
                                <span class="text-danger">(*)</span>
                            </label>
                            <div class="col-md-8">
                                <input  class="form-control number-format" name="cost[${sumAvg}]" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">
                                Galley Image
                            </label>
                            <div class="col-md-12">
                                <div class="text-center" style="border: 1px solid #ccc">
                                    <div class="check_hidden_image_album">
                                        <img class="ckfinder" data-id="${sumAvg}" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                                    </div>
                                    <div class="ul_upload_view_album clearfix py-2 sortable" style="list-style-type: none">
                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                  
                </div>    
                <div class="dropdown ml-2">
                    <button class="btn dropdown-toggle" type="button" data-id="${sumAvg}" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-plus"></i> 
                            Attribute
                    </button>
                    <div class="dropdown-menu toggle_variant">
                        ${html}
                    </div>
                </div>   
            </div>
          `)
       })


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
                            <select name="attribute[${parent_id}][]" class="form-control load-attribute-custom" data-parent="${id}" data-placeholder="-- ${name} --"></select>
                        </div>
                    </div>
                    <div style="margin-left:20px;"> <a onclick="removeVariant(${id})" class="btn remove_variant_item"><i class="fas fa-trash" ></i></a></div>
                </div>`);
            $(hrefItem).addClass('disabled');
            load_attrbute();
       }

       function removeVariant(id){
          let attribute = $('.attribute_item_variant_'+id);
          let parents = $(attribute).parents('.variant_item_attribute_pa');
          let toggle = $(parents).find('.toggle_variant').find('a[data-parent="'+id+'"]').removeClass('disabled');
          $(attribute).remove();

       }

       $('#form-create-product').submit(function(e){
           e.preventDefault();
           var formData = $(this).serialize();
            // do không lấy được input content, nên thêm mã hóa nội dung để truyền vào
            var content = CKEDITOR.instances['content'].getData();
            var desc = CKEDITOR.instances['desc'].getData();
            formData += '&content=' + encodeURIComponent(content) + '&desc=' + encodeURIComponent(desc)

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
                console.log(result)
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



       $('#btn_edit_attribute').on('click',function(){
           let _this = $(this);
           let id = _this.data('id');
           let find = $('.item_variant_'+id);
       })

</script>
@endsection