@extends('backends.layouts.layouts')


@section('page_title')

@section('breadcrumbs')
    @php
        $breadcum = [
            [
                'name' => 'Quản lý danh mục menus',
                'url' => '/'
            ],
            [
                'name' => 'Menus'.' - '.$model->name,
                'url' => '/'
            ],
        ];

    @endphp
<div class="row mb-3 mt-2 bg-white">
    <div class="col-md-12 px-0">
        @include('backends.layouts.components.breadcrumb',$breadcum)
    </div>
</div>
    
@endsection


@section('content')
<div class="row bg-white backend-container pt-3" style="margin-left: -15px;margin-right:-15px">
    <div class="col-md-12 pb-3">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        {{-- <div class="">
                            @if (!empty($model) && isset($model))
                                <div class="dd" id="nestable" data-cateloge="{{ $model->id }}">
                                    <ol class="dd-list">
                                            @foreach ($model->menu as $item)
                                            
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
                                                {{-- <div class="" style="position: absolute;top:0px;right:0">
                                                    <a href="{{ route('private-system.management.menu.children',$item->id) }}" class="btn btn-primary">Thêm</a>
                                                    <a  class="btn btn-danger">Xóa</a>
                                                </div> --}}
                                            {{-- </li>
                                            @endforeach
                                    
                                    
                                    
                                    </ol>
                                </div>
                            @else 
                            <div>
                                <h5 style="margin-top: 6px">Trống</h5>
                            </div>   
                            @endif --}}
                        {{-- </div> --}} 
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
    <script>
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);


    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));


    </script>
@endsection