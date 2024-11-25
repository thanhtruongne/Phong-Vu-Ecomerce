@extends('backends.layouts.layouts')


@section('page_title')

@section('breadcrumbs')
    @php
        $breadcum = [
            [
                'name' => trans('admin.manager_widget'),
                'url' => route('private-system.widget')
            ],
            [
                'name' => 'Tạo widget',
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

@section('content')

    <div class="row bg-white backend-container pt-3" style="margin-left: -15px;margin-right:-15px">
        <div class="col-md-12 pb-3">
            <div class="">
           
                <div class="row">
                    <form id="form-widget-save" class="w-100 form-horizontal form-ajax" style="padding: 0 15px" enctype="multipart/form-data">
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
                                                <label class="control-label" style="margin-bottom:10px">Tên widget <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" name="name" value="{{ $model->name }}" class="form-control">
                                                </div>           
                                            </div>
                                            <div class="form-group col-lg-5">                               
                                                <label class="control-label" style="margin-bottom:10px">Từ khóa <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" name="keyword" value="{{ $model->keyword }}" class="form-control">
                                                </div>           
                                            </div>
                                        </div>     
                                            <div class="form-group col-lg-8">                               
                                                <label class="control-label" style="margin-bottom:10px">Mã <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                    <input type="text" name="short_code" value="{{ $model->short_code }}" class="form-control">
                                                </div>           
                                            </div>
                                        <div class="form-group">                               
                                            <label class="control-label" style="margin-bottom:10px">Mô tả <span class="text-danger">(*)</span></label>
                                            <div class="">
                                                <textarea name="content" class="editor" data-target="content" id="content" cols="30" rows="10">{!! $model->content !!}</textarea>
                                           
                                            </div>           
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" style="margin-bottom:10px">Hình ảnh <span class="text-danger">(*)</span></label>
                                            <div class="">
                                                <div class="text-center" style="border: 1px solid #ccc">
                                                    <div class="check_hidden_image_album ckfinder_12">
                                                        <input type="hidden" name="image" value="{{$model->image}}"/>
                                                        <img class="{{$model->image ? 'w-100 object-fit-cover' : ''}}"  width="{{$model->image ? '' : 120}}" src="{{$model->image ? $model->image : 'https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg'}}" alt="">
                                                        {{-- <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div> --}}
                                                    </div>                                
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-lg-7" style="height: 500px">
                                <div class="ibox-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Thông tin Widget</h4>
                                    </div>
                                    <div class="mt-2">
                                        <input type="text" class="form-control search_model_keyword col-lg-7" placeholder="Tìm kiếm sản phẩm">
                                        <div class="search_model_result hidden w-100" style="background-color: #f3f3f3;height: auto;">
                                                    
                                        </div>
                                        <div class="model_table_search_result" style="margin: 12px 0">
                                            @if ($model->id && $model->model_id)
                                                @foreach ($model->model_id as $index => $value) 
                                                    <div 
                                                    class="item_result d-flex justify-content-between align-items-center" 
                                                    id="check-{{$value['sku']}}"
                                                    data-id="{{$value['product_id']}}"
                                                    data-code="{{$value['sku']}}"
                                                    data-variant_id="{{$value['variant_id']}}"
                                                    data-name="{{$value['name']}}"
                                                    data-image="{{$value['image']}}"
                                                    style="margin:12px 0">
                                                        <div class="d-flex align-items-center">
                                                            <div style="margin-right: 12px" class="thumbnail_image">
                                                                <img width="50" height="50" src="{{$value['image']}}" alt="">
                                                                <input type="hidden" name="model_id[product_id][]" value="{{$value['product_id']}}"/>
                                                                <input type="hidden" name="model_id[variant_id][]" value="{{$value['variant_id']}}"/>
                                                                <input type="hidden" name="model_id[code][]" value="{{$value['sku']}}"/>
                                                                <input type="hidden" name="model_id[name][]" value="{{$value['name']}}"/>
                                                                <input type="hidden" name="model_id[image][]" value="{{$value['image']}}"/>
                                                            </div>
                                                            <div>
                                                                <h4>{{$value['name']}}</h4>
                                                            </div>
                                                        </div>
                                                        <div class="" style="width:10%">
                                                            <button type="button" class="btn iconic_render"> <i class="fas fa-trash"></i></button>
                                                        </div>
                                            
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
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
<script>
    
   
    $('#form-widget-save').submit(function(e){   
        e.preventDefault();
        var formData = $(this).serialize();
        var content = CKEDITOR.instances['content'].getData();
        formData += '&content=' + encodeURIComponent(content)

        $('#submit-btn-data').html('<i class="fa fa-spinner fa-spin"></i> '+'Lưu').attr("disabled", true);

        saveWidgettData(formData);
    })

    function saveWidgettData(formData){
        $.ajax({
            type: 'POST',
            url: '{{ route('private-system.widget.save') }}',
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

   

    const debouncedSearch = debounce(function () {
        const search = $(".search_model_keyword").val().trim();
        if(search) {
            $.ajax({
                type: 'GET',
                url: '{{route('private-system.widget.getDataProduct')}}',
                data : {
                    keyword : search
                },
                success : function(data){
                    if(data) {
                        $('.search_model_result').removeClass('hidden');
                        $('.search_model_result').html('');
                        $.each(data?.rows,function(index , val) {
                            $('.search_model_result').append(createRowSearchingModel(val));
                        })
                    }
                    else {
                        $('.search_model_result').addClass('hidden');
                    }
                },
                error : function(error) {
                    console.log(error)
                },
            })
        }
    }, 400); 

    $('.search_model_keyword').on('keyup',debouncedSearch)

    function createRowSearchingModel(data = null) {
        let html =  `
            <div class="item_search_icon d-flex justify-content-between align-items-center"
                id="check-${data?.product_sku ? data?.product_sku : data?.variant_sku}"
                style="padding: 12px 16px;font-size:13px" 
                data-image="${data?.image ? data?.image : data?.variant_album}"
                data-name="${data?.product_name ? data?.product_name : data?.variant_name}"
                data-code="${data?.product_sku ? data?.product_sku : data?.variant_sku}"
                data-id="${data?.product_id}"
                data-variant_id="${data?.variant_id}">
                <div>        
                    <img width="100" src="${data?.image ? data?.image : data?.variant_album}"/>
                </div>  
                <div>        
                    ${data?.product_name ? data?.product_name : data?.variant_name}
                </div>  
                <div class="auto_icon_check">
                
                </div>
            </div>`;
        return html;
    }

    function CreateTheDataAfterSearching(option) {
        console.log(option);
        let html =
        `
        <div 
        class="item_result" 
        id="check-${option?.sku_code}"
        data-id="${option?.id}"
        data-code="${option?.sku_code}"
        data-variant_id="${option?.variant_id}"
        data-name="${option?.name}"
        data-image="${option?.image}"
        style="margin:12px 0;display: flex;justify-content:space-between;align-items:center">
            <div style="display: flex;align-items:center">
                <div style="margin-right: 12px" class="thumbnail_image">
                    <img width="50" height="50" src="${option?.image}" alt="">
                    <input type="hidden" name="model_id[product_id][]" value="${option?.variant_id != "null" ? null : option?.id}"/>
                    <input type="hidden" name="model_id[variant_id][]" value="${option?.variant_id ? option?.variant_id : null}"/>
                    <input type="hidden" name="model_id[code][]" value="${option?.sku_code}"/>
                     <input type="hidden" name="model_id[name][]" value="${option?.name}"/>
                    <input type="hidden" name="model_id[image][]" value="${option?.image}"/>
                </div>
                <div>
                    <h4>${option?.name}</h4>
                </div>
            </div>
            <div class="" style="width:10%">
                <button type="button" class="btn iconic_render"> <i class="fas fa-trash"></i></button>
            </div>

        </div>
        `;return html;
    }
    function ConvertTheStringSnake(string) {
        return string.replace(/\W+/g, " ")
                .split(/ |\B(?=[A-Z])/)
                .map(word => word.toLowerCase())
                .join('_');
    }
    $('body').on('click','.item_search_icon',function() {
        let _this = $(this);
        let option = {
            'name' : _this.attr('data-name'),
            'image' : _this.attr('data-image'),
            'id' : _this.attr('data-id'),
            'sku_code' : _this.attr('data-code'),
            'variant_id' : _this.attr('data-variant_id')
        }   
        if($('.model_table_search_result').find('#check-'+option?.sku_code).length == 1) {
            show_message('Sản phẩm đã tồn tại','warning');
            return false;
        }
        $('.model_table_search_result').append(CreateTheDataAfterSearching(option));   
        _this.find('.auto_icon_check').html('<i class="fa fa-check"></i>');
    })

    $('body').on('click','.iconic_render',function() {
        let _this = $(this);
        let code = _this.parents('.item_result').attr('data-code');
        _this.parents('.item_result')
        .parents('.model_table_search_result')
        .prev().find('#check-'+code).find('.auto_icon_check').html('');
        _this.parents('.item_result').remove();
    })
        
   
</script>
@endsection