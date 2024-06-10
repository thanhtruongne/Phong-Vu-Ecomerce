@extends('backend.layout.layout');
@section('title')
    Quản lý người dùng
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                {{ Breadcrumbs::render('user-trash') }}
            </div>
            <div class="mt-3 mb-3" style="margin: 16px 0">
                <i class="fa-solid fa-trash"></i>   <span style="font-size: 20px" class="mb-3">{{ $title['title'] }}</span>
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.User.component.record')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.User.component.filter')
                        </div>  
                    </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="check_box_all">
                            </th>
                            <th>Email </th>
                            <th>Tên </th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($dataRestore) > 0)
                             @foreach ($dataRestore as $item)
                             <tr>
                                <td><input type="checkbox"  class="i-checks" name="input[]"></td>
                                <td>{{ $item->email }}</td>
                                <td><span class="pie">{{ $item->name }}</span></td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    <a href="{{ route('private-system.management.table-user.trahsed.restore',$item->id) }}" class="btn btn-primary">Khôi phục</a>
                                    <a href="{{ route('private-system.management.table-user.trahsed.force',$item->id) }}" class="btn btn-danger delete_force">Xóa vĩnh viễn</a>
                                </td>
                            </tr>
                             @endforeach
                         @else
                         <tr>
                            <td>{{ $title['empty'] }}</td>
                         </tr>
                         @endif
                        </tbody>
                    </table>
                </div>
                {{ $dataRestore->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
