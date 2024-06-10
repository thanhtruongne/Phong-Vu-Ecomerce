@extends('backend.layout.layout');
@section('title')
    Quản lý phân quyền
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('permission-create') }}           
                    <h5 style="margin-top: 6px">{{ $title['create']['title'] }}</h5>
                
            </div>
            <div class="ibox-content">
                <div>
                     <form action="{{ route('private-system.management.configuration.permissions-role.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $title['create']['title'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tạo mục vai trò Roles (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
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
     