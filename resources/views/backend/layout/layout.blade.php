<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <title>@yield('title')</title>
    @stack('links')
    @include('backend.component.link')
    <style>
        .italic {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        {{-- sidebar --}}
        {{-- @include('backend.component.sidebar'); --}}
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
            {{-- Nav bar --}}
             @include('backend.component.navbar');
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                   {{-- Content --}}
                   @yield('content')
                </div>
                
                @include('backend.component.footer');
            </div>
    </div>

    <script>
        var SUFFIX = '{{ config('apps.post.post-cataloge.sufflix') }}';
        var URL_ORINGINAL = '{{ config('app.url_original') }}';
        var URL_SERVER = '{{ config('app.url_original') }}private/system/';
     </script>
    
    @include('backend.component.scripts');
    @stack('scripts')
   
</body>
</html>
