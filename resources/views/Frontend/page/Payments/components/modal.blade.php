<div class="css-7mlvw6" style="font-weight:bold">Thông tin nhận hàng</div>
<div class="css-4sc7mn h-100">
    <div class="css-iu028d">
        <div class="teko-col css-1yvcaye text-start">
            <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                <div class="css-3mfztx">Họ tên</div>
            </label>
        </div>
        <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
            <div class="" style="flex: 1 1 auto;max-width: 100%;">
                <div class="css-rznjps">
                    <div class="css-kwckz4">
                        <input
                        class="w-100 bg-white h-100"
                        type="text" value="{{ $user->full_name }}" name="receiver_name" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="w-100 d-flex justify-content-between">
        <div class="teko-col-6 css-iu028d">
            <div class="teko-col css-1yvcaye text-start">
                <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                    <div class="css-3mfztx">Số điện thoại</div>
                </label>
            </div>
            <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
                <div class="" style="flex: 1 1 auto;max-width: 100%;">
                    <div class="css-rznjps">
                        <div class="css-kwckz4">
                            <input
                            class="w-100 bg-white h-100"
                            type="text" value="{{  $user->phone }}" name="receiver_phone" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="teko-col-4 css-iu028d">
            <div class="teko-col css-1yvcaye text-start">
                <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                    <div class="css-3mfztx">Email</div>
                </label>
            </div>
            <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
                <div class="" style="flex: 1 1 auto;max-width: 100%;">
                    <div class="css-rznjps">
                        <div class="css-kwckz4">
                            <input
                            class="w-100 bg-white h-100"
                            type="email" value="{{ $user->email }}"  name="receiver_email" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="css-7mlvw6" style="font-weight:bold">Địa chỉ nhận hàng</div>
<div class="css-4sc7mn h-100">

    <div class="w-100 d-flex justify-content-between">
        <div class="teko-col-6 css-iu028d">
            <div class="teko-col css-1yvcaye text-start">
                <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                    <div class="css-3mfztx">Tỉnh/Thành phố</div>
                </label>
            </div>
            <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
                <div class="" style="flex: 1 1 auto;max-width: 100%;">
                    <div class="css-rznjps">
                        <select name="receiver_province" class="load-provinces form-control location provinces"  data-target='districts' style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)" >
                            <option selected value="">Chọn thành phố / tỉnh</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="teko-col-4 css-iu028d">
            <div class="teko-col css-1yvcaye text-start">
                <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                    <div class="css-3mfztx">Quận/Huyện</div>
                </label>
            </div>
            <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
                <div class="" style="flex: 1 1 auto;max-width: 100%;">
                    <div class="css-rznjps">
                            <select class="districts select_district location form-control" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)"  name="receiver_district" data-target='wards'>
                                    <option value="">Chọn</option>
                            </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 d-flex justify-content-between">
        <div class="teko-col-6 css-iu028d">
            <div class="teko-col css-1yvcaye text-start">
                <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                    <div class="css-3mfztx">Phường/Xã</div>
                </label>
            </div>
            <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
                <div class="" style="flex: 1 1 auto;max-width: 100%;">
                    <div class="css-rznjps">
                            <select class="wards select_district form-control" name="receiver_ward" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                                <option value="">Chọn</option>
                            </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="teko-col-4 css-iu028d">
            <div class="teko-col css-1yvcaye text-start">
                <label for="" style="display: inline-flex;height:40px;align-items: center;margin-right: 8px;">
                    <div class="css-3mfztx">Địa chỉ</div>
                </label>
            </div>
            <div class="teko-col css-rznjps d-flex justify-content-center flex-column">
                <div class="" style="flex: 1 1 auto;max-width: 100%;">
                    <div class="css-rznjps">
                        <div class="css-kwckz4">
                            <input
                            class="w-100 bg-white h-100"
                            type="text" value="{{ $user->address }}"  name="receiver_address" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

</script>

@endpush
