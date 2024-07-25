@extends('backend.layout.layout');
@section('title')
    Quản lý sản phẩm
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('product.index') }}
           
               
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.product.product.component.record',['data' => $filter['record']])
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.product.product.component.status',['data' => $filter['status']])
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.component.categories',['categories' => $productCateloge ])
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.product.product.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.product.create') }}" class="btn btn-primary">Thêm mới sản phẩm <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>Tên sản phẩm </th> 
                            <th>Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (!empty($product) && count($product) > 0)
                             @foreach ($product as $item)
                                @php
                                    $arrayCategories = [];
                                    $arrayPush = [];
                                    
                                    foreach($item->product_cateloge_product as $key => $value) {
                                        //dùng pivot để lấy data cả hai bảng post_cateloge_post 
                                        $arrayCategories[] =  $value->pivot->product_cateloge_id;
                                    };
                                    if(!empty($arrayCategories)) {
                                        sort($arrayCategories);
                                        foreach ($arrayCategories as $sum) {
                                            $arrayPush[] = $postCataloge = \App\Models\ProductCateloge::find($sum)->name;
                                        }

                                    }
                                  
                                @endphp
                             <tr >
                                  
                                <td>
                                    <div style="display:flex;align-items:center">
                                        <div>
                                            <img src="{{ $item->image }}" alt="" width="92">
                                        </div>
                                        <div style="margin-left: 12px">
                                            <h3 style="font-style:italic;font-weight: bold;color:dodgerblue">{{ Str::limit($item->name,50) }}</h3>
                                            <div>
                                              <strong style="font-size: 12px">Nhóm sản phẩm :</strong>
                                               @if (!empty($arrayPush))
                                                   @foreach ($arrayPush as $val)
                                                       <span style="color: rgb(136, 16, 16);font-size: 12px;font-style:italic">{{ $val }} - </span>
                                                   @endforeach
                                               @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- @include('backend.component.transllateLanguage',['model' => 'Product','languages' => $languages , 'item' => $item]) --}}
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Product'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Product'  checked />
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('private-system.management.product.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.product.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
                {{ $product->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
