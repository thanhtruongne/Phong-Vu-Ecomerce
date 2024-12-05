@php
    $counter = 0;
@endphp
<div class="ibox-content forum-container">
    <h2 class="st_title d-flex align-items-center">
        @foreach ($breadcum as $key => $item)
            @if ($key == 0 )
            <div class="position-relative mr-3" style="top:-3px">
                <svg fill="none" viewBox="0 0 24 24" size="24" class="css-26qhcs" color="#82869E" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.512 1.43055C11.7928 1.18982 12.2073 1.18982 12.4881 1.43055L21.4881 9.14455C21.7264 9.3488 21.8123 9.67984 21.7035 9.9742C21.5946 10.2686 21.3139 10.464 21 10.464H20.75V19.18C20.75 20.1852 19.9665 21 19 21H15V16.1776C15 15.6001 14.7542 15.0462 14.3166 14.6378C13.879 14.2294 13.2856 14 12.6667 14H11.3333C10.7144 14 10.121 14.2294 9.6834 14.6378C9.24583 15.0462 9 15.6001 9 16.1776V21H5C4.0335 21 3.25 20.1852 3.25 19.18V10.464H3.00004C2.68618 10.464 2.40551 10.2686 2.29662 9.9742C2.18773 9.67984 2.27365 9.3488 2.51195 9.14455L11.512 1.43055Z" fill="currentColor"></path></svg>
            </div>
             @else
            {{-- <i class="fas fa-angle-right mx-2"></i> --}}
            <div class="text-right mx-1">
                <svg fill="none" viewBox="0 0 24 24" size="16" class="css-26qhcs" color="#82869E" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.49976 19.0001L15.4998 12.0001L8.49976 5.00012" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </div>
            @endif
        @php
            $dropContainer = !empty($item['drop-menu'])?'relative drop-container':'';
            $arrowDrop = !empty($item['drop-menu'])?' <span class="pl-1"><i class="fas fa-caret-down"></i></span>':'';
            $dropMenu =
                '<div class="drop bg-white">
                    <ul class="list pl0">';
            if (!empty($item['drop-menu'])){
                foreach ($item['drop-menu'] as $sub){
                    $dropMenu .= '<li><a href="'.$sub['url'].'">'.$sub['name']."</a></li>";
                }
                $dropMenu.='</ul></div>';
            }else
                $dropMenu='';
        @endphp
                @if ($counter == count( $breadcum ) - 1)
                    <span  style="color: #82869E;text-decoration: none;" class="font-weight-bold css-kwe6s1 {{$dropContainer}} mybreadcrumb">{{ $item['name'] }} {!! $arrowDrop !!} {!! $dropMenu !!}</span>
                @else
                    <span  style="color: #82869E;text-decoration: none;" class=" {{$dropContainer}} css-kwe6s1 mybreadcrumb">{{ $item['name'] }} {!! $arrowDrop !!} {!! $dropMenu !!}</span>
                @endif
            {{-- @endif --}}
            @php
                $counter = $counter + 1;
            @endphp
        @endforeach
    </h2>
</div>
