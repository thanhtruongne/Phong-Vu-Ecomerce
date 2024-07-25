<div class="address_code_dynamic" style="display: none">
    <div class="" style="width:60%;margin-bottom:16px;">
        <select style="width:100%" class="form-control provinces select2 location" name="province_code" data-target='districts'>
              
            <option selected value="">Chọn thành phố / tỉnh</option>
            @if (!empty($provinces))
                @foreach ($provinces as $province)
                   
                    <option 
                    @if ($order->province_code == $province->code )
                        selected
                    @endif value='{{ $province->code }}'>{{ $province->full_name }}</option>
                @endforeach
            @endif
        </select>
      </div>
        <div class="" style="width:60%;margin-bottom:16px;">
            <select style="width:100%" class="form-control select2 location districts" name="district_code" data-target='wards'>
                
            </select>
        </div>
           
    
        <div class="" style="width:60%;margin-bottom:16px;">
            <select style="width:100%" class="form-control select2 location wards" name="ward_code">
                
            </select>
        </div> 
        <button type="submit" class="btn btn-primary">Lưu</button>
</form>
</div>
