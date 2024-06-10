@extends('backend.layout.layout');
@section('title')
    Quản lý menu
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('menu-create') }}              
            </div>       
            <form action="{{ route('private-system.management.menu.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                <div>
                    <div class="row" style="width:100%;margin-top:20px">  
                            @if ($errors->any())
                                <div class="alert alert-danger" style="margin: 0 -15px 0 15px">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <div class="col-lg-6">
                                    <div class="ibox-content" style="margin: 20px 0px">
                                        <h3 class="text-success">Thông tin chung</h3>
                                        <p class="text-info" style="font-style: italic">Tạo vị trí hiển thị menu</p>
                                    </div>
                                </div>   
                                <div class="col-lg-5">    
                                    <div class="ibox-content" style="margin: 20px 0px">
                                        <a data-toggle="modal" class="btn btn-primary" style="margin-bottom:12px" href="#modal-form">Tạo vị trí <i class="fa-solid fa-plus"></i></a>
                                        <div>
                                            <div>
                                                <label class="control-label" style="margin-bottom: 8px">Chọn phần vị trí tạo (*)</label>
                                                <select name="menu_cateloge_id" id="" class="select2 form-control finding_select_choose_menu">            
                                                    @if (isset($menuCateloge) && !empty($menuCateloge))
                                                        @foreach ($menuCateloge as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div style="margin-top: 12px">
                                                <label class="control-label" style="margin-bottom: 8px">Chọn loại drop down (*)</label>
                                                <select name="type" id="" class="select2 form-control">                   
                                                        @foreach (__('model')['dropDown'] as $key =>  $item)
                                                            <option value="{{ $key }}">{{ $item }}</option>
                                                        @endforeach                                
                                                </select>
                                            </div>
                                        </div>
                                        <div id="modal-form" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <h3 class="row" style="border-bottom:1px solid #ccc ; padding:0 12px 12px 12px">Nhập dữ liệu vào các Input</h3>       
                                                            <span class="message_timing text-success" style="font-size: 16px;padding:0 15px;"></span>
                                                            <div class="col-sm-12">
                                                                <div id="submit_menu_keyword">
                                                                    <div class="form-group" style="margin: 8px 0 0 0">
                                                                        <label class="control-label" style="margin-bottom: 8px">Tên menu (*)</label>
                                                                        <div class="">
                                                                            <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                                                                        </div>
                                                                        <div class="form-group mt-3 text-left text-danger italic error-name" style="margin: 4px 0 0 0">
                                                                        
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="margin: 8px 0 0 0">
                                                                        <label class="control-label" style="margin-bottom: 8px">Keyword (*)</label>
                                                                        <div class="">
                                                                            <input type="text" value="{{ old('keyword') }}" name="keyword" class="form-control">
                                                                        </div>
                                                                    
                                                                        <div class="mt-3 form-group text-left text-danger italic error-keyword" style="margin: 4px 0 0 0">
                                                                        
                                                                        </div>
                                                                
                                                                    </div>
                
                                                                    <div class="" style="width:100%;margin-top:12px">
                                                                        <button type=submit class="btn btn-primary change_menu_keyword" type="submit">Tạo mới</button>
                                                                    </div>
                                                               
                                                            </div>
                                                    </div>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>     
                                </div>                         
                        </div>
                        
                    </div>
                </div>            
                    
                <div class="">
                    <div class="row">
                        
                            <div class="col-lg-5">
                                <div class="ibox-content">
                                    @include('backend.Page.menu.menu.component.tab')
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="ibox-content">
                                    
                                    <div class="col-name" style="height: 25px">
                                        <div class="col-lg-3">
                                            Tên menu
                                        </div>
                                        <div class="col-lg-3">
                                            Đường dẫn
                                        </div>
                                        <div class="col-lg-3">
                                            Vị trí
                                        </div>
                                        <div class="col-lg-2">
                                            Icon
                                        </div>
                                        <div class="col-lg-1">
                                            Xóa
                                        </div>
                                    </div>
                                    <div class="title_show_content text-center">
                                        <h3>Tạo dữ liệu menu theo các input title</h3>
                                        <p class="text-danger">Vui lòng nhập đủ các dữ liệu input . Tránh render lỗi</p>
                                    </div>
                                    <div class="row_content">
                                        {{-- Render row --}}
                                    </div>
                                </div>
                            </div>
                                
                    </div>
                </div>  
                        </div>
                    </div>
               
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                     <div class="col-sm-4 col-sm-offset-2">
                         <button type="submit" class="btn btn-primary" type="submit">Tạo mới</button>
                     </div>
           
         
                    </div>
                </form>
    </div>
@endsection

     