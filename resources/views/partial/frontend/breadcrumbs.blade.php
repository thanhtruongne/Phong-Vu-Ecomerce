
@if (count($breadcrumbs))   
    @foreach ($breadcrumbs as $breadcrumb) 
    @if ($breadcrumb->url && !$loop->last)
            <a href="{{ $breadcrumb->url }}" style="color: #82869E;text-decoration: none;">
                <div class="css-kwe6s1">{!! $breadcrumb->title  !!}</div>
            </a>
            <div class="text-right;">
                <svg fill="none" viewBox="0 0 24 24" size="16" class="css-26qhcs" color="placeholder" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.49976 19.0001L15.4998 12.0001L8.49976 5.00012" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </div>
    @else
        <a href="" class="" style="color: #82869E;text-decoration: none;">
            <div class="css-kwe6s1">{!! $breadcrumb->title  !!}</div>
        </a>
     
    @endif

@endforeach
@endif