@extends('Frontend.layout.layout')
@section('title')
@endsection
@section('content')
    <div class="">
        <div class="css-gjf6g1">
           <div class="d-flex" style="flex-wrap: wrap">
            {{-- Info --}}
            @include('Frontend.page.Accounts.components.sidebar')

            @include('Frontend.page.Accounts.components.userInfo')


            </div>
        </div>
    </div>

@endsection
