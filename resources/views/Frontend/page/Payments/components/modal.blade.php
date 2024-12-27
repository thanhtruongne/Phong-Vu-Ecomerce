    <div class="">
        <div class="css-7mlvw6" style="font-weight:bold">Thông tin nhận hàng</div>
        <div class="css-4sc7mn h-100 teko-row render_data_ajax_main" style="margin-left: -8px;margin-right: -8px;row-gap: 16px;">
            @if (isset($user_address) && !empty($user_address))
            @php
                $address_main = null;
            @endphp
                @foreach ($user_address as $item)
                    @php
                        $address = $item->address . ', '. $item->province->full_name .', '. $item->district->full_name .', '. $item->ward->full_name;
                        if($item->default){
                            $address_main = $item->id;
                        }
                    @endphp
                    <div class="teko-col teko-col-6 css-17ajfcv position-relative item_app_render" data-id="{{ $item->id }}" style="padding-left: 8px;padding-right: 8px;">
                        <div class="h-100 option_temp {{ $item->default ? 'active_border_address' : 'none_active_address' }} ">
                            <div class="d-flex">
                                <span class="fw-bold me-2">{{ $item->receiver_name }}</span>
                                <div class="edit_row_{{ $item->id }}" onclick="editAddressCheckout({{ $item->id }},{{ $item->user_id }})"><i class="far fa-edit" style="color:rgb(132, 135, 136)"></i></div>
                            </div>
                            <div class="">{{ $item->receiver_phone }}</div>
                            <div class="" style="-webkit-line-clamp: 2;text-overflow: ellipsis;overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;">
                                {{ $address }}
                            </div>
                            @if ($item->default)
                                <div class="render_active"></div>
                                <div class="css-mpv07g render_active_icon">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            @endif


                        </div>
                        <input type="hidden" name="province" value="{{ $item->province->full_name}}">
                        <input type="hidden" name="district" value="{{ $item->district->full_name}}">
                        <input type="hidden" name="ward" value="{{ $item->ward->full_name}}">
                        <input type="hidden" name="address_data" value="{{ $item->address}}">
                    </div>
                @endforeach
                <div class="teko-col teko-col-6 css-17ajfcv" style="padding-left: 8px;padding-right: 8px;">
                    <div class="h-100 fill_address_checkout" onclick="createModalAddress()" style="color: rgb(132, 135, 136);min-height: 100px;flex-direction: column">
                        <i class="fas fa-plus"></i>
                        Thêm địa chỉ
                    </div>
                </div>
                <input type="hidden" name="id_address_main" value="{{ $address_main }}">
            @else
                <div class="teko-col teko-col-6 css-17ajfcv position-relative"  style="padding-left: 8px;padding-right: 8px;">
                    Trống
                </div>
            @endif


        </div>
        <hr>
    </div>
