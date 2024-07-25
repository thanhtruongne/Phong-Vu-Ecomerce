@extends('Frontend.layout.layout')
@section('title')
    Ecomerce
@endsection
@section('content')
    <div class="">
        <div class="css-gjf6g1">
           <div class="d-flex" style="flex-wrap: wrap">
            {{-- Info --}}
            @include('Frontend.page.Accounts.components.sidebar',['user' => Auth::user()])

            @include('Frontend.page.Accounts.components.orderStatus',['orders' => $order])


            </div>    
        </div>
    </div>
  
@endsection