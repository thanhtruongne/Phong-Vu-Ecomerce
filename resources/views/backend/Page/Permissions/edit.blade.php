@extends('backend.layout.layout');
@section('title')
    Quản lý quyền
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('permission-edit',$permission->id) }}           
                    <h5 style="margin-top: 6px">{{ $title['update']['title'] }}</h5>
                
            </div>
            <div class="ibox-content">
                <div>
                    <form action="{{ route('private-system.management.configuration.permissions.update',$permission->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $title['update']['title'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tiêu đề phân quyền (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name',$permission->name) }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Canonical (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('canonical',$permission->canonical) }}" name="canonical" class="form-control">
                            </div>
                            @if ($errors->has('canonical'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('canonical') }}(*)</div>
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

@push('scripts')
<script>
    var province_id = '{{ (isset($user->province_code)) ? $user->province_code : old('province_code') }}';
    var district_id = '{{ (isset($user->district_code)) ? $user->district_code : old('district_code') }}';
    var ward_id = '{{ (isset($user->ward_code)) ? $user->ward_code : old('ward_code') }}';
</script>
    
@endpush        