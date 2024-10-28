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
                'name' => 'Sản phẩm',
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
    .bootstrap-table .fixed-table-container .table thead th.detail {
    width: 30px;

    }
</style>


    <div class="row bg-white backend-container pt-3" style="margin-left: -15px;margin-right:-15px">
        <div class="col-md-12 pb-3">
            <div class="">
                <div class="row">
                  {{-- Tìm kiếm --}}
                   <div class="col-md-6 form-inline">
                      <form action="" class="form-inline w-100 form-search mb-3" id="form-search">
                           <input type="text" name="search" class="form-control w-30 mr-1" placeholder="-- Tên sản phẩm --">
                           <div class="px-2" style="width: 28% !important;">
                                <div class="tree_select_demo_main"></div>
                                <input type="hidden" value="" id="category_product_main" name="category_product_main">
                           </div>
                            <div class="px-2" style="width: 28% !important;">
                                <div class="tree_select_attribute"></div>
                                <input type="hidden" value="" id="attribute_ids" name="attribute_ids">
                            </div>
                           {{-- <input type="hidden" name="category_id" id="category_id"> --}}
                           <button type="submit" class="btn"><i class="fa fa-search"></i>&nbsp;Tìm kiếm</button>
                      </form>
                   </div>


                   <div class="col-md-6 text-right ">
                         <div class="">
                            <div class="btn_group">
                                <button class="btn" id="publish_on" onclick="changeStatus(1,'publish_on')" data-status="1">
                                    <i class="fa fa-check-circle"></i> &nbsp;Bật
                                </button>
                                <button class="btn" id="publish_off" onclick="changeStatus(0,'publish_off')" data-status="1">
                                    <i class="fa fa-check-circle"></i> &nbsp;Tắt
                                </button>
                                <a class="btn"><i class="fa fa-download"></i> Xuất file</a>
                                <div class="dropdown d-inline">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="dropdownAddNew" aria-haspopup="true" aria-expanded="true">
                                        Thêm mới
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownAddNew" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(3px, 32px, 0px);">
                                        <a href="{{route('private-system.product.create',['type' => 'laptop'])}}" class="dropdown-item" href="#">
                                            <i class="fa fa-plus"></i> 
                                             Laptop
                                        </a>
                                        <a href="{{route('private-system.product.create',['type' =>'electric'])}}" class="dropdown-item" href="#">
                                            <i class="fa fa-plus"></i> 
                                             Điện máy
                                        </a>
                                        <a href="{{route('private-system.product.create',['type' => 'accessory'])}}" class="dropdown-item" href="#">
                                            <i class="fa fa-plus"></i> 
                                             Phụ kiện
                                        </a>
                                        <a href="{{route('private-system.product.create',['type' => 'phone'])}}" class="dropdown-item" href="#">
                                            <i class="fa fa-plus"></i> 
                                             Điện thoại
                                        </a>
                                    </div>
                                </div>
                              

                                <button class="btn" id="delete-item" disabled>
                                    <i class="fa fa-trash"></i> 
                                    Xóa
                                </button>
                            </div>
                         </div>
                   </div>
                </div>
                <br>

                <table class="tDefault table table-bordered bootstrap-table" 
                    data-detail-view="true"
                    data-detail-formatter="detailFormatter"
                >
                    <thead>
                        <tr>    
                          <th data-field="index" data-align="center" data-width="5%" data-formatter="index_formatter">#</th> 
                            <th data-field="check" data-checkbox="true" data-width="4%"></th>
                            <th data-field="image" data-width="10%" data-formatter="image_formatted">Hình ảnh</th>
                            <th data-field="name" data-width="50%" data-formatter="name_formatter">Tên sản phẩm</th>
                            <th data-field="price" data-width="10%" >Giá tiền</th>
                            <th data-field="views" data-width="10%" >Lượt xem</th>
                            <th data-field="qualnity" data-width="10%">Số lượng</th>
                            <th data-field="category_name">Danh mục</th>
                            {{-- <th data-field="type" data-align="center" data-width="10%">Loại</th> --}}
                            <th data-field="status" data-align="center" data-width="12%" data-formatter="status_formatter">Trạng thái</th>    
                        </tr>
                    </thead>
                </table>
        
            </div>
        </div>
    </div> 
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_save" onsubmit="return false;" method="post" class="form-validate form-ajax" role="form"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <div class="btn-group">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                        </div>
                        <div class="btn-group act-btns">
                                <button type="button" id="btn_save" onclick="save(event)" class="btn save mr-2"
                                    data-must-checked="false"><i class="fa fa-save"></i>
                                    &nbsp; Lưu</button>
                            <button data-dismiss="modal" aria-label="Close" class="btn"><i
                                class="fa fa-times-circle"></i>&nbsp;Hủy</button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-4 control-label">
                                        <label>Tên thuộc tính <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="name" type="text" class="form-control" value=""
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4 control-label">
                                        <label>Thuộc tính cha</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="tree_select_demo"></div>
                                        <input type="hidden" id="category_parent_id" name="category_parent_id" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4 control-label">
                                        <label>Trạng thái <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="radio-inline">
                                            <input id="enable" required type="radio" name="status" value="1"
                                                checked> Bật
                                        </label>
                                        <label class="radio-inline">
                                            <input id="disable" required type="radio" name="status"
                                                value="0"> Tắt
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{asset('backend2/js/treeSelect.min.js')}}"></script>
    <script>
        function index_formatter(value, row, index) {
            return (index+1);
        }

        function detailFormatter(index, row) {
            var html = []
            var rows = $('<nav>').addClass('tree-nav');
            rows.html(row.variant_name ?? [])
            return rows;
        }


        function name_formatter(value,row,index){
            console.log(row)
            return `<div>
                        <a class="" href="${row.edit_url}">${row.name}</a>
                        <div>
                             <span class="fw-bold">Sku: ${row.sku}</span>
                        </div>
                         <div>
                             <span class="">Attribute: <span class="text-red">${row.attribute_name}</span></span>
                        </div>
                    </div>`;
        }


        function image_formatted(value,row,index){
            return '<img src="'+value+'" width="100" height="100" class=""/>';
        }


         function status_formatter(value, row, index) {
            var status = row.status == 1 ? 'checked' : '';
            var html = `<div class="custom-control custom-switch">
                            <input type="checkbox" `+ status +` onclick="change_single_status(`+row.id+`)" class="custom-control-input" id="customSwitch_`+row.id+`">
                            <label class="custom-control-label" for="customSwitch_`+row.id+`"></label>
                        </div>`;
            return html;
        }

        var table = new LoadBootstrapTable({
            locale: '{{ \App::getLocale() }}',
            url: '{{ route('private-system.product.getdata') }}',
            remove_url: '{{route('private-system.product.remove',['type' => 'all'])}}'
        });

        function deleteRow(id){
          Swal.fire({
                title: '',
                text: 'Bạn có muốn xóa dữ liệu này ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:'Đồng ý',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '{{route('private-system.product.remove_variant')}}',
                        dataType: 'json',
                        data : {
                        'id' : id
                        }
                    }).done(function(result){
                        show_message(result.message, result.status);
                        $(table.table).bootstrapTable('refresh');
                    }).fail(function(data) {
                        show_message('Lỗi hệ thống', 'error');
                        return false;
                    });
                }
            });
        }

        function change_single_status(id){
            let _this = $('#customSwitch_'+id);
            let status = _this.prop('checked') == true ? 1 : 0;
            $.ajax({
                url: '{{route('private-system.product-attribute.change.status')}}',
                type: 'post',
                data: {
                    id: id,
                    status: status
                }
            }).done(function(data) {
                $(table.table).bootstrapTable('refresh');
                return false;   
            }).fail(function(data) {
                show_message('Lỗi hệ thống', 'error');
                return false;
            });
        }

         function changeStatus(status,type) {
            var ids = $("input[name=btSelectItem]:checked").map(function(){return $(this).val();}).get();
         
            let _this = $('#'+type);
            let html = _this.html();
            _this.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
            if (ids.length <= 0) {
                show_message('Vui lòng chọn 1 dòng dữ liệu', 'error');
                return false;
            }
            $.ajax({
                url: '{{route('private-system.product-attribute.change.status')}}',
                type: 'post',
                data: {
                    ids: ids,
                    status: status
                }
            }).done(function(data) {
                // if (id == 0) {
                //     show_message(data.message, data.status);
                // }
                _this.prop('disabled', false).html(html);
                $(table.table).bootstrapTable('refresh');
                return false;
            }).fail(function(data) {
                _this.prop('disabled', false).html(html);
                show_message('Lỗi hệ thống', 'error');
                return false;
            });
        };

        function create(){
            $('#exampleModalLabel').html('Thêm mới');
            $('#form_save').trigger("reset");
            $("input[name=id]").val('');
            $('.tree_select_demo').html(' ');
            let position = '<option value="1">Thuê căn hộ / phòng trọ</option> <option value="2">Buôn bán điện tử</option> <option value="3">Việc làm</option>';
            $("#type_id").html(position)
            treeSelect();
            $('#myModal2').modal();

        }

            
          

            function save(){
                let item = $('.save');
                let oldtext = item.html();
                item.html('<i class="fa fa-spinner fa-spin"></i>');
                item.attr('disabled', true);
                event.preventDefault();
                $.ajax({
                    url: "{{ route('private-system.product-attribute.save') }}",
                    type: 'POST',
                    data: $("#form_save").serialize(),
                }).done(function(data) {
                    console.log(data);
                    item.html(oldtext);
                    $('.save').attr('disabled', false);
                    if (data && data.status == 'success') {
                        $('#myModal2').modal('hide');
                        show_message(data.message, data.status);
                        $(table.table).bootstrapTable('refresh');

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


            function edit(id){
                let item = $('#edit_' + id);
                let oldtext = item.html();
                item.prop('disabled',true).html('<i class="fa fa-spinner fa-spin"></i>')
                $("input[name=id]").val('');
                $('.tree_select_demo').html(' ');
                let position = '<option value="1">Thuê căn hộ / phòng trọ</option> <option value="2">Buôn bán điện tử</option> <option value="3">Việc làm</option>';
                $("#type_id").html(position)
                $.ajax({
                url: "{{ route('private-system.product-attribute.edit') }}",
                type: 'get',
                data: {
                    id: id,
                }
            }).done(function(data) {
                item.prop('disabled',false).html(oldtext)
                console.log(data)
                $('.tree_select_data').html(' ');
                $('#exampleModalLabel').html('Chỉnh sửa');
                $("input[name=id]").val(data.model.id);
                $("input[name=name]").val(data.model.name);
                treeSelect(data.model.parent_id);

                if (data.model.type) {
                    $("#position_modal select").val(data.model.type);
                    $("#position_modal select").val(data.model.type).change();
                } else {
                    $("#position_modal select").val('');
                    $("#position_modal select").val('').change();
                }

                if (data.model.status == 1) {
                    $('#enable').prop('checked', true)
                    $('#disable').prop('checked', false)
                } else {
                    $('#enable').prop('checked', false)
                    $('#disable').prop('checked', true)
                }

                $('#myModal2').modal();
                return false;
            }).fail(function(data) {
                item.prop('disabled',false).html(oldtext)
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });


            }

            const domElement1 = document.querySelector('.tree_select_demo_main')
            const treeselect1 = new Treeselect({
                parentHtmlContainer: domElement1,
                value: [],
                options: @json($productCateloge),
                placeholder: '-- Chon danh mục sản phẩm --',
                isSingleSelect: false,
            })

            treeselect1.srcElement.addEventListener('input', (e) => {
                $('#category_product_main').val(e.detail );
            })
            const domElement2 = document.querySelector('.tree_select_attribute')
            const treeselect2 = new Treeselect({
                parentHtmlContainer: domElement2,
                value: [],
                options: @json($attributes),
                placeholder: '-- Chon thuộc tính sản phẩm --',
                isSingleSelect: false,
            })

            treeselect2.srcElement.addEventListener('input', (e) => {
                $('#attribute_ids').val(e.detail );
            })


    </script>
@endsection