@extends('Frontend.layout.layout')
@section('title')
@endsection
@section('content')
    <div class="">
        <div class="css-gjf6g1">
           <div class="d-flex" style="flex-wrap: wrap">
            {{-- Info --}}

            @include('Frontend.page.Accounts.components.sidebar',['user' =>$profile])

            @include('Frontend.page.Accounts.components.userInfo',['user' => $profile])


            </div>    
        </div>
    </div>
  
@endsection