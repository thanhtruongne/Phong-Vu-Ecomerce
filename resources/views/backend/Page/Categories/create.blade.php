@extends('backend.layout.layout');
@section('title')
    Quản lý danh mục
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('categories-create') }}           
                   
                
            </div>
            <div class="ibox-content">
                <div>
                     <form action="{{ route('private-system.management.configuration.categories.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $filter['create']['title'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên danh mục (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Danh mục (*)</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="parent_id">
                                    <option selected value="0">Không chứa danh mục cha</option>
                                    @foreach ($cateList as $key =>  $item)
                                 
                                        <option  value="{{ $item->id }}">
                                            {{ str_repeat('|---',($item->depth > 0) ? $item->depth : 0) }}{{ $item->name }}
                                        </option>
                                       
                                     @endforeach
                                </select>
                            </div>
                             @if ($errors->has('parent_id'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('parent_id') }}(*)</div>
                            @endif
                        </div>
                       
                       <div class="hr-line-dashed"></div>
                       <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Tạo mới</button>
                            </div>
                        </div>
                      
                     </form>
                </div>
            </div>
         
        </div>
    </div>
@endsection

     