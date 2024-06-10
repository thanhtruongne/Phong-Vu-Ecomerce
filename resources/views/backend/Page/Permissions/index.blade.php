@extends('backend.layout.layout');
@section('title')
    Quản lý người dùng
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('permission-index') }}           
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.Permissions.component.record')
                    </div>

                    <div class="col-sm-3 m-b-xs">                       
                        <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Show Roles</a>    
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.Permissions.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.configuration.permissions.create') }}" class="btn btn-primary">Thêm mới phân quyền <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tiêu đề</th>
                            <th>Canonical</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($permissions) > 0)
                             @foreach ($permissions as $item)
                             <tr>
                                <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                <td>{{ $item->name }}</td>       
                                <td>{{ $item->canonical }}</td>                   
                                <td>
                                    <a href="{{ route('private-system.management.configuration.permissions.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.table-user.delete',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
                {{ $permissions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @include('backend.Page.Permissions.component.role')
@endsection
