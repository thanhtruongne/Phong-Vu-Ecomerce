@extends('Frontend.layout.layout')
@section('title')
    Trang chủ
@endsection

@section('content') 
    @php
        $categoryOutstanding = $widget['category_outStanding'] ?? [];
        $brand = $widget['Brand_widget'] ?? [];
        $fieldProduct = ['macbook_widget','MSI_widget','Ram_widget','VGA_widget','CPU_widget'];
    @endphp
     {{-- banner --}}
     {{-- @include('Frontend.layout.container.banner',['slider' => []]) --}}

     <div style="height: 600vh" class="container">
        {{-- Widget for Apple --}}
        {{-- @include('Frontend.layout.container.widgets.Apple',['data' => $widget['macbook_widget']])

        {{-- Outstanding category --}}
        {{-- @include('Frontend.layout.component.categoryOutstanding',['data' => $categoryOutstanding]) --}}
        
        {{-- Product Category by Widget --}}
        {{-- @include('Frontend.layout.container.widgets.product',['data' => $widget,'fields' => $fieldProduct]) --}}
        {{-- brand --}}
        {{-- @include('Frontend.layout.component.brand',['data' => $brand]) --}}

        {{-- ProductOutstanding --}}
        {{-- @include('frontend.layout.component.productOutStanding') --}}

     </div>
     
@endsection