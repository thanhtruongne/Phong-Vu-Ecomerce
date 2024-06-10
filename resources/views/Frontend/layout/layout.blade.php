
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     @include('Frontend.component.link')
    <title>@yield('title')</title>
</head>
<body>

    <div id="main">
        {{-- header --}}
        @include('Frontend.layout.container.header')

        <div class="body">
           {{-- Banner --}}
           @include('Frontend.layout.container.banner')
        

           <div class="render_method">
                 @yield('content')
           </div>

        </div>
    </div>

    @include('Frontend.component.script')
    @stack('scripts')
</body>
</html>