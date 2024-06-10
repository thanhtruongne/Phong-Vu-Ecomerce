@extends('backend.layout.layout');
@section('title')
    Quản lý khách hàng
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('customer-index') }}
                <div style="width:30%;display:flex;justify-content:space-between;align-items:center">
                    <div class="text-right">
                        <a href="{{ route('private-system.management.customer') }}" class="btn btn-danger">
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
                        @include('backend.Page.Customer.component.record')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.Customer.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div style="margin:0 12px 14px 12px">
                        <a href="{{ route('private-system.management.customer.create') }}" class="btn btn-primary">Thêm mới khách hàng <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr > 
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Id</th>
                            <th>Tên khách hàng </th>
                            <th>Email </th>
                            <th>Nhóm khách hàng</th>
                            <th>Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($customer) > 0)
                             @foreach ($customer as $item)
                             <tr >
                                <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                <td>{{ $item->id }}</td>
                                <td><span class="pie">{{ $item->name }}</span></td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->customer_cateloge->name }}</td>
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                        <input 
                                        type="checkbox" 
                                        class="js-switch js-switch-toggle change_status" 
                                        data-id="{{ $item->id }}"
                                        data-model = 'Customer'  />
                                        
                                    @else
                                        <input 
                                        type="checkbox" 
                                        class="js-switch js-switch-toggle change_status" 
                                        data-id="{{ $item->id }}"
                                        data-model = 'Customer'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.customer.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.customer.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>    
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
                {{ $customer->links('pagination::bootstrap-4'  ) }}
            </div>
        </div>
    </div>
@endsection
