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
                                    <div class="col-md-9">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">
                                                Tên sản phẩm
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
                                               Hình ảnh
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
                                    </div>

                             
                                  </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div> 



@endsection

@section('scripts')
@endsection