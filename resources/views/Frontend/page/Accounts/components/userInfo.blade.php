@php
    $main_address = isset($user->user_session_address) && !empty($user->user_session_address)
    ?  $user->user_session_address()->where('default',1)
            ->with(['province','ward','district'])
            ->first(['address','province_code','district_code','ward_code'])
    : null;
@endphp
<div class="" style="width:80%;box-sizing: border-box;margin: 0px;min-width: 0px;">
    <div class="teko-row justify-content-center" style="flex-flow:unset;margin-left: -8px;margin-right: -8px;border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
        <div class="teko-col teko-col-8 css-17ajfcv">
            <div class="css-1hlwznm ">
                <div class="">
                    {{-- title --}}
                    <div class="d-flex justify-content-between teko-row" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
                        <div class="css-1w9reh3">Thông tin tài khoản</div>
                    </div>
                    <form id="form-method-user-detail" method="POST">
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                                Họ tên
                            </div>
                            <input type="text"  value="{{ $user->full_name }}"  class="css-90j4a3" name="name">
                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                               Email
                            </div>
                            <input type="email" value="{{ $user->email }}"  class="css-90j4a3" name="email">
                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                                Số điện thoại
                            </div>
                            <input type="text" value="{{ $user->phone }}"  class="css-90j4a3" name="phone">
                        </div>
                        <div class="w-100 mt-4">
                            <button  type="submit" class="css-qpwo5p">
                                <div class="css-zuesqn ">Cập nhật</div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="teko-col teko-col-4 css-17ajfcv" style="margin-left: 6px;">
            <div class="css-1hlwznm ">
                <div class="">
                    <div class="d-flex justify-content-between align-item-center teko-row" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
                        <div class="css-1w9reh3">Địa chỉ</div>
                        <button type="button" class="css-qpwo5p" data-bs-toggle="modal" data-bs-target="#modal-user-address">
                            <i class="fas fa-edit text-white"></i>
                        </button>
                    </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                               Tỉnh/Thành phố
                            </div>
                            <input type="text"  value="{{ $main_address ? $main_address->province->full_name : null }}" readonly class="css-90j4a3" name="province_code_read">
                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                              Quận/Huyện
                            </div>
                            <input type="text"  value="{{  $main_address ? $main_address->district->full_name : null }}" readonly class="css-90j4a3" name="district_code_read">

                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                               Phường/Xã
                            </div>
                            <input type="text"  value="{{ $main_address ? $main_address->ward->full_name : null }}" readonly class="css-90j4a3" name="ward_code_read">

                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                                Địa chỉ
                            </div>
                            <input type="text"  value="{{  $main_address ? $main_address->address : null }}" readonly class="css-90j4a3" name="address_read">
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
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button> --}}
        </div>
        <form action="" id="form-save-address" class="form-validate">
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="default" value="1">
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
                        show_message(data?.message,data?.status);
                        if(data?.model?.default) {
                            $('input[name="address_read"]').val(data?.model?.address);
                            $('input[name="province_code_read"]').val(data?.model?.province?.full_name);
                            $('input[name="district_code_read"]').val(data?.model?.district?.full_name);
                            $('input[name="ward_code_read"]').val(data?.model?.ward?.full_name);
                        }
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
