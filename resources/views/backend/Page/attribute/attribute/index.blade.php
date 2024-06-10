@extends('backend.layout.layout');
@section('title')
    Quản lý danh mục
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('attribute.index') }}
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
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tên thuộc tính</th>
                                @foreach ($languages as $language)
                                
                                    @if (App::currentLocale() === $language->canonical)
                                        @continue 
                                    @endif     
                                    <th style="text-align: center" colspan="2">
                                        <span><img src="{{ $language->image }}" width="60" alt=""></span>
                                    </th>            
                                @endforeach                     
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
                                                $arrayPush[] = \App\Models\AttributeCateloge::find($sum)->attribute_cateloge_translate->name;
                                            }
                                        }
              
                                    @endphp
                             <tr >
                                 <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                <td>
                                    <div style="display:flex;align-items:center">
                                        <div style="margin-left: 12px">
                                            <h3 style="font-style:italic;font-weight: bold;color:dodgerblue">{{ Str::limit($item->name,50) }}</h3>
                                            <div>
                                              <strong style="font-size: 12px">Nhóm thuộc tính:</strong>
                                               @if (!empty($arrayPush))
                                                   @foreach ($arrayPush as $val)
                                                       <span style="color: rgb(136, 16, 16);font-size: 12px;font-style:italic">{{ $val }} - </span>
                                                   @endforeach
                                               @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @include('backend.component.transllateLanguage',['model' => 'Attribute','languages' => $languages , 'item' => $item])
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
                {{-- {{ $attribute->links('pagination::bootstrap-4'  ) }} --}}
            </div>
        </div>
    </div>
@endsection
