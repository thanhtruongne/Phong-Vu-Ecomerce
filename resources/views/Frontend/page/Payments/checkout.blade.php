@extends('Frontend.layout.layout')
@section('title')
     Thanh toán
@endsection
@section('content')

    <div class="container">
        <div class="w-100">
            <form action="" id="form-checkout-cart" method="POST" enctype="multipart/form-data">
                <div class="css-rf24tk">
                    <div class="teko-row css-zbluka" style="margin:0 -8px">
                        <div class="teko-col teko-col-8 css-17ajfcv" style="padding: 0 8px">
                            <div class="css-1eks86m">
                                <div class="css-1557c61">
                                    @php
                                        $user = profile();
                                    @endphp
                                    <div class="css-1ms22as">
                                          @include('Frontend.page.Payments.components.modal')
                                          {{-- Shipping --}}
                                          @include('Frontend.page.Payments.components.shipping_rule')
                                    </div>
                                </div>
                            </div>
                            {{-- desc --}}
                            @include('Frontend.page.Payments.components.desc')
                            {{-- mehthod payment --}}
                            @include('Frontend.page.Payments.components.paymentMethod')
                        </div>

                        {{--  --}}
                        <div class="css-9zicy3">
                            <div class="css-14xqo9c">
                                <div class="css-1euuut5">
                                    <div class="" style="font-size: 15px;line-height: 24px;font-weight: bold;">Thông tin đơn hàng</div>
                                    <a href="{{ route('cart') }}" style="text-decoration: none;color:#0d6efd">Chỉnh sửa</a>
                                </div>
                                {{-- body --}}
                                @include('Frontend.page.Payments.components.productCart',['cart' => $carts])
                            </div>
                            {{-- price --}}
                            @include('Frontend.page.Payments.components.price',['total' => $total])
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal-user-address-checkout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Thông tin nhận hàng</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form action="" id="form-save-address-checkout" class="form-validate">
                <input type="hidden" name="id" value="{{ $user->id }}">
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
@endsection


@push('scripts')
   <script>
        $('#form-checkout-cart').submit(function(e){
           e.preventDefault();
            var formData = $(this).serialize();
            $('#btn_submit_checkout').html('<i class="fa fa-spinner fa-spin"></i>').attr("disabled", true);
            checkOut(formData);
        })

        function checkOut(formData){
            $.ajax({
                type: 'POST',
                url: '{{route('order.store')}}',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if(data?.status == 'error'){
                        $('#btn_submit_checkout').html('Thanh toán').attr("disabled", false);
                        show_message(data?.message, data?.status);
                        return false;
                    } else {
                        show_message(data?.message,data?.status);
                        if(data?.url){
                            window.location.href = data?.url;
                        } else {
                            return false;
                        }
                    }
                    $('#btn_submit_checkout').html('Thanh toán').attr("disabled", false);
                }
            }).fail(function(result) {
                $('#btn_submit_checkout').html('Thanh toán').attr("disabled", false);
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });
        }
        //address
        function editAddressCheckout(data_id,user_id){
                let _this = $('.edit_row_'+data_id);
                let oldtext = '<i class="far fa-edit" style="color:rgb(132, 135, 136)"></i>';
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
                            let item = data?.model;
                            $('input[name="id"]').val(item?.id);
                            $('input[name="user_id"]').val(item?.user_id);
                            if(item?.default != null){
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
                            _this.html(oldtext);
                            $('#modal-user-address-checkout').modal('show');
                            return false;
                        }

                    }
                }).fail(function(result) {
                    _this.html(oldtext).attr("disabled", false);
                    show_message('Lỗi dữ liệu', 'error');
                    return false;
                });
        }

        function createModalAddress(){
            $('#modal-user-address-checkout').modal('show');

        }

        $('.item_app_render').on('click',function(){
            let _this = $(this);
            let id = _this.data('id');
            $('.item_app_render').each(function(index,item){
                let old_this = $(this);
                let check_id = old_this.data('id')
                if(id == check_id) {
                    let data_find = old_this.find('.option_temp').removeClass('none_active_address').addClass('active_border_address');
                    data_find.append(`
                    <div class="render_active"></div>
                    <div class="css-mpv07g render_active_icon">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    `);
                    $('input[name="id_address_main"]').val(id);
                    let data_provide = {
                        province : old_this.find('input[name="province"]').val(),
                        district : old_this.find('input[name="district"]').val(),
                        ward : old_this.find('input[name="ward"]').val(),
                        address : old_this.find('input[name="address_data"]').val(),
                    }
                    shippingFee(data_provide) // render tạm
                } else {
                    if(old_this.find('.option_temp').hasClass('active_border_address')) {
                        old_this.find('.option_temp').removeClass('active_border_address').addClass('none_active_address')
                    }
                    old_this.find('.render_active').remove();
                    old_this.find('.render_active_icon').remove();
                }
            })

        })

        $('#form-save-address-checkout').submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $('#save-address-main').html('<i class="fa fa-spinner fa-spin"></i>').attr("disabled", true);
                check_address_main(formData);
        })


        function check_address_main(formData){
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
           let render = $('.render_data_ajax_main');
           let html = '';
           $.each(data,function(index,item){
            let address = item?.address + ', ' + item?.province?.full_name + ", " + item?.district?.full_name + ", " + item?.ward?.full_name;
            html +=
            `
            <div class="teko-col teko-col-6 css-17ajfcv position-relative item_app_render" data-id="${item?.id}" style="padding-left: 8px;padding-right: 8px;">
                <div class="h-100 option_temp ${item?.default ? 'active_border_address' : 'none_active_address'}">
                    <div class="d-flex">
                        <span class="fw-bold me-2">${item?.receiver_name}</span>
                        <div class="edit_row_${item?.id}" onclick="editAddressCheckout(${item?.id},${item?.user_id})"><i class="far fa-edit" style="color:rgb(132, 135, 136)"></i></div>
                    </div>
                    <div class="">${item?.receiver_phone}</div>
                    <div class="" style="-webkit-line-clamp: 2;text-overflow: ellipsis;overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;">
                        ${address}
                    </div>
                    ${item?.default ? ` <div class="render_active"></div>
                    <div class="css-mpv07g render_active_icon">
                        <i class="fas fa-check text-white"></i>
                    </div>` : ''}
                </div>
            </div>
            `
           })
           if(html)
                render.html(html);
            return true;

        }
        $(document).ready(function () {
            $('#modal-user-address-checkout').on('hidden.bs.modal', function () {
                $('#form-save-address-checkout')[0].reset();
                $('input[name="address"]').val(' ');
                $('#province_ajax').html('<select name="province_code" class="load-provinces form-control location provinces" data-target="districts"></select>');
                $('#district_ajax').html('<select name="district_code" class="districts select_district location form-control" data-target="wards"></select>');
                $('#ward_ajax').html('<select name="ward_code" class="wards select_district form-control"></select>');
                load_provinces();
            });


            var address_attemp = @json($user_address);
            if(address_attemp != null || address_attemp?.length > 0) {
               let data_action = address_attemp[0];
               let action = {
                    province : data_action?.province?.full_name,
                    district :data_action?.district?.full_name ,
                    ward : data_action?.ward?.full_name,
                    address : data_action?.address,
               }
               shippingFee(action)
            }


        });
        function shippingFee(data){
            $.ajax({
                type: 'GET',
                url : Server_Frontend  + 'ajax/ghtk/transportfee',
                data : {
                    province : data?.province,
                    districts : data?.district,
                    ward :  data?.ward,
                    address :  data?.address,
                    value : Number($('.total_render').text().replace("đ", "").replace(/\./g, '')),
                },
                beforeSend: function() {
                    // setting a timeout
                    $('.shipping_price').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success : function(data) {

                    if(data.success && data.fee?.delivery != false) {
                        $('.shipping_price').html(' ');
                        $('body .shipping_price').html(number_format(data?.fee?.fee) + 'đ');
                        let div = $('<div>');
                        if(data?.fee?.insurance_fee) {
                            let html = `
                            <div>
                            -- <strong> Bảo hiểm đơn hàng: </strong><span class="text-danger fw-bold">${number_format(data?.fee?.insurance_fee)} đ</span>
                            </div>`
                            div.append(html);
                        }

                        if(data?.fee?.extFees.length){
                            $.each(data?.fee?.extFees,function(index,val){
                                let html = `
                                <div>
                                -- <strong>${val.title}: </strong><span class="text-danger fw-bold">${val.display}</span>
                                </div>          `
                                div.append(html);
                            })
                        } if(data?.fee?.ship_fee_only) {
                            let html = `
                            <div>
                            -- <strong> Phí vận chuyển: </strong><span class="text-danger fw-bold">${number_format(data?.fee?.ship_fee_only) } đ</span>
                            </div>`
                            div.append(html);
                        }
                        $('.render_shipping_option').html(div);
                        TriggerClickDataShippingRule();
                        setInputShippingOption(data);
                    }
                    else if(data?.fee?.delivery == false && data.success == true) {
                        let span = $('<span>').addClass('text-danger').text('Địa chỉ không hợp lệ !!!');
                        $('.shipping_price').html(span);
                    }
                },
                error : function(error) {
                    show_message(error?.message,'error');
                    return false;
                }

            })
        }


   </script>

@endpush
