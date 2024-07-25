@php
    $system = json_decode($system,true) ?? [];
@endphp
<meta name="copyright" content="{{ $system['homepage_index_Coypyright'] ?? '' }}"/>
<meta http-equiv="refresh" content="1800">
<link rel="icon" type="image/png" href="{{ $system['homepage_index_Logo'] ?? '' }}" sizes="30x30">
{{-- Thẻ chỉ mục goole tìm ra kết quả trên thanh tìm kiếm --}}
<meta name="robots" content="index,follow"/>
<meta name="description" content="{{ $Seo['desc'] ?? '' }}">
<meta name="keywords" content="{{ $Seo['keyword']  ?? ''}}">
<meta name="canonical" href="{{ $Seo['canonical']  ?? ''}}">
<meta name="author" content="{{ $system['homepage_index_organization'] ?? '' }}">
{{-- GOOGLE --}}
<meta property="og:locale" content="vi_VN" />
<meta property="og:title" content="{{ $Seo['title'] ?? '' }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $Seo['image'] ?? '' }}"/>
<meta property="og:url" content="{{ $Seo['canonical'] ?? '' }}">
<meta property="og:description" content="{{ $Seo['desc'] ?? '' }}"/>
<meta property="og:site_name" content="...">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('frontend/boosttrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/styles/style.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/fontawesome-free-6.5.2-web/css/all.min.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/styles/plugins/glide.core.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/styles/plugins/glide.theme.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/boosttrap/fontawesome-free-6.5.2-web/css/all.min.css')}}">
@if (!empty($config['links_link']))
    @foreach ($config['links_link'] as $item_link)
        <link rel="stylesheet" href="{{$item_link}}">
    @endforeach
@endif
@if (!empty($config['link']))
    @foreach ($config['link'] as $item_link)
        <link rel="stylesheet" href="{{asset($item_link)}}">
    @endforeach
@endif