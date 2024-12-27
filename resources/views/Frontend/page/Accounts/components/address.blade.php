<div class="" style="width:80%;box-sizing: border-box;margin: 0px;min-width: 0px;">
    <div class="justify-content-center" style="flex-flow:unset;margin-left: -8px;margin-right: -8px;border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
        <div class="teko-col teko-col-8 css-17ajfcv">
            <div class="css-1hlwznm ">
                <div class="">
                    {{-- title --}}
                    <div class="d-flex justify-content-between align-items-center teko-row" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
                        <div class="css-1w9reh3">Thông tin tài khoản</div>
                        <button type="button" class="css-1w9reh3 btn" style="background-color: #1435c3 !important; width:50px"  data-bs-toggle="modal" data-bs-target="#modal-user-address">
                            <i class="fas fa-plus text-white"></i>
                        </button>
                    </div>
                    <div class="mt-2 render_ajax">
                         @if (isset($user->user_session_address) && !empty($user->user_session_address))
                            @foreach ($user->user_session_address as $main)
                                @php
                                    $address = $main->address.', '.$main->province->full_name.', '.$main->district->full_name.', '.$main->ward->full_name;
                                @endphp
                                <div class="css-8mjjgr">
                                    <div class="wrapper">
                                        <div class="teko-row css-1qrgscw justify-content-between">
                                            <div class="teko-col css-17ajfcv" style="flex: 0 0 65%;">
                                                <div class="teko-row teko-row-start align-items-center css-1qrgscw">
                                                    <div class="lzq1g0">{{ $main->receiver_name }}</div>
                                                    @if (!is_null($main->default))
                                                        <span class="css-16zsojs ml-2">
                                                            <div type="caption" color="primary600" class="css-1fktfn4">
                                                                MẶC ĐỊNH
                                                            </div>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="css-1lihu4j">
                                                Địa chỉ : {{ $address }}
                                                </div>
                                                <div class="css-1lihu4j">
                                                   Điện thoại : {{ $main->receiver_phone }}
                                                </div>
                                            </div>

                                            <div class="teko-col css-17ajfcv" style="flex: 0 0 35%;">
                                                <div class="teko-row justify-content-end css-1qrgscw">
                                                    @if (!is_null($main->default))
                                                        <button type="button" class="css-1j6k1oa edit_row_{{ $main->id }}"  onclick="editRow({{ $main->id }})" >
                                                            <span class="css-1sjnqcx">Chỉnh sửa</span>
                                                        </button>
                                                    @else
                                                        <button type="button" class="css-1j6k1oa edit_row_{{ $main->id }}" onclick="editRow({{ $main->id }})">
                                                            <span class="css-1sjnqcx">Chỉnh sửa</span>
                                                        </button>
                                                        <button height="2rem" onclick="deleteRow({{ $main->id }} , {{ $main->user_id }})" class="css-1wblz1b" type="button">
                                                            <div type="body" color="textPrimary" class="css-ughm7k">Xóa</div>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                         @else

                         @endif



                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
  <div class="modal fade" id="modal-user-address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thông tin nhận hàng</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="form-save-address" class="form-validate">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="type" value="1">
            <div class="modal-body">
                <div class="form-group col-lg-12 mb-3">
                    <div class="col-sm-6 control-label mb-1">
                        <label class="fw-bold">Họ tên<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-12">
                        <input name="receiver_name" type="text" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group col-lg-12 mb-3 d-flex justify-content-between align-item-center">
                    <div class="form-group col-lg-5 mb-3">
                        <div class=" control-label">
                            <label class="fw-bold mb-1">Email<span class="text-danger">*</span></label>
                        </div>
                        <div class="">
                            <input name="receiver_email" type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group col-lg-5 mb-3">
                        <div class=" control-label">
                            <label class="fw-bold mb-1">Số điện thoại<span class="text-danger">*</span></label>
                        </div>
                        <div class="">
                            <input name="receiver_phone" type="text" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group col-lg-12 mb-3 d-flex justify-content-between align-item-center">
                    <div class="form-group col-lg-5 mb-3">
                        <div class="control-label">
                            <label class="fw-bold mb-1">Tỉnh/Thành phố<span class="text-danger">*</span></label>
                        </div>
                        <div class="" id="province_ajax">
                            <select name="province_code" class="load-provinces form-control location provinces" id="" data-target='districts'></select>
                        </div>
                    </div>
                    <div class="form-group col-lg-5 mb-3">
                        <div class=" control-label">
                            <label class="fw-bold mb-1">Quận/Huyện<span class="text-danger">*</span></label>
                        </div>
                        <div id="district_ajax">
                            <select name="district_code" class="districts select_district location form-control" data-target='wards'></select>
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-12 mb-3 d-flex justify-content-between align-item-center">
                    <div class="form-group col-lg-5 mb-3">
                        <div class=" control-label">
                            <label class="fw-bold mb-1">Phường/Xã<span class="text-danger">*</span></label>
                        </div>
                        <div id="ward_ajax">
                            <select name="ward_code" class="wards select_district form-control"></select>
                        </div>
                    </div>
                    <div class="form-group col-lg-5 mb-3">
                        <div class=" control-label">
                            <label class="fw-bold mb-1">Địa chỉ<span class="text-danger">*</span></label>
                        </div>
                        <div class="">
                            <input name="address" type="text" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-12 mb-3 d-flex" style="justify-content: end">
                    <div class=" control-label">
                        <label class="fw-bold mb-1">Đặt làm mặc định</label>
                    </div>
                    <div class="ms-2">
                        <input style="width: 16px; height: 16px;" name="default" class="form-check-input" type="checkbox" value="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="css-125hckg" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" id="save-address-main" class="css-qpwo5p">Cập nhật</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@push('scripts')
    <script>

        $('#form-save-address').submit(function(e){
           e.preventDefault();
            var formData = $(this).serialize();
            $('#save-address-main').html('<i class="fa fa-spinner fa-spin"></i>').attr("disabled", true);
            checkOut(formData);
       })

        function checkOut(formData){
            $.ajax({
                type: 'POST',
                url: '{{route('account.save-main-address-user')}}',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if(data?.status == 'error'){
                        $('#save-address-main').html('Cập nhật').attr("disabled", false);
                        show_message(data?.message, data?.status);
                        return false;
                    } else {
                        renderData(data?.model)
                        show_message(data?.message,data?.status);
                        $('#save-address-main').html('Cập nhật').attr("disabled", false);
                        $('.btn-close').trigger('click');
                        return false;
                    }

                }
            }).fail(function(result) {
                $('#save-address-main').html('Cập nhật').attr("disabled", false);
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });
        }
        function renderData(data){
           let render = $('.render_ajax');
           let html = '';
           $.each(data,function(index,item){
            let address = item?.address + ', ' + item?.province?.full_name + ", " + item?.district?.full_name + ", " + item?.ward?.full_name;
            let data_option = '';
            if(item?.default != null) {
                data_option = `
                 <button class="css-1j6k1oa edit_row_${item?.id}" onclick="editRow(${item?.id})">
                    <span class="css-1sjnqcx">Chỉnh sửa</span>
                </button>
                `
            } else {
                data_option = `
                <button class="css-1j6k1oa edit_row_${item?.id}" onclick="editRow(${item?.id})">
                    <span class="css-1sjnqcx">Chỉnh sửa</span>
                </button>
                <button height="2rem" onclick="deleteRow(${item?.id},${item?.user_id})" class="css-1wblz1b" type="button">
                    <div type="body" color="textPrimary" class="css-ughm7k">Xóa</div>
                </button>
                `
            }
            html +=
            `
                <div class="css-8mjjgr">
                <div class="wrapper">
                    <div class="teko-row css-1qrgscw justify-content-between">
                        <div class="teko-col css-17ajfcv" style="flex: 0 0 65%;">
                            <div class="teko-row teko-row-start align-items-center css-1qrgscw">
                                <div class="lzq1g0">${item?.receiver_name}</div>
                                ${item?.default ?
                                ` <span class="css-16zsojs ml-2">
                                        <div type="caption" color="primary600" class="css-1fktfn4">
                                            MẶC ĐỊNH
                                        </div>
                                    </span>` : ``}
                            </div>
                            <div class="css-1lihu4j">
                            Địa chỉ : ${address}
                            </div>
                            <div class="css-1lihu4j">
                                Điện thoại : ${item?.receiver_phone}
                            </div>
                        </div>

                        <div class="teko-col css-17ajfcv" style="flex: 0 0 35%;">
                            <div class="teko-row justify-content-end css-1qrgscw">
                                ${data_option}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `
           })
           if(html)
                render.html(html);
            return true;

        }

        function deleteRow(row,userId){
            $.ajax({
                type: 'POST',
                url: '{{route('account.remove-main-address-user')}}',
                data: {
                    id : row,
                    user_id : userId
                },
                dataType: 'json',
                success: function(data) {
                    if(data?.status == 'error'){
                        show_message(data?.message, data?.status);
                        return false
                    } else {
                        console.log(data);
                        renderData(data?.model)
                        return false;
                    }

                }
            }).fail(function(result) {
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });
        }

        function editRow(data_id){
            let _this = $('.edit_row_'+data_id);
            console.log(_this);
            let oldtext = '<span class="css-1sjnqcx">Chỉnh sửa</span>';
            _this.html('<i class="fa fa-spinner fa-spin css-1sjnqcx"></i>').attr("disabled", true);
            $.ajax({
                type: 'GET',
                url: '{{route('account.form-main-address-user')}}',
                data: {
                    id : data_id
                },
                dataType: 'json',
                success: function(data) {
                    if(data?.status == 'error'){
                        _this.html(oldtext).attr("disabled", false);
                        show_message(data?.message, data?.status);
                        return false;
                    } else {
                        console.log(data);
                        let item = data?.model;
                        $('input[name="id"]').val(item?.id);
                        $('input[name="user_id"]').val(item?.user_id);
                        if(item?.default){
                            $('input[name="default"]').val(item?.default).prop('checked',true);
                        }
                        $('input[name="receiver_name"]').val(item?.receiver_name);
                        $('input[name="receiver_email"]').val(item?.receiver_email);
                        $('input[name="receiver_phone"]').val(item?.receiver_phone);
                        $('#province_ajax').html(
                            `<select name="province_code" class="load-provinces form-control location provinces" data-target="districts">
                                <option value="${item?.province_code}">${item?.province?.full_name}</option>
                            </select>`);
                        $('#district_ajax').html(
                        `<select name="district_code" class="districts select_district location form-control" data-target="wards">
                             <option value="${item?.district_code}">${item?.district?.full_name}</option>
                        </select>`);
                        $('#ward_ajax').html(
                        `<select name="ward_code" class="wards select_district form-control">
                            <option value="${item?.ward_code}">${item?.ward?.full_name}</option>
                        </select>`);
                        $('input[name="address"]').val(item?.address);
                        load_provinces();
                        _this.html(oldtext).attr("disabled", false);
                        $('#modal-user-address').modal('show');
                        return false;
                    }

                }
            }).fail(function(result) {
                _this.html(oldtext).attr("disabled", false);
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });

        }



        $(document).ready(function () {
            $('#modal-user-address').on('hidden.bs.modal', function () {
                $('#form-save-address')[0].reset();
                $('input[name="address"]').val(' ');
                $('#province_ajax').html('<select name="province_code" class="load-provinces form-control location provinces" data-target="districts"></select>');
                $('#district_ajax').html('<select name="district_code" class="districts select_district location form-control" data-target="wards"></select>');
                $('#ward_ajax').html('<select name="ward_code" class="wards select_district form-control"></select>');
                load_provinces();
            });
        });
    </script>

@endpush
