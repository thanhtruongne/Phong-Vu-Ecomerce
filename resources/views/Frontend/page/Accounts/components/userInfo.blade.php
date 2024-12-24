@php
    $user = profile();
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
                    <form action="{{ route('account.update',$user->id) }}" method="POST">
                        @csrf
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
                </div>
            </div>
        </div>


        <div class="teko-col teko-col-4 css-17ajfcv" style="margin-left: 6px;">
            <div class="css-1hlwznm ">
                <div class="">
                    <div class="d-flex justify-content-between teko-row" style="border-style: none;border-width: 1px;border-color: unset;opacity: 1;">
                        <div class="css-1w9reh3">Địa chỉ</div>
                    </div>
                        @csrf
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                               Tỉnh/Thành phố
                            </div>
                             <select name="province_code"  id="" class="provinces location form-control"  data-target='districts'>

                             </select>

                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                              Quận/Huyện
                            </div>
                            <select class="districts location form-control"   name="district_code" data-target='wards'>

                            </select>

                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                               Phường/Xã
                            </div>
                            <select class="wards location form-control" name="ward_code" >

                            </select>

                        </div>
                        <div class="" style="margin-bottom: 0.5rem;">
                            <div class="" style="font-weight: 500;line-height: 24px; margin-bottom: 4px;font-size: 13px;">
                                Địa chỉ
                            </div>
                            <input type="text"  value="{{ $user->address }}" class="css-90j4a3" name="address">
                        </div>

                </div>
            </div>

        </div>
    </div>
    <div class="w-100 mt-4">
        <button  type="submit" class="css-qpwo5p">
            <div class="css-zuesqn ">Cập nhật</div>
        </button>
    </div>
</form>
</div>

@push('scripts')
    <script>

    </script>

@endpush
