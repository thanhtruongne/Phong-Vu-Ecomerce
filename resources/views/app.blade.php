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
    <title>Trang chủ</title>
     @viteReactRefresh
     <style>
        :root {
            --background-btn : "#d70018";
            --border-color-btn : :'#e45464';
            --color-btn : "#fff"
        }
     </style>
    <!-- Favicon Icon -->
    {{-- <link rel="icon" type="image/png" href="{{ image_file(\App\Models\Config::getFavicon()) }}"> --}}
</head>
<body class="font-sans antialiased">
    <div id="root"></div>
</body>

    @vite("resources/app/index.tsx")
</html>
