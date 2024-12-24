

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
                        Tài khoản của bạn
                    <h5 style="font-size: 1rem;font-weight: bold;">{{profile()->full_name }}</h5>
                </div>
            </div>
            <ul style="padding: 0;margin: 0;list-style: none;">
                @foreach (config('apps.account.account_infomation') as $item)
                    <a href="{{ $item['canonical'] }}" style="text-decoration: none;color:#333333" class="css_hover">
                        <div class="css-1itrv06 justify-content-between align-items-center">
                            {!! $item['icon'] !!}
                            <div class="css-rac23i">{{ $item['title'] }}</div>
                        </div>
                    </a>
                @endforeach
                <hr>
            </ul>

        </div>


    </div>
</div>
