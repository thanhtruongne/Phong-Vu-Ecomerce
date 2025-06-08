<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, shrink-to-fit=9" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, public">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>{{ trans('laother.title_project') }}</title>

    <!-- Favicon Icon -->
    {{-- <link rel="icon" type="image/png" href="{{ image_file(\App\Models\Config::getFavicon()) }}"> --}}
    <link href="{{ myasset('css/app.css') }}" rel="stylesheet">
    <script src="{{ myasset('messages.js') }}"></script>
    <script>
        window._app_env_ = '{{ config('app.env') }}';
        window._app_name_ = '{{ config('app.name') }}';
        window._asset = '{{ asset('') }}';
    </script>
    <script type="text/javascript">
        var base_url = '{{ url('/') }}';
        var language = '{{ \App::getLocale() }}';
        var csrf_token = '{{ csrf_token()  }}';
    </script>
    {{-- @php
        $nightMode = session()->exists('nightMode') && session()->get('nightMode') == 1 ? true : false;
        $get_color_link = cache()->has('color_link') ? cache('color_link') : \App\Models\SettingColor::where('name','color_link')->first();
        $color_button = cache()->has('color_button') ? cache('color_button') : \App\Models\SettingColor::where('name', 'color_button')->first();
        $get_color_menu = cache()->has('color_menu') ? cache('color_menu') : \App\Models\SettingColor::where('name', 'color_menu')->first();
        $bg_menu = (session()->exists('nightMode') && session()->get('nightMode') == 1) ? 'unset' : (get_config('bg_menu') ?? "#fff");
        $get_banner = cache()->has('slider') ? cache('slider') : \App\Models\Slider::where('type', '=', 1)->where('status', '=', 1)->exists();
        $get_secondary_theme = cache('secondary_color') ? cache('secondary_color') : \App\Models\SettingColor::where('name','secondary_color')->first();
        $get_primary_theme = cache('primary_color') ? cache('primary_color') : \App\Models\SettingColor::where('name','primary_color')->first();
    @endphp
    <script type="text/javascript">
        var primaryColor = '{{ $nightMode ? '#cccccc' : $get_primary_theme->text}}'
        var secondaryColor = '{{ $nightMode ? '#cccccc' : $get_secondary_theme->text}}'
        var thirdColor = '#14addc'
        var thirdLightColor = 'rgba(90,217,255,0.5)'
    </script> --}}
</head>
{{-- @include('layouts.themes.christmas') --}}

<body class="font-sans antialiased" style="background: #fff">
    <div id="root"></div>
</body>
<script type="text/javascript">
    localStorage.removeItem('menu_click_backend')
</script>

@vite(['resources/js/main.jsx'])
</html>