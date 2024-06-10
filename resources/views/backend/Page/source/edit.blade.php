@extends('backend.layout.layout');
@section('title')
    Quản lý nguồn
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('source-edit',$source->id) }}           
            </div>
            <div class="ibox-content">
                <div>
                     <form action="{{ route('private-system.management.source.update',$source->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div style="margin: 20px 0px;">
                            <h3 style="margin-top: 6px" class="text-uppercase">Cập nhật nguồn</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên nguồn (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name',$source->name) }}" name="name" class="form-control">
                            </div>
                           
                        </div>
                        @if ($errors->has('name'))
                                <div class="mt-2  text-left text-danger italic" style="position: relative;left:200px">{{ $errors->first('name') }}(*)</div>
                         @endif
                         <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Từ khóa (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('keyword',$source->keyword) }}" name="keyword" class="form-control">
                            </div>
                           
                        </div>
                        @if ($errors->has('keyword'))
                                <div class="mt-2  text-left text-danger italic" style="position: relative;left:200px">{{ $errors->first('name') }}(*)</div>
                         @endif
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Mô tả (*)</label>
                            <div class="col-sm-6">
                                <textarea name="desc" class="form-control" id="" cols="30" rows="10">
                                    {!! old('desc',$source->desc) !!}
                                </textarea>
                            </div>
                        </div>
                        @if ($errors->has('desc'))
                        <div class="mt-2  text-left text-danger italic" style="position: relative;left:200px">{{ $errors->first('desc') }}(*)</div>
                        @endif
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
     