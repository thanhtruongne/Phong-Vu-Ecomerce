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
                        type="text" value="{{ old('name') }}" name="name" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                    </div>
                </div>
            </div>
            @if ($errors->has('name'))
                <div class="css-fwmmrl">
                   {{  $errors->first('name') }}
                </div>
            @endif
            
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
                            type="text" value="{{ old('phone') }}" name="phone" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                        </div>
                    </div>
                </div>
                @if ($errors->has('phone'))
                    <div class="css-fwmmrl">
                        {{  $errors->first('phone') }}
                    </div>
                @endif
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
                            type="email" value="{{ old('email') }}"  name="email" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                        </div>
                    </div>
                </div>
                @if ($errors->has('email'))
                    <div class="css-fwmmrl">
                        {{  $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<hr style="margin:16px -17px;">
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
                        <div class="css-kwckz4">    
                            <select name="province_code" class="provinces location"  data-target='districts' style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)" >
                                <option selected value="">Chọn thành phố / tỉnh</option>
                                        {{-- @dd($provinces); --}}
                                    @if(!empty($provinces))
                                        @foreach ($provinces as $province)      
                                                           
                                            <option 
                                            @if (old('province_code') == $province['code'] )
                                                selected
                                            @endif value='{{ $province['code'] }}'>{{ $province['full_name'] }}</option>
                                        @endforeach
                                    @endif
                            </select>
                       
                        </div>
                    </div>
                </div>
                @if ($errors->has('province_code'))
                    <div class="css-fwmmrl">
                        {{  $errors->first('province_code') }}
                    </div>
                @endif
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
                        <div class="css-kwckz4">    
                            <select class="districts location" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)"  name="district_code" data-target='wards'>
                                    
                            </select>
                        </div>
                    </div>
                </div>
                @if ($errors->has('district_code'))
                    <div class="css-fwmmrl">
                        {{  $errors->first('district_code') }}
                    </div>
                @endif
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
                        <div class="css-kwckz4">
                            <select class="wards location" name="ward_code" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                                      
                            </select>
                       
                        </div>
                    </div>
                </div>
                @if ($errors->has('ward_code'))
                    <div class="css-fwmmrl">
                        {{  $errors->first('ward_code') }}
                    </div>
                @endif
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
                            type="text" value="{{ old('address') }}"  name="address" style="flex: 1 1 0%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                        </div>
                    </div>
                </div>
                @if ($errors->has('address'))
                    <div class="css-fwmmrl">
                        {{  $errors->first('address') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var province_id = '{{ old('province_code') }}';
    var district_id = '{{ old('district_code') }}';
    var ward_id = '{{ old('ward_code') }}';
</script>
    
@endpush    