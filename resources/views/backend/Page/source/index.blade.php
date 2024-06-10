@extends('backend.layout.layout');
@section('title')
    Quản lý nguồn khách hàng
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('source-index') }}
                <div style="width:30%;display:flex;justify-content:space-between;align-items:center">
                    <div class="text-right">
                        <a href="{{ route('private-system.management.table-user.trashed') }}" class="btn btn-danger">
                            <i class="fa-solid fa-trash" style="margin-right: 4px;"></i>
                            Thùng rác ({{ $trashedCount }})
                        </a>
                    </div>
                </div>
               
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.source.component.record')
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.source.component.member')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.source.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div style="margin:0 12px 14px 12px">
                        <a href="{{ route('private-system.management.source.create') }}" class="btn btn-primary">Thêm mới nguồn <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr > 
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Id </th>
                            <th>Tên nguồn </th>
                            <th>Mô tả nhóm</th>
                            <th>Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($source) > 0)
                             @foreach ($source as $item)
                             <tr >
                                <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                <td>{{ $item->id }}</td>
                                <td><span class="pie">{{ $item->name }}</span></td>
                                <td>{{ $item->desc }}</td>
                                
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch js-switch-toggle change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Source'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch js-switch-toggle change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Source'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.source.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.source.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>    
                                </td>
                            </tr>
                             @endforeach
                         @else
                         <tr class="text-center">
                             <th> Danh sách trống !</th>
                         </tr>  
                         @endif
                        </tbody>
                    </table>
                </div>
                {{ $source->links('pagination::bootstrap-4'  ) }}
            </div>
        </div>
    </div>
@endsection
