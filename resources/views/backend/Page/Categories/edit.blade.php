@extends('backend.layout.layout');
@section('title')
    Quản lý danh mục
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('categories-edit',$categories->id) }}           
                <h5 style="margin-top: 6px">{{ $filter['update']['title'] }}</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <form action="{{ route('private-system.management.configuration.categories.update',$categories->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $filter['update']['title'] }}</h3>
                        </div>
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $filter['create']['title'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên danh mục (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name',$categories->name) }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Danh mục (*)</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="parent_id">
                                    <option  value="0">Không chứa danh mục cha</option>
                                    @foreach ($data as $key =>  $item)
                                 
                                        <option {{ $item->id == $categories->id ? 'selected' : '' }}  value="{{ $item->id }}">
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
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            </div>
                        </div>
                      
                     </form>
                </div>
            </div>
         
        </div>
    </div>
@endsection
      