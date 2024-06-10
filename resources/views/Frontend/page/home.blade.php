@extends('Frontend.layout.layout')
@section('title')
    Trang chủ
@endsection

@section('content')
     <div style="height: 600vh">
        @php
            $category = $widget['widget-main-category'];
        @endphp
        @include('Frontend.layout.container.widgets.Apple',['data' => $widget])
     </div>
     
@endsection