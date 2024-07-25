@if (count($breadcrumbs))   
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb) 
            @if ($breadcrumb->url && !$loop->last)
                <li>
                    <a href="{{ $breadcrumb->url }}">{!! $breadcrumb->title  !!}</a>
                </li>
            @else
            <li class="active">
                <strong>{{ $breadcrumb->title }}</strong>
            </li>
             
            @endif
 
        @endforeach
    </ol>
@endif