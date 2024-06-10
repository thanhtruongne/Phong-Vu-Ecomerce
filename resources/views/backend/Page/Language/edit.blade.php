@extends('backend.layout.layout');
@section('title')
    Quản lý ngôn ngữ
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('languages-edit',$language) }}           
                <h5 style="margin-top: 6px">{{ $filter['update']['title'] }}</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <form action="{{ route('private-system.management.configuration.language.update',$language->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $filter['update']['title'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name',$language->name) }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Mô tả (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('desc',$language->desc) }}" name="desc" class="form-control">
                            </div>
                            @if ($errors->has('desc'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('desc') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Canonical (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('canonical',$language->canonical) }}" name="canonical" class="form-control">
                            </div>
                            @if ($errors->has('canonical'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('canonical') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group col-lg-12" style="margin-top: 8px">
                            <label class="col-sm-2 control-label"> Hình ảnh(*)</label>                 
                                <div class="input-group mb-3 col-lg-6 px-2" >
                                    <input type="text" value="{{ old('image',$language->image) }}" name="image" id="inputGroupFile01" class="form-control ckfinder_2"   data-type="Images">
                                  </div>
                             @if ($errors->has('image'))
                                <div class="mt-3 text-end text-danger italic">
                                    <span>{{ $errors->first('image') }}(*)</span>
                                </div>
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
      