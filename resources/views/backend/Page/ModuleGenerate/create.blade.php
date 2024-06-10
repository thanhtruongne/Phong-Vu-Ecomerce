@extends('backend.layout.layout');
@section('title')
    Quản lý module
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('module-create') }}           
            </div>
            <div class="ibox-content">
                <div>
                     <form action="{{ route('private-system.management.module.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
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
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên chức năng (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('function_name') }}" name="function_name" class="form-control">
                            </div>
                            @if ($errors->has('function_name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('function_name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Đường dẫn (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('path') }}" name="path" class="form-control">
                            </div>
                            @if ($errors->has('path'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('path') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Loại module (*)</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="module_type">
                                    <option selected>Loại module</option>
                                    <option  value="detail">Loại chi tiết (detail)</option>
                                    <option  value="node_categories">Module danh mục</option>
                                    <option  value="another">Module khác (chi có 1 database schema)</option>
                                </select>
                            </div>
                             @if ($errors->has('module_type'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('module_type') }}(*)</div>
                            @endif
                        </div>

                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Schema (*)</label>
                            <div class="col-sm-6">
                                <textarea rows="12" name="schema" class="form-control">{{ old('schema') }}</textarea>
                            </div>
                            @if ($errors->has('schema'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('schema') }}(*)</div>
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

     