@extends('backend.layout.layout');
@section('title')
    Quản lý menu
@endsection


@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('menu-edit') }}           
                <h5 style="margin-top: 6px">{{ $filter['title'] }}</h5>
            </div>
            <div class="ibox-content">
                @if (!empty($menuCateloge) && isset($menuCateloge))
                    <div class="dd" id="nestable" data-cateloge="{{ $menuCateloge->id }}">
                        <ol class="dd-list">
                                @foreach ($menuCateloge->menu as $item)
                                
                                <li class="dd-item" data-id="{{ $item->id }}" style="position: relative;">
                                    
                                    <div class="dd-handle" >{{ $item->name }}</div>
                                    @if (!empty($item->children))
                                        <ol class="dd-list" style="display: none;">
                                            @foreach ($item->children as $children)
                                                <li class="dd-item" data-id="{{ $children->id }}">
                                                    <div class="dd-handle">-{{ $children->name }}</div>
                                                    <div class="" style="position: absolute;top:0px;right:0">
                                                        <a href="{{ route('private-system.management.menu.children',$children->id) }}" class="btn btn-primary">Thêm</a>
                                                        <a  class="btn btn-danger">Xóa</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                    <div class="" style="position: absolute;top:0px;right:0">
                                        <a href="{{ route('private-system.management.menu.children',$item->id) }}" class="btn btn-primary">Thêm</a>
                                        <a  class="btn btn-danger">Xóa</a>
                                    </div>
                                </li>
                                @endforeach
                        
                        
                        
                        </ol>
                    </div>
                @else 
                <div>
                    <h5 style="margin-top: 6px">Trống</h5>
                </div>   
                @endif
            </div>
         
        </div>
    </div>
@endsection
      
