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
                'name' => 'Menus'.' - '.$menu_cateloge->name,
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        <div class="">
                            @if (!empty($menu_cateloge) && isset($menu_cateloge))
                                <div class="dd" id="nestable" data-cateloge="{{ $menu_cateloge->id }}">
                                    <ol class="dd-list">
                                        @if ($menu_cateloge->menus && count($menu_cateloge->menus) > 0)
                                            @foreach ($menu_cateloge->menus as $item)               
                                                <li class="dd-item" data-id="{{ $item->id }}" style="position: relative;">                                                   
                                                    <div class="dd-handle" >{{ $item->name }}</div>
                                                    @if (!empty($item->children))
                                                            <ol class="dd-list" style="display: none;">
                                                                @foreach ($item->children as $children)
                                                                <li class="dd-item" data-id="{{ $children->id }}">
                                                                    <div class="dd-handle">-{{ $children->name }}</div>
                                                                    <div class="" style="position: absolute;top:0px;right:0">
                                                                        {{-- <a href="{{ route('private-system.management.menu.children',$children->id) }}" class="btn btn-primary">Thêm</a> --}}
                                                                        <a  class="btn btn-danger">Xóa</a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                    <div class="" style="position: absolute;top:0px;right:0">
                                                        {{-- <a href="{{ route('private-system.management.menu.children',$item->id) }}" class="btn btn-primary">Thêm</a> --}}
                                                        <a  class="btn">Xóa</a>
                                                    </div> 
                                                </li>
                                            @endforeach
                                        @endif  
                                    </ol>
                                </div>
                            @else 
                                <div>
                                    <h5 style="margin-top: 6px">Trống</h5>
                                </div>   
                            @endif
                          
                        </div> 
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form_save" onsubmit="return false;" method="post"
                action="{{ route('private-system.categories.save') }}" class="form-validate form-ajax" role="form"
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
                                    <label>Tên danh mục <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-7">
                                    <input name="name" type="text" class="form-control" value=""
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4 control-label">
                                    <label>Danh mục cha</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="tree_select_demo"></div>
                                    <input type="hidden" id="category_parent_id" name="category_parent_id" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 control-label">
                                    <label>Icon</label>
                                </div>
                                <div class="col-md-7">
                                    <button class="btn btn-dark" style="color:#fff !important;"  role="iconpicker"></button>
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
                            <div class="form-group row">
                                <div class="col-sm-4 control-label">
                                    <label>Mô tả<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-7">
                                   <textarea class="editor" data-target="description" id="description" cols="30" rows="10"></textarea>
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
    <script>
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
            // console.log(window.JSON.stringify(list.nestable('serialize')),list.nestable('serialize'),output)
        if (window.JSON) {
            $.ajax({
                url: "{{ route('private-system.menus.child.save') }}",
                type: 'POST',
                data: {
                    value : window.JSON.stringify(list.nestable('serialize'))
                }
            }).done(function(data) {
                return false;
            }).fail(function(data) {
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });
            // output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#nestable').nestable().on('change', updateOutput);


    function create(id){
        $('#exampleModalLabel').html('Thêm mới thông tin');
        $('#form_save').trigger("reset");
        $("input[name=id]").val(id);
        $('.tree_select_demo').html(' ');
        $('#category_product_main').val('');
        $('#myModal2').modal();
        }
    </script>
@endsection