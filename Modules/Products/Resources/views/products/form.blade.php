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
                                  <input type="hidden" name="id" value="">
                                  <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                                Tên sản phẩm
                                                <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                                Mô tả
                                            </label>
                                            <div class="col-md-8">
                                                <textarea name="desc" class="editor" data-target="desc" id="desc" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                               Nội dung
                                            </label>
                                            <div class="col-md-8">
                                                <textarea name="content" class="editor" data-target="content" id="content" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                               Galley Image
                                            </label>
                                            <div class="col-md-8">
                                                <div class="text-center" style="border: 1px solid #ccc">
                                                    <div class="check_hidden_image_album {{ isset($data->album) && !empty($data->album) && $data->album != 'null' ? 'hidden' : '' }}">
                                                        <img class="ckfinder_3" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                                                        <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
                                                    </div>
                                                    <div class="ul_upload_view_album clearfix py-2" style="list-style-type: none" id="sortable_books">
                                                        @if (isset($data) && !empty($data))
                                                            @php
                                                                $album = !is_array($data) ? json_decode($data->album) : ($data ?? []);
                                                            @endphp
                                                        @if (!empty($album) && count($album) > 0)
                                                            @foreach ($album as $item) 
                                                            <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                                                                <img height="120" src="{{ $item }}" width="150" alt="">
                                                                <input type="hidden" name="{{ $name }}[]" value="{{ $item }}"/>
                                                                <button type="button" class="trash_album" >
                                                                    <i class="fa-solid fa-trash"></i>
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
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" id="is_single" name="is_single" class="form-control mt-1">
                                                    <span class="ml-3">( Sản phẩm đơn hoặc có nhiều phần variants con. )</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="" class="col-sm-4 control-label">
                                            Hình ảnh
                                            </label>
                                            <div class="col-md-7">
                                                <div class="ckfinder_12" style="border: 1px solid #ccc;cursor: pointer;" data-type="image">
                                                    <input type="hidden" name="image" >
                                                    <img class="image" style="width:100%" src={{ old('image') ?? "https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" }} alt="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label">
                                                Mã SKU
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control integerInput" name="sku">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="col-sm-4 control-label">
                                                Giá tiền
                                               <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input  class="form-control number-format" name="cost" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label">
                                               Danh mục sản phẩm
                                               <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-8">
                                               <div class="tree_select_demo_main"></div>
                                               <input type="hidden" name="category_id" id="category_id">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8 text-right">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle add_attribute" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        Thêm attribute
                                                    </button>
                                                    <div class="dropdown-menu toggle_attribute">
                                                        @php
                                                            $attributes = \Modules\Products\Entities\Attribute::whereNull('parent_id')->get();
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
                            <select name="atttribute[]" class="form-control load-attribute-custom" data-parent="${id}" data-placeholder="-- ${name} --"></select>
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

        function load_attrbute(){
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
   
        $('body').on('click','.trash_album',function(e) {       
            $(this).parents('.item_album').remove();
            if($('.ul_upload_view_album li.item_album').length == 0) $('.ul_upload_view_album').prev().removeClass('hidden');
            e.preventDefault();
        })
        const domElement = document.querySelector('.tree_select_demo_main')
        const treeselect = new Treeselect({
            parentHtmlContainer: domElement,
            value: [],
            options: @json($categories),
            placeholder: '-- Chon danh mục sản phẩm --',
            isSingleSelect: true,
        })

        treeselect.srcElement.addEventListener('input', (e) => {
        console.log('Selected value:', e.detail)
            $('#category_id').val(e.detail );
        })

        $('#is_single').on('click',function(){
            let _this = $(this);
            if(_this.prop('checked')){
                $('input[name="sku"]').prop('disabled',true);
                $('input[name="cost"]').prop('disabled',true);
                $('.render_attribute_parent').addClass('hidden');
                $('body .add_attribute').prop('disabled',true);

            }
            else {
                $('input[name="sku"]').prop('disabled',false);
                $('input[name="cost"]').prop('disabled',false);
                $('.render_attribute_parent').removeClass('hidden');
                $('body .add_attribute').prop('disabled',false);
            }
        })

       //variant
       

</script>
@endsection