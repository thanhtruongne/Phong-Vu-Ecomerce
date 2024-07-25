<div class="css-mhnea9">
    @if (isset($descentanof) && !empty($descentanof))
        @foreach ($descentanof as $descentan)

            <a href="{{ $descentan->canonical }}" data-id="{{ $descentan->id }}" class="css-1h3fn00">
                <button class="css-uros0k">
                    <div class="w-100 h-100">
                        <img class="w-100 h-100 object-fit-contain" src="{{ json_decode($descentan->album)[0] }}" alt="">
                    </div>
                </button>
            </a>
        @endforeach
    @endif
   
</div>