@extends('backend.layout.layout');
@section('title')
    Quản lý nhóm bài viết
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                {{ Breadcrumbs::render('post-cataloge-trashed') }}
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
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tên nhóm bài viết </th>
                            <th>Danh mục</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($trashedCount) > 0) 
                             @foreach ($trashedCount as $item)
                             <tr >
                                <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                <td><span class="pie">{{ $item->post_cateloges_transltate->name }}</span></td>
                                <td>{{ $item->categories->name }}</td>
                                <td>
                                    <a href="{{ route('private-system.management.post.cataloge.restore',$item->id) }}" class="btn btn-success m-r-xs">Khôi phục</a>
                                    <a href="{{ route('private-system.management.post.cataloge.delete-force',$item->id) }}" class="btn btn-danger delete_force">Xóa Vĩnh Viễn</a>
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
               
            </div>
        </div>
    </div>
@endsection
