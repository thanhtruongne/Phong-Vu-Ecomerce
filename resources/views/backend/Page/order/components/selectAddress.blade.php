

<div style="width:100%;display: flex;justify-content:start;">
    <div class="" style="display: flex;justify-content:space-between;width:60%">
        <div class="" style="width:30%" >
            <select name="province_code" class="provinces location select2"  data-target='districts' style="width:100%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)" >
                <option selected value="none">Chọn thành phố / tỉnh</option>
                        {{-- @dd($provinces); --}}
                    @if(!empty($provinces))
                        @foreach (json_decode($provinces) as $province)      
                                           
                            <option 
                            @if (request('province_code') == $province->code )
                                selected
                            @endif value='{{ $province->code }}'>{{ $province->full_name }}</option>
                        @endforeach
                    @endif
            </select>
        </div>
        <div class="" style="width:30%">
            <select class="districts location select2" style="width:100%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)"  name="district_code" data-target='wards'>
                <option selected value="none">Chọn quận / huyện</option>
            </select>
        </div>
        <div class="" style="width:30%">
            <select class="wards location select2" name="ward_code" style="width:100%;outline:none;border: none;font-size: 13px;color: rgb(67, 70, 87)">
                <option selected value="none">Chọn phường / xã</option> 
            </select>
        </div>

    </div>
   
</div>