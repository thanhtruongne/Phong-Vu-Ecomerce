@extends('backends.layouts.layouts')


@section('page_title')

@section('breadcrumbs')
    @php
        $breadcum = [
            [
                'name' => trans('admin.manager_promotion'),
                'url' => route('private-system.promotions.index')
            ],
            [
                'name' => 'Tạo khuyến mãi',
                'url' => '#'
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

    <div class="row bg-white backend-container pt-3" style="margin-left: -15px;margin-right:-15px">
        <div class="col-md-12 pb-3">
            <div class="">
           
                <div class="row">
                    <form id="form-create-promotion" class="w-100 form-horizontal form-ajax" style="padding: 0 15px" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$model->id}}">
                        <div class="ibox-title d-flex justify-content-between my-3" style="padding: 0 5px">                          
                            <span class="btn">Thông tin chung</span>
                            <button class="btn" id="submit-btn-data" type="submit">Lưu <i class="fa fa-save"></i></button>
                        </div> 
                        <div class="w-100 d-flex">
                            <div class="col-lg-5">
                                <div>
                                    <div class="ibox-content">
                                        <div class="" style="display: flex;justify-content:space-between">
                                            <div class="form-group col-lg-5">                               
                                                <label class="control-label" style="margin-bottom:10px">Tên chương trình <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" name="name" value="{{ $model->name }}" class="form-control">
                                                </div>           
                                            </div>
                                            <div class="form-group col-lg-5">                               
                                                <label class="control-label" style="margin-bottom:10px">Mã khuyến mãi <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" {{ $model && $model->code ? 'readonly' : ''}}  name="code" value="{{ $model->code }}" class="form-control">
                                                </div>           
                                            </div>
                                        </div>
                                        <div class="" style="display: flex;justify-content:space-between">
                                            <div class="form-group col-lg-5">                               
                                                <label class="control-label" style="margin-bottom:10px">Giá khuyến mãi <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" name="amount" value="{{ $model->amount }}" class="form-control number-format" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                                </div>           
                                            </div>
                                            <div class="form-group col-lg-5">                               
                                                <label class="control-label" style="margin-bottom:10px">Hình ảnh</label>
                                                <div class="ckfinder_12">
                                                    <input type="hidden" name="image" class="form-control" value="{{$model->thumbnail}}">
                                                    <img class="object-fit-cover" style="width:45%;" src={{ $model->thumbnail ?? "https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" }} alt="">
                                                </div>           
                                            </div>
                                        </div>
    
                                    
                                        <div class="form-group">                               
                                            <label class="control-label" style="margin-bottom:10px">Mô tả khuyến mãi <span class="text-danger">(*)</span></label>
                                            <div class="">
                                                <textarea name="description" class="editor" data-target="description" id="description" cols="30" rows="10">{!! $model->description !!}</textarea>
                                           
                                            </div>           
                                    </div>
                                    </div>
                                    <div class="ibox-content mt-3">
                                        <div class="ibox-title" style="min-height:60px">                          
                                        Thời gian thiết lập
                                        </div>                        
                                        <div class="">
                                            <div class="" style="margin-top: 8px">
                                                <label class="control-label"  style="margin-bottom:8px">Thời gian bắt đầu <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                    <input type="text"  value="{{ $model->startDate }}" name="startDate" class="form-control datepicker">
                                                </div>
                                            
                                            </div>
                                            <div class="" style="margin-top: 8px">
                                                <label class="control-label"  style="margin-bottom:8px">Thời gian kết thúc <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                    <input type="text" value="{{  $model->endDate }}"  name="endDate" {{$model && $model->neverEndDate == 1 ? 'disabled' : ''}} class="form-control datepicker">
                                                </div>
                                            
                                            </div>
    
                                            <div class="" style="margin-top: 16px">
                                                <input type="checkbox" 
                                                    {{ $model && $model->neverEndDate == 1 ? 'checked' : '' }}
                                                    value="1" 
                                                    class="no_date_promotion" id="no_date_promotion" name="neverEndDate">  
                                                <label 
                                                for="no_date_promotion"
                                                    style="position: relative; top: -2px;" s
                                                    class="control-label">
                                                    Không có mốc thời gian kết thúc
                                            </label>                         
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7" style="height: 500px">
                                <div class="ibox-content">
                                    <div class="form-group col-lg-5">                               
                                        <label class="control-label" style="margin-bottom:10px">Loại khuyến mãi<span class="text-danger">(*)</span></label>
                                        <div class="">
                                            <select name="type" class="form-control select_custom" id="custom_validate_selet" data-placeholder="-- Loại khuyến mãi --">
                                                <option value="">Chọn loại khuyến mãi</option>
                                                <option {{$model && $model->type == 1 ? 'selected' : ''}} value="1">Theo danh mục sản phẩm</option>
                                                {{-- <option value="2">Theo sản phẩm (đơn)</option> --}}
                                                <option {{$model && $model->type == 3 ? 'selected' : ''}} value="3">Theo nhiều sku sản phẩm</option>
                                                <option value="4" disabled>Theo thuộc tính sản phẩm</option>
                                            </select>
                                        </div>           
                                    </div>
                                    <div class="mt-3 render_attribute_attemps">
                                        
                                    </div>
    
    
    
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


    if($('input[name="id"]').val() && @json($model->id)) {
        let render = $('.render_attribute_attemps');
        render.html(`
            <div class="">
                <div style="position: relative" class="col-lg-6 mb-4">
                    <label class="control-label mb-2" >Tìm kiếm sản phẩm </label>
                    <input type="text" value="" class="form-control on_keyup_promotion_product" placeholder="-- Tìm kiếm sản phẩm --">
                    <span style="position: absolute;top: 9px;left: 16px;font-size: 18px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <span class="loading hidden" style="position: absolute;top: 7px;right: 11px;font-size: 21px;">
                        <i class="fa-solid fa-spinner fa-spin-pulse"></i>
                    </span>
                </div>
                <div class="data_render_product_promotion" style="overflow:auto">
                       
                </div>
                <div class="paganation_render">
                 
                </div>
            </div>
        `)
        let value = null
        if($('input[name="id"]').val()) {
            value = {
                'product' : @json($model->products->pluck('sku_code')),
                'variant' : @json($model->sku_variants->pluck('sku_code'))
            }
        }
        AjaxGetProductPromotion(value)
    }

    const VND = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    });
    var promotion = [];
    var data_value = [];
     function treeSelect(){
        const domElement = document.querySelector('.tree_select_demo_main')
        const treeselect = new Treeselect({
            parentHtmlContainer: domElement,
            value: [],
            options: @json($categories ?? []),
            placeholder:  '-- Chon danh mục sản phẩm --',
            isSingleSelect: false,
        })

        treeselect.srcElement.addEventListener('input', (e) => {
            $('#category_id').val(e.detail );
        })
    }
    $('.datepicker').datetimepicker({
        // timepicker: true,
        format : 'd/m/Y H:i',
        minDate : new Date()
    });

    $(document).on('click','.no_date_promotion',function() {
        let _this  = $(this);
        if(_this.prop('checked') == true) {
            _this.parents('div').prev().find('input[name="endDate"]').val('').attr('disabled',true);
        }
        else {
            _this.parents('div').prev().find('input[name="endDate"]').val('').removeAttr('disabled');
        }
    })

    $('body').on('change','#custom_validate_selet',function(){
        let _this = $(this);
        let html = '';
        let render = $('.render_attribute_attemps');
        render.html(' ');
        if(_this.val() == 1) {
            html = `<div class="tree_select_demo_main"></div>
            <input type="hidden" name="category_id" id="category_id">`;
            render.html(html);
            treeSelect();
        }
        if(_this.val() == 2  || _this.val() == 3 ) {
            render.html(`
            <div class="">
                <div style="position: relative" class="col-lg-6 mb-4">
                    <label class="control-label mb-2" >Tìm kiếm sản phẩm </label>
                    <input type="text" value="" class="form-control on_keyup_promotion_product" placeholder="-- Tìm kiếm sản phẩm --">
                    <span style="position: absolute;top: 9px;left: 16px;font-size: 18px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <span class="loading hidden" style="position: absolute;top: 7px;right: 11px;font-size: 21px;">
                        <i class="fa-solid fa-spinner fa-spin-pulse"></i>
                    </span>
                </div>
                <div class="data_render_product_promotion" style="overflow:auto">
                       
                </div>
                <div class="paganation_render">
                 
                </div>
            </div>
            `)
            AjaxGetProductPromotion()
        }
    })

    function AjaxGetProductPromotion(value = null){
        $.ajax({
            type: 'GET',
            url:  '{{route('private-system.promotions.getData.promtions')}}',
            data : value,
            success : function(data){         
                if(data?.rows) {
                    let model = $('.change_keyup_promotion_select2').attr('data-model');
                    let render = ObjectProductPromotion(data?.rows?.data,promotion,value)
                    let links = data?.rows?.links;
                    if(data?.rows?.data.length == 0) {
                        $('.data_render_product_promotion').html('<span class="text-danger">Trống</span>');
                        $('.paganation_render').html('');
                    }
                    else {
                        $('.data_render_product_promotion').html(render);
                        $('.paganation_render').html(PaginationPromotion(links));
                    }
                   
                }   
                else { 
                    $('.data_render_product_promotion').html('<h4 style="margin-top:20px">Không tìm thấy sản phẩm</h4>')
                }
            
            }
        }).fail(function(data) {
            show_message('Lỗi dữ liệu', 'error');
            return false;
        });
    }

    function ObjectProductPromotion(option , data = [],value = null) {
       let html = '';
       let check = [];
       if(data.length > 0) {
            $.each(data,function(key,item) {
                check.push(item?.checked);
            })
       }
       $.each(option , function(index , val) {
        if(val?.variant_id) {
            let variantIdCheck = val?.variant_sku;
            let album  = [];
            if(val?.variant_album) {
                album = JSON.parse(val?.variant_album)?.split(',');
            }
           
            html += `
                <div
                    class="data_item_promotion" 
                    data-name="${val?.variant_name}"
                    data-variantId="${val?.variant_id}"
                    data-sku="${val?.variant_sku}"
                    style="display:flex;justify-content:space-between;height: 96px;
                        margin: 12px 0 ;border-bottom: 1px solid #ccc;">
                        <div class="data_item" style="width:89%;
                        display:flex;justify-content:space-between;align-items:center">
                            <div style="width:5%">
                                <input type="checkbox"  ${(check.includes(variantIdCheck) == true ) || ( @json($model->id) && value != null && value['variant']?.includes(variantIdCheck)) ? 'checked' : ''} class="SendDataPromotion" id="product_${val?.product_id}_${val?.variant_id}" value="${val?.variant_id}" name="variant_id[]">
                            </div>
                            <div style="width:16%" class="image_thumbnail">
                                <img class="w-100" src="${album[0]}" alt="">
                            </div>
                            <div  style="width:70%" class="desc_translate_promotion">
                                <h6>${val?.variant_name}</h6>
                                <div class="text-info">
                                    <span>
                                        Mã Sku:
                                    </span>
                                    <p style="display:inline">${val?.variant_sku}</p>
                                </div>
                            </div>
                        </div>
                        <div class="" style="width:40%;position: relative;top: 37px;">
                            <div class="price" style="text-align: right">
                            <span class="fw-bold">${VND.format(val?.variant_price)}</span>
                            </div>
                            <div class="image_thumbnail" style="text-align: right">
                                <span>
                                    Tồn kho : <p style="display: inline-block" class="text-info">${val?.variant_stock}</p>
                                </span>
                            </div>
                        
                        </div>
                </div>`
        }
        else {
            let productIdCheck =  val?.product_sku;
            html += `
                <div
                    class="data_item_promotion" 
                    data-id="${val?.product_id}"
                    data-name="${val?.name}"
                    data-sku="${val?.product_sku}"
                    style="display:flex;justify-content:space-between;height: 96px;
                        margin: 12px 0 ;border-bottom: 1px solid #ccc;">
                        <div class="data_item" style="width:89%;
                        display:flex;justify-content:space-between;align-items:center">
                            <div style="width:5%">
                                <input type="checkbox" ${(check.includes(productIdCheck) == true) || (@json($model->id) &&  value && value['product']?.includes(productIdCheck)) ? 'checked' : ''} class="SendDataPromotion" id="product_${val?.product_id}" value="${val?.product_id}" name="product_id[]">
                            </div>
                            <div style="width:16%" class="image_thumbnail">
                                <img class="w-100" src="${val?.image}" alt="">
                            </div>
                            <div  style="width:70%" class="desc_translate_promotion">
                                <h6>${val?.product_name}</h6>
                                <div class="text-info">
                                    <span>
                                        Mã Sku:
                                    </span>
                                    <p style="display:inline">${val?.product_sku}</p>
                                </div>
                            </div>
                        </div>
                        <div class="" style="width:40%;position: relative;top: 37px;">
                            <div class="price" style="text-align: right">
                            <span class="fw-bold"> ${VND.format(val?.price)}</span>
                            </div>
                            <div class="image_thumbnail" style="text-align: right">
                                <span>
                                    Tồn kho : <p style="display: inline-block" class="text-info">${val?.quantity}</p>
                                </span>                       
                            </div>
                        
                        </div>
                </div>`
        }
       })
     
       return html;
    }
    function PaginationPromotion(links = null){
        if(links?.length >= 3) {
            let ul = $('<ul>').addClass('pagination justify-content-end mr-3');
    
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
                // .attr('data-model',model)
                .addClass('page-link')
                .text('<');
                li.append(span)
            }
            else if(val?.label == 'pagination.next') {
                let span = $('<a>')
                            .attr('href',nextTurnPage?.url)
                            .addClass('page-link')
                            .attr('rel','next')
                            .attr('data-id',nextTurnPage?.label)
                            .attr('aria-label','pagination.next')
                            // .attr('data-model',model)
                            .text('>');
                li.append(span)
            }
            else if(val?.url) {
                // let a = $('<a>').attr('href',val?.url).attr('data-model',model).addClass('page-link').text(val?.label);
                let a = $('<a>').attr('href',val?.url).addClass('page-link').text(val?.label);
                li.append(a);
            }
            ul.append(li);
            })

            let nav = $('<nav>').append(ul);
            return nav;
        }

    }

    $(document).on('click','.page-link',function(e) {  
        let _this = $(this);
        let  page = (_this.text() == '>' || _this.text() == '<') ? _this.attr('data-id') : _this.text();
        let option = {
            'page' : page
        }
        let value = null;
        if($('input[name="id"]').val()){
            value = {
                'product' : @json($model->id) &&  @json($model->products) != null ? @json($model->products->pluck('sku_code')) : null,
                'variant' : @json($model->id) &&  @json($model->sku_variants) != null ?   @json($model->sku_variants->pluck('sku_code')) : null
            }
        }
        AjaxGetProductPromotion(option,value);
        e.preventDefault();
    })

    $(document).on('click','.data_item_promotion',function(e) {    
        e.preventDefault();
        let _this = $(this);
        let checked = _this.find('input[type=checkbox]').prop('checked');
        let option = {
            'id' :  _this.attr('data-id'),
            'variant_id' : _this.attr('data-variantId'),
            'type' : _this.attr('data-variantId') ? 1 : 2,
            'name' : _this.attr('data-name'),
            'checked' :   _this.attr('data-sku'),
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

  
    $('#form-create-promotion').submit(function(e){   
            e.preventDefault();
            var formData = $(this).serialize();
            // do không lấy được input content, nên thêm mã hóa nội dung để truyền vào
            var desc = CKEDITOR.instances['description'].getData();
            formData += '&description=' + encodeURIComponent(desc) + '&promotion=' + JSON.stringify(promotion)
            
            $('#submit-btn-data').html('<i class="fa fa-spinner fa-spin"></i> '+'Lưu').attr("disabled", true);

            saveProductData(formData);
       })

       function saveProductData(formData){
        $.ajax({
            type: 'POST',
            url: '{{ route('private-system.promotions.save') }}',
            data: formData,
            dataType: 'json',
            success: function(result) {
                if(result.status == 'success'){
                    show_message(result?.message,result?.status)
                    window.location.href = result?.redirect;
                }
                else if(result.status == 'error'){
                    $('#submit-btn-data').html('<i class="fa fa-save"></i> Lưu').attr("disabled", false);
                    show_message(result.message,result.status);
                    return false;
                }

                $('#submit-btn-data').html('<i class="fa fa-save"></i> Lưu').attr("disabled", false);
            }
        }).fail(function(result) {
            $('#submit-btn-data').html('<i class="fa fa-save"></i> Lưu').attr("disabled", false);
            show_message('Lỗi dữ liệu', 'error');
            return false;
        });
       }

    $(document).on('keyup','.on_keyup_promotion_product',function() {
        let _this = $(this);
        let debounce;
        let option = {
            'search' : _this.val(),
        }   
        if(option?.search == '' || option?.search.length > 2) {
            if(debounce)  clearTimeout(debounce);
            debounce = setTimeout(() => {
                AjaxGetProductPromotion(option);
            },1000)
        }
    })

   
</script>
@endsection