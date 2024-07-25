@extends('backend.layout.layout');
@section('title')
    Quản lý ProductCateloge
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('product.cateloge.index') }}             
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.product.cateloge.component.record',['data' => $filter['record']])
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.product.cateloge.component.status',['data' => $filter['status']])
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.product.cateloge.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.product.cateloge.create') }}" class="btn btn-primary">Thêm mới danh mục <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>Tên danh mục </th>
                            <th>Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($productCateloge) > 0)
                             @foreach ($productCateloge as $item)
                             <tr >
                                
                                <td>
                                    <span class="pie">
                                        {{ str_repeat('|---',($item->depth > 0) ? $item->depth : 0) }}
                                        {{ $item->name }}
                                    </span>
                                </td>
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'ProductCateloge'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'ProductCateloge'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.product.cateloge.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.product.cateloge.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
