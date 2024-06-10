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
    <form action="{{ route('private-system.management.menu.save.children') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $menu->id }}" name="menu_id">
        <input type="hidden" value="{{ $menu->menu_cateloge_id }}" name="menu_cateloge_id">
        <div>
            <h2>{{ $menu->menu_translate->first()->name }}</h2>
        </div>
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
            
        
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary" type="submit">Tạo mới</button>
                </div>
    
    
            </div>
        
    </form>   
</div>
</div>
@endsection

     