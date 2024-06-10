@extends('backend.layout.layout');
@section('title')
    Quản lý Widget
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('widget-index') }}>
               
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.slider.component.record',['data' => $filter['record']])
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.slider.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.widget.create') }}" class="btn btn-primary">Thiết lập Widget <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tên Widget </th>
                            <th>Từ khóa </th>                   
                            <th>Mô tả</th>
                            <th>Action</th> 
                        </tr>
                        </thead>
                        <tbody>
                          @if (!empty($widget) && count($widget) > 0)
                              @foreach ($widget as $key => $item)
                                <tr>
                                    <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                    <td>{{ $item->name }}</td>       
                                    <td>{{ $item->keyword }}</td>    
                                    <td class="js-switch-{{ $item->id }} text-center">
                                        @if ($item->status == 0)
                                        <input 
                                        type="checkbox" 
                                        class="js-switch change_status" 
                                        data-id="{{ $item->id }}"
                                        data-model = 'Widget'  />
                                            
                                        @else
                                        <input 
                                        type="checkbox" 
                                        class="js-switch change_status" 
                                        data-id="{{ $item->id }}"
                                        data-model = 'Widget'  checked />
                                        @endif
                                    </td>                   
                                    <td>
                                        <a href="{{ route('private-system.management.widget.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                        <a href="{{ route('private-system.management.widget.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
                {{ $widget->links('pagination::bootstrap-4'  ) }}
            </div>
        </div>
    </div>
@endsection
