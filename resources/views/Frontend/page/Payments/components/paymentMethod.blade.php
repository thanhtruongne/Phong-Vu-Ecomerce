     {{-- payment  method --}}
     <div class="css-1eks86m">
        <div class="css-1557c61">
            <div class="css-1ms22as">
                    <div class="css-7mlvw6" style="font-weight:bold">Phương thức thanh toán</div>
                    <div type="body" style="padding: 0 12px 12px 12px;" color="textSecondary" class="css-1npqwgp">Thông tin thanh toán của bạn sẽ luôn được bảo mật</div>
                    @foreach (config('apps.payment.method_payment') as $key => $payment)
                        <div class="d-flex align-items-center mb-2">
                            <input 
                            {{ isset($method) && !empty($method) && $method == $payment['value'] ? 'checked' : '' }} 
                            class="form-check-input me-2" name="method_payment" type="radio" id="{{ $payment['value'] }}" value="{{ $payment['value']  }}"/>
                            <label class="form-check-label" for="{{ $payment['value'] }}">
                                {{ $payment['title'] }}
                                @if (!empty($payment['logo']))
                                    <img src="{{ $payment['logo'] }}" width="20" height="20" class="object-fit-contain" alt="">
                                @endif
                                
                            </label>
                        </div>
                    @endforeach
                    
                   
            </div>
        </div>
    </div>