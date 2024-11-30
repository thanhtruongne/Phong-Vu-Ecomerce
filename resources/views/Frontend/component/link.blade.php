@php
    // $system = json_decode($system,true) ?? [];
    $system = [];
@endphp
<meta name="copyright" content="{{ $system['homepage_index_Coypyright'] ?? '' }}"/>
<meta http-equiv="refresh" content="1800">
<link rel="icon" type="image/png" href="{{ $system['homepage_index_Logo'] ?? '' }}" sizes="30x30">
{{-- Thẻ chỉ mục goole tìm ra kết quả trên thanh tìm kiếm --}}
<meta name="robots" content="index,follow"/>
<meta name="author" content="{{ $system['homepage_index_organization'] ?? '' }}">
{{-- GOOGLE --}}
<meta property="og:locale" content="vi_VN" />
<link rel="stylesheet" href="{{ asset('frontend/boosttrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/styles/style.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/fontawesome-free-6.5.2-web/css/all.min.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/styles/plugins/glide.core.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/styles/plugins/glide.theme.css')}}">
<link rel="stylesheet" href="{{asset('frontend/styles/plugins/metisMenu.min.css')}}">
<link rel="stylesheet" href="{{asset('frontend/styles/plugins/nouislider.min.css')}}">