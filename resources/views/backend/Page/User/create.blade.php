@extends('backend.layout.layout');
@section('title')
    Quản lý người dùng
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('user') }}           
                    <h5 style="margin-top: 6px">{{ $title['title'] }}</h5>
                
            </div>
            <div class="ibox-content">
                <div>
                     <form action="{{ route('private-system.management.table-user.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $title['Infomation'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Họ (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('fullname') }}" name="fullname" class="form-control">
                            </div>
                             @if ($errors->has('fullname'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('fullname') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Số điện thoại (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('phone') }}" name="phone" class="form-control">
                            </div>
                             @if ($errors->has('phone'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('phone') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Email (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('email') }}" name="email" class="form-control">
                            </div>
                             @if ($errors->has('email'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('email') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Ngày sinh (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('birthday') }}" name="birthday" class="form-control datepicker">
                            </div>
                             @if ($errors->has('birthday'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('birthday') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Mật khẩu (*)</label>
                            <div class="col-sm-6">
                                <input type="password"  name="password" class="form-control">
                            </div>
                             @if ($errors->has('password'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('password') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Nhập lại mật khẩu (*)</label>
                            <div class="col-sm-6">
                                <input type="password"  name="password_confirmation" class="form-control">
                            </div>
                             @if ($errors->has('password_confirmation'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('password_confirmation') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Nhóm hoạt động</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="user_cataloges_id ">
                                    <option value="0">Không</option>
                                    @foreach ($userCataloge as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Vai trò</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="role">
                                    <option selected value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="vendor">Đối tác</option>
                                </select>
                            </div>
                             @if ($errors->has('role'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('role') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px">
                            <label class="col-sm-2 control-label"> Hình ảnh(*)</label>
                            <div class="col-sm-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Chọn ảnh</span>
                                    <span class="fileinput-exists">Thay đổi</span><input type="file" name="thumb"/></span>
                                    <span class="fileinput-filename"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                </div> 
                            </div>
                             @if ($errors->has('thumb'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('thumb') }}(*)</div>
                            @endif
                        </div>
                       <div style="margin: 12px 0px;">
                            <div style="margin-bottom: 8px;">
                                <h3 class="text-success">{{ $title['Contact'] }}</h3>
                            </div>
                            <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Thành phố / Tỉnh (*)</label>
                                <div class="col-sm-6">
                                    <select class="form-control provinces location" name="province_code" data-target='districts'>
                                      
                                        <option selected value="">Chọn thành phố / tỉnh</option>
                                        @if (!empty($provinces))
                                        {{-- @dd($provinces); --}}
                                            @foreach ($provinces as $province)
                                               
                                                <option 
                                                @if (old('province_code') == $province->code )
                                                    selected
                                                @endif value='{{ $province->code }}'>{{ $province->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                 @if ($errors->has('province_code'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('province_code') }}(*)</div>
                            @endif
                            </div>
                            <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Quận / Huyện(*)</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2 districts location" name="district_code" data-target='wards'>
                                    
                                    </select>
                                </div>
                                 @if ($errors->has('district_code'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('district_code') }}(*)</div>
                            @endif
                            </div>
                            <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Phường / Xã (*)</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2 wards location" name="ward_code">
                                      
                                    </select>
                                </div>
                                 @if ($errors->has('ward_code'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('ward_code') }}(*)</div>
                            @endif
                            </div>
                            <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Địa chỉ</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ old('address') }}" name="address" class="form-control">
                                </div>
                                 @if ($errors->has('address'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('address') }}(*)</div>
                            @endif
                            </div>
                            <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label"> Ghi chú</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ old('desc') }}" name="desc"class="form-control">
                                </div>
                                 @if ($errors->has('desc'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('desc') }}(*)</div>
                            @endif
                            </div>
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
    var province_id = '{{ old('province_code') }}';
    var district_id = '{{ old('district_code') }}';
    var ward_id = '{{ old('ward_code') }}';
</script>
    
@endpush        