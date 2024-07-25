@extends('backend.layout.layout');
@section('title')
    Quản lý phân quyền
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('user-table') }}
                <div style="width:30%;display:flex;justify-content:space-between;align-items:center">
                    <div class="text-right">
                        <a href="{{ route('private-system.management.table-user.trashed') }}" class="btn btn-danger">
                            <i class="fa-solid fa-trash" style="margin-right: 4px;"></i>
                            Thùng rác ({{ count($trashedCount) }})
                        </a>
                    </div>
                </div>
               
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.User.component.record')
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.User.component.member')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.User.component.filter')
                        </div>  
                    </div>
                    </form>
                   
                    <div>
                        <a href="{{ route('private-system.management.table-user.create') }}" class="btn btn-primary">Thêm mới <i class="fa-solid fa-plus"></i></a>
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
                            <th>Canonical </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($users) > 0)
                             @foreach ($users as $item)
                             @dd()
                             <tr >
                                <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                <td>
                                    <strong>Email: </strong> <span>{{ $item->email }}</span><br>
                                    <strong> Tên: </strong> <span>{{ $item->name }}</span><br>
                                    <strong>SDT: </strong> <span>{{ $item->phone }}</span><br>
                                    <strong>Địa chỉ: </strong> <span>{{ $item->email }}</span><br>
                                    <strong>Email: </strong> <span>{{ $item->email }}</span><br>
                                    <strong>Email: </strong> <span>{{ $item->email }}</span><br>
                                    <strong>Email: </strong> <span>{{ $item->email }}</span><br>
                                </td>
                                <td><span class="pie">{{ $item->name }}</span></td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->user_cataloge->name ?? '' }}</td>
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'User'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'User'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.table-user.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
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
                {{ $users->links('pagination::bootstrap-4'  ) }}
            </div>
        </div>
    </div>
@endsection
