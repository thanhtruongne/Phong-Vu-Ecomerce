

<div class="" style="width:20%">
    <div class="" style="padding-right:1rem">
        {{-- name --}}
        <div class="d-flex flex-column">
            <div class="d-flex">
                <div class="">
                    <span class="css-j0shod"></span>
                </div>  
                <div class="" style="margin-left: 0.5rem">
                    <h6 style="margin-bottom: 0px;font-weight: 400;font-size: 0.8rem;">
                        {{ !Auth::guard('web')->check() ? 'Guest' : 'Tài khoản củ bạn' }} </h6>
                    <h5 style="font-size: 1rem;font-weight: bold;">{{ Auth::guard('web')->user()->name ?? explode('_',Cookie::get('guest_cookie'))[1] }}</h5>
                </div>
            </div>
            <ul style="padding: 0;margin: 0;list-style: none;">

                @if (!Auth::guard('web')->check())
                        <a href="{{ route('guest.order') }}" style="text-decoration: none;color:#333333" class="css_hover">
                            <div class="css-1itrv06 justify-content-between align-items-center">
                                <svg fill="none" viewBox="0 0 24 24" size="18" class="css-9w5ue6" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5328 3.5625C7.5328 3.14829 7.86859 2.8125 8.2828 2.8125H15.2308C15.645 2.8125 15.9808 3.14829 15.9808 3.5625V3.80501H19.201C19.6152 3.80501 19.951 4.14079 19.951 4.55501V20.4361C19.951 20.8503 19.6152 21.1861 19.201 21.1861H4.3125C3.89829 21.1861 3.5625 20.8503 3.5625 20.4361V4.55501C3.5625 4.14079 3.89829 3.80501 4.3125 3.80501H7.5328V3.5625ZM15.9808 7.53276V5.30501H18.451V19.6861H5.0625V5.30501H7.5328V7.53276C7.5328 7.94698 7.86859 8.28276 8.2828 8.28276H10.0198C10.434 8.28276 10.7698 7.94698 10.7698 7.53276C10.7698 7.30843 11.0628 6.87111 11.7568 6.87111C12.4508 6.87111 12.7438 7.30843 12.7438 7.53276C12.7438 7.94698 13.0796 8.28276 13.4938 8.28276H15.2308C15.645 8.28276 15.9808 7.94698 15.9808 7.53276ZM9.0328 4.3125V6.78276H9.41784C9.7871 5.89836 10.7889 5.37111 11.7568 5.37111C12.7247 5.37111 13.7265 5.89836 14.0957 6.78276H14.4808V4.3125H9.0328ZM15.4476 12.0333C15.7405 11.7404 15.7405 11.2655 15.4476 10.9726C15.1547 10.6797 14.6798 10.6797 14.3869 10.9726L11.0384 14.3211L9.80564 13.0883C9.51275 12.7954 9.03787 12.7954 8.74498 13.0883C8.45209 13.3812 8.45209 13.8561 8.74498 14.149L10.5081 15.9121C10.6487 16.0527 10.8395 16.1318 11.0384 16.1318C11.2373 16.1318 11.4281 16.0527 11.5688 15.9121L15.4476 12.0333Z" fill="#82869E"></path></svg>
                                <div class="css-rac23i">Quản lý đơn hàng</div>
                            </div>
                        </a>
                    </ul>
                @else                   
                    @foreach (config('apps.account.account_infomation') as $item)
                        <a href="{{ $item['canonical'] }}" style="text-decoration: none;color:#333333" class="css_hover">
                            <div class="css-1itrv06 justify-content-between align-items-center">
                                {!! $item['icon'] !!}
                                <div class="css-rac23i">{{ $item['title'] }}</div>
                            </div>
                        </a>
                    @endforeach
                @endif
                <hr>
            </ul>
           
        </div>


    </div>
</div>