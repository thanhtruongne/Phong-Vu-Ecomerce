@extends('backend.layout.layout');
@section('title')
    Quản lý Slider
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('slider-index') }}>
               
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
                        <a href="{{ route('private-system.management.slider.create') }}" class="btn btn-primary">Thiết lập slider <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tên slider </th>
                            <th>Từ khóa </th>                   
                            <th>Mô tả</th>
                            <th>Action</th> 
                        </tr>
                        </thead>
                        <tbody>
                          @if (!empty($slider) && count($slider) > 0)
                              @foreach ($slider as $key => $item)
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
                                        data-model = 'Slider'  />
                                            
                                        @else
                                        <input 
                                        type="checkbox" 
                                        class="js-switch change_status" 
                                        data-id="{{ $item->id }}"
                                        data-model = 'Slider'  checked />
                                        @endif
                                    </td>                   
                                    <td>
                                        <a href="{{ route('private-system.management.slider.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                        <a href="{{ route('private-system.management.slider.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
