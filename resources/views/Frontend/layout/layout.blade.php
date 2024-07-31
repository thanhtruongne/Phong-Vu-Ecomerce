
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     @include('Frontend.component.link')
    <title>@yield('title')</title>
</head>
<body>
    <div id="main">
        {{-- header --}}
        @include('Frontend.layout.container.header')

        <div class="body">
           <div class="render_method">
                 @yield('content');
           </div>
        </div>
        @include('Frontend.layout.container.footer')
    </div>

    @include('Frontend.component.script')
    @stack('scripts')
</body>
</html>