@extends('backend.layout.layout');
@section('title')
    Đơn hảng hủy
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                <div class="" style="width:14%;align-items:center;display:flex;justify-content:space-between">
                    {{ Breadcrumbs::view('partial.frontend.breadcrumbs','order_cancel') }}      
                </div>

            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width:100%">
                        <div class="w-100" style="display: flex;justify-content:space-between;align-items:center">
                            <div class="" style="width:20%">
                                <input type="text" value="{{ request('datefilter') ?: old('datefilter') }}" placeholder="Chọn mốc thời gian" name="datefilter" class="input-sm form-control input-s-sm inline">
                            </div>
                            @include('backend.Page.order.components.select')
                          

                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                        <div class="" style="display: flex;align-items:center;margin-top:20px">
                            @include('backend.Page.order.components.selectAddress')
                            <div class=""  style="width:30%">
                                <input type="text" value="{{ request('search') ?: old('search') }}" name="search" placeholder="Tìm kiếm keyword" class="input-sm form-control input-s-sm inline">
                            </div>
                        </div>
                    
                    </form>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>Mã đơn hàng</th>
                            <th>Ngày tạo</th>
                            <th>Thời gian hủy</th>
                            <th rowspan="2">Người mua</th>
                            <th>Tổng tiền</th>
                            <th>Phí ship</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái ĐH</th>
                            {{-- <th>Thanh toán</th> --}}
                        </tr>
                        
                        </thead>
                        <tbody>
                         @if (count($order) > 0)
                            @foreach ($order as $key =>  $item)
                            @php      
                                  
                                $provinces_code = $item->province ? $item->province->full_name  : ''; 
                                $districts_code = $item->district ? $item->district->full_name  : ''; 
                                $wards_code = $item->ward ? $item->ward->full_name  : ''; 
                                $address = $item->address.', '.$wards_code.', '.$districts_code.', '.$provinces_code;
                            @endphp
                                <tr class="">
                                    <td> 
                                        {{ $item->code }}
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($item->created)->format('H:i d/m/Y') }}
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($item->deleted_at)->format('H:i d/m/Y') }}
                                    </td>
                                    <td> 
                                        @if (!is_null($item->guest_cookie))
                                            <ul>
                                                <li>Khách</li>
                                                <li>{{ $item->name.'-'.$item->email }}</li>
                                                <li>{{ $item->phone }}</li>
                                                <li>{{ $address }}</li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li>Người dùng</li>
                                                <li>{{ $item->name.'-'.$item->email }}</li>
                                                <li>{{ $item->phone }}</li>
                                                <li>{{ $address }}</li>
                                            </ul>    
                                        @endif
                                    </td>
                                    <td>
                                        {{ convert_price($item->cart['total'],true) }}đ
                                    </td>
                                    <td> 
                                        {{ convert_price($item->shipping_options['total'],true)}}đ
                                    </td>
                                    <td class="" style="text-align: center">{!! payment_svg($item->method) !!}</td>
                                    <td>
                                        @if ($item->confirm != 'confirmed' && $item->payment == 'unpaid')
                                            <select 
                                            name="confirm" class="form-control change_confirm" data-code="{{ $item->code }}" style="width:160px;" id=""
                                            disabled
                                            >
                                                @foreach (config('apps.payment.payment_confirm') as $key => $confirm)
                                                    <option
                                                    {{ $item->confirm == $key ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $confirm['title'] }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($item->confirm != 'confirmed')
                                            <select 
                                            name="confirm" class="form-control change_confirm" data-code="{{ $item->code }}" style="width:160px;" id=""
                                            {{ $item->confirm == 'paid' ? 'disabled' : '' }}
                                            >
                                                @foreach (config('apps.payment.payment_confirm') as $key => $confirm)
                                                    <option
                                                    {{ $item->confirm == $key ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $confirm['title'] }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                        <div class="" style="margin-top: 12px">
                                            {!! confirm_order_status_admin($item->confirm) !!}
                                        </div>
                                           
                                        @endif
                                    </td>
                                   
                                </tr>
                            @endforeach
                            
                         @else
                            <tr class="text-center">
                                <td> Danh sách trống !</td>
                            </tr>
                         @endif
                       
                       
                        </tbody>
                    </table>
                </div>
              
            </div>
        </div>
    </div>

    @push('scripts')
            <script type="text/javascript">

    var province_id = '{{ request('province_code') }}';
    var district_id = '{{ request('district_code') }}';
    var ward_id = '{{ request('ward_code')}}';

                $(function() {
                
                $('input[name="datefilter"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });
                
                $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                });
                
                $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                
                });
            </script>
    @endpush
@endsection
