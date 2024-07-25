@extends('backend.layout.layout');
@section('title')
    Quản lý danh mục
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('attribute.index') }}
             
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.attribute.attribute.component.record',['data' => $filter['record']])
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.attribute.attribute.component.status',['data' => $filter['status']])
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.attribute.attribute.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.attribute.create') }}" class="btn btn-primary">Thêm mới thuộc tính<i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>Tên thuộc tính</th>               
                            <th>Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($attribute) > 0)
                             @foreach ($attribute as $item)
                                    @php
                                        $arrayCategories = [];
                                        $arrayPush = [];
                                        
                                        foreach($item->attribute_cateloge_attribute as $key => $value) {
                                            //dùng pivot để lấy data cả hai bảng post_cateloge_post 
                                            $arrayCategories[] =  $value->pivot->attribute_cateloge_id;
                                        };
                                        if(!empty($arrayCategories)) {
                                            foreach ($arrayCategories as $sum) {
                                                $arrayPush[] = \App\Models\AttributeCateloge::find($sum)->name;
                                            }
                                        }
              
                                    @endphp
                             <tr >
                                <td>
                                    <div style="display:flex;align-items:center">
                                        <div style="margin-left: 12px">
                                            <h3 style="font-style:italic;font-weight: bold;color:dodgerblue">{{ Str::limit($item->name,50) }}</h3>
                                            <div>
                                              <strong style="font-size: 12px;">Nhóm thuộc tính: <span style="color:rgb(0, 101, 49)"> {{ $item->attribute_cataloge->name }}</span> </strong>
                                               @if (!empty($arrayPush))
                                                   @foreach ($arrayPush as $val)
                                                       <span style="color: rgb(136, 16, 16);font-size: 12px;font-style:italic">{{ $val }} - </span>
                                                   @endforeach
                                               @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Attribute'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'Attribute'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.attribute.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.attribute.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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
                {{ $attribute->links() }}
            </div>
        </div>
    </div>
@endsection
