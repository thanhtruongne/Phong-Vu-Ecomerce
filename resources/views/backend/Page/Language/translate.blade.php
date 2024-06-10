@extends('backend.layout.layout');
@section('title')
    Quản lý bản dịch
@endsection

@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('languages-translate') }}           
                    <h5 style="margin-top: 6px">{{ $title['translate']['title'] }}</h5>
                
            </div>
            <div style="display: flex;justify-content:space-between;align-items:center;width:100%">
                @include('backend.component.previousTranslate',['title' => 'Thông tin bản dịch','previous' => $currentPost])
                <div style="font-size: 80px">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                @include('backend.component.followingTranslate',['title' => 'Thông tin bản dịch','dataFollow' => $postTranslated])             
            </div>
            
         
        </div>
    </div>
@endsection