@extends('backend.layout.layout');
@section('title')
    Quản lý nhóm bài viết
@endsection

@section('content')

   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('post-cataloge-index') }} 
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.Post.Cataloge.component.record')
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.Post.Cataloge.component.member')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.Post.Cataloge.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.post-cataloge.create') }}" class="btn btn-primary">Thêm mới <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>Tên nhóm bài viết </th>
                            <th colspan="1">Tình trạng hoạt động</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         @if (count($postCataloge) > 0)
                             @foreach ($postCataloge as $item)
                             {{-- @dd($item->post_cataloge->id) --}}
                             <tr >
                                <td><span class="pie">
                                    {{ str_repeat('|---',($item->depth != 0 ? $item->depth : 0)) }} {{ $item->post_cateloge_translate->first()->name }}
                                   
                                </span></td>
                        
                                <td class="js-switch-{{ $item->id }} text-center">
                                    @if ($item->status == 0)
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'PostCataloge'  />
                                        
                                    @else
                                    <input 
                                    type="checkbox" 
                                    class="js-switch change_status" 
                                    data-id="{{ $item->id }}"
                                    data-model = 'PostCataloge'  checked />
                                    @endif
                                    
                                <td>
                                    <a href="{{ route('private-system.management.post-cataloge.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                    <a href="{{ route('private-system.management.post-cataloge.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
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




