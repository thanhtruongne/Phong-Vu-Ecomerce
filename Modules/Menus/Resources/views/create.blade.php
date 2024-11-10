@extends('backends.layouts.layouts')


@section('page_title')

@section('breadcrumbs')
    @php
        $breadcum = [
            [
                'name' => 'Quản lý danh mục menus',
                'url' => '/'
            ],
            [
                'name' => 'Tạo menus',
                'url' => '/'
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
                <div class="">
                    <form action="{{ route('private-system.menus.save') }}" id="form_save" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                 
                        <div class="row">    
                            <div class="col-lg-4">    
                                <div class="ibox-content">
                                    <div>
                                        <div>
                                            <label class="control-label" style="margin-bottom: 8px">Chọn phần vị trí tạo <span class="text-danger">(*)</span></label>
                                            <select name="menu_cateloge_id" id="" class="select_custom form-control finding_select_choose_menu" data-placeholder="-- Danh mục menus --">            
                                                @if (isset($menu_cateloge) && !empty($menu_cateloge))
                                                    @foreach ($menu_cateloge as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body mt-4">
                                    <button type="button" class="btn add_item_content_menu">Thêm menu <i class="fa fa-plus"></i></button>
                                </div>
                            </div>     
                            
                            <div class="col-lg-7">
                                <div class="ibox-content">
                                    <div class="col-name d-flex" style="height: 25px">
                                        <div class="col-lg-3">
                                            Tên menu
                                        </div>
                                        <div class="col-lg-3">
                                            Đường dẫn
                                        </div>
                                        <div class="col-lg-2">
                                            Hình ảnh
                                        </div>
                                        <div class="col-lg-1">
                                            Xóa
                                        </div>
                                    </div>
                                    <div class="row_content">
                                        {{-- Render row --}}
                                    </div>
                                </div>
                            </div>
                        </div> 
                               
                    </form>
                </div>
            </div>
            <div class="form-group text-right mr-3">
                <div class="col-sm-offset-2">
                    <button  class="btn save" type="button" onclick="save()">Tạo mới</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $(document).on('click','.add_item_content_menu',function(e) {
            e.preventDefault();
           let _this = $(this);
           $('.row_content').append(CreatingTheRowContent()).prev().hide();
        })

        function CreatingTheRowContent(res = null) {
            let row = $('<div>').addClass('row content_item '+ (res?.url ? res?.url : '') + '').attr('style','height: 40px;margin:12px 0');
            let option = [
                { 'name' : 'menu[name][]', 'class' : 'col-lg-3' , 'value' : res?.name ? res?.name : '','input_class' :'form-control' },
                { 'name' :'menu[url][]', 'class' : 'col-lg-3' ,'value' :  res?.url ? res?.url : '','input_class' :'form-control'},
                { 'name' : 'menu[image][]', 'class' : 'col-lg-2 ckfinder_12','value' : '','input_class' :'form-control' },
            ]
            option.forEach(val => {
                let input = $('<input>').attr('type','text').attr('name',val?.name).addClass(val?.input_class).val(val?.value);  
                let column = $('<div>').addClass(val?.class).append(input);
                row.append(column);
            })
            let xmark = $('<button>').attr('style','font-size: 16px').addClass('delete_menu_item_input btn').append('<i class="fa fa-trash"></i>');
            let trashDiv = $('<div>')
                .addClass('col-lg-1').attr('style','height: 32px;display:flex;justify-content:center;align-items:center;cursor: pointer')
                .append(xmark);
            row.append(trashDiv);
            return row;
        }
       
        $(document).on('click','.delete_menu_item_input',function(e) {
            let _this = $(this);
            _this.parents('.content_item').remove();
            CheckLengthMenuItem();
            e.preventDefault();
        })
    
        function CheckLengthMenuItem () {
            if($('.content_item').length == 0) $('.title_show_content').show();
        }

        function save(){
            let item = $('.save');
            let oldtext = item.html();
            item.html('<i class="fa fa-spinner fa-spin"></i>');
            item.attr('disabled', true);
            event.preventDefault();
            $.ajax({
                    url: "{{ route('private-system.menus.save') }}",
                    type: 'POST',
                    data: $("#form_save").serialize(),
                }).done(function(data) {
                    console.log(data);
                    item.html(oldtext);
                    $('.save').attr('disabled', false);
                    if (data && data.status == 'success') {
                        show_message(data.message, data.status);
                        if(data?.redirect){
                            window.location.href = data?.redirect;
                        }
                    } else {
                        show_message(data.message, data.status);
                    }
                    return false;
                }).fail(function(data) {
                    item.html(oldtext);
                    $('.save').attr('disabled', false);
                    show_message('Lỗi dữ liệu', 'error');
                    return false;
                });
        }
    </script>
@endsection