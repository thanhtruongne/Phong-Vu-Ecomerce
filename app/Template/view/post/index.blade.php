@extends('backend.layout.layout');
@section('title')
    Quản lý danh mục
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('{module_breadcrumb}') }}
                <div style="width:30%;display:flex;justify-content:space-between;align-items:center">
                    <div class="text-right">
                        <a href="{{ route('private-system.management.table-user.trashed') }}" class="btn btn-danger">
                            <i class="fa-solid fa-trash" style="margin-right: 4px;"></i>
                            Thùng rác ({{ $trashedCount }})
                        </a>
                    </div>
                    <div class="ibox-tools">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"
                            data-model = 'Language' data-target="1" data-value="1"    
                            class="status_all_config_option">Active hết các danh mục</a>
                            </li>
                            <li><a href="#" 
                            data-model = 'Language' data-target="0" data-value="0"    
                            class="status_all_config_option">Unactive hết các danh mục</a>
                            </li>
                            <li><a href="" >Xóa các danh mục theo chỉ định</a>
                            </li>
                        </ul>
                    </div>
                </div>
               
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.Categories.component.record')
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.Categories.component.status')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.Categories.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.configuration.categories.create') }}" class="btn btn-primary">Thêm mới danh mục <i class="fa-solid fa-plus"></i></a>
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
                            <th>Tên danh mục </th>
                            <th>Mô tả</th>
                            <th>Danh mục kế thừa</th>
                            <th>Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($data) > 0)
                             @foreach ($data as $item)
                             <tr >
                                 <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                 <td>{{ $item->id }}</td>
                                <td>
                                    <span class="pie">
                                        {{ str_repeat('|---',($item->depth > 0) ? $item->depth : 0) }}
                                        {{ $item->name }}
                                    </span>
                                </td>
                                <td><span class="pie">{{ $item->desc }}</span></td>
                                <td>
                                    @if (count($item->ancestors))
                                        @foreach ($item->ancestors as $children)
                                             {{ $children->name }} - 
                                        @endforeach
                                    @else
                                     {{ '' }}   
                                    @endif
                                </td>
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Categories'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Categories'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.configuration.categories.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.configuration.categories.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
