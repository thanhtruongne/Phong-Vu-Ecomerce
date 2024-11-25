@extends('Frontend.layout.layout')
@section('title')
    Trang chủ
@endsection

@section('content') 
     {{-- banner --}}
     @include('Frontend.layout.container.banner',['slider' => $slider])

    <div style="height: 600vh" class="container">
        {{-- Widget for Apple --}}
        {{-- @include('Frontend.layout.container.widgets.Apple',['data' => $widget['macbook_widget']])

        {{-- Outstanding category --}}
        @include('Frontend.layout.component.categoryOutstanding',['data' => $productCategory])
        
        {{-- Product Category by Widget --}}
        @include('Frontend.layout.container.widgets.product',['widgets' => $widgets])
        {{-- brand --}}
        {{-- @include('Frontend.layout.component.brand',['data' => $brand]) --}}

        {{-- ProductOutstanding --}}
        {{-- @include('frontend.layout.component.productOutStanding') --}}
    </div>
     
@endsection