@extends('backend.layout.layout')
@section('title')
  Cấu hình chung 
@endsection

@section('content')
@php
    $translate =  Request::segment(5) == 'translate' ? true : false;
@endphp
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
           
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('configuration-setting') }}
                <div style="width:20%">
                    <select name="" class="select2 form-control translate_language_system">
                        @if (!empty($languages))
                            @foreach ($languages as $language)
                                 <option 
                                 {{ $language->id == (!empty($language_id) ? $language_id : 1) ? 'selected' : '' }} 
                                 value="{{ $language->id }}">
                                 {{ $language->name }}
                                </option>
                            @endforeach         
                        @endif
                    </select>
                </div>
            </div>
            <form action="{{
                $translate ? 
                 route('private-system.management.configuration.setting.save.translate',['language_id' => $language_id]) 
                :
                route('private-system.management.configuration.setting.store') 
                }}"
                 method="POST" class="form-horizontal" enctype="multipart/form-data">
               @csrf
                @foreach ($system as $key => $item)
                    <div class="ibox-content" style="margin-top: 20px">
                        <div>
                            <div class="row" style="display: flex;justify-content:space-between;width:100%;margin-top:20px">
                                <div class="col-lg-3">
                                <div>
                                    <h2 class="text-success fw-bold" style="font-weight: bold;">{{ $item['label'] }}</h2>
                                    <p>{{ $item['desc'] }}</p>
                                </div>
                                </div>
                                <div class="col-lg-10">
                                    <div >
                                        <div class="ibox-content" style="border: none">
                                            @foreach ($item['value'] as $keyValue =>  $val)
                                                <div class="" style="margin-top: 5px">
                                                    <div class="form-group">                               
                                                        @php
                                                        //tạo name theo key và value
                                                            $name = $key.'_'.$keyValue;
                                                        @endphp
                                                        <label class="col-sm-2 control-label">{{ $val['label'] }} (*)</label>
                                                        @switch($val['type'])
                                                            @case('text')
                                                                {!! renderSystemInputText($name, $combineArraySystem) !!}
                                                                @break
                                                            @case('image')
                                                                {!! renderSystemInputImages($name , $val['placeholder'], $combineArraySystem) !!}
                                                                @break
                                                            @case('textarea')
                                                                {!! renderSystemInputTextArea($name , $combineArraySystem) !!}
                                                                @break
                                                            @case('select')
                                                                {!! renderSystemInputSelect($name , $val['val'] , $combineArraySystem) !!}
                                                                @break
                                                            @default
                                                                {!! renderSystemInputText($name , $combineArraySystem) !!}
                                                        @endswitch
                                                    </div>
                                                    @if ($errors->has($name))
                                                        <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first($name) }}(*)</div>
                                                    @endif
                                            </div>
                                            @endforeach
                                                               
                                        </div>
                                    
                                    </div>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
                    <button 
                        class="btn btn-primary" 
                        type="submit" 
                        style="position: fixed;
                        top: 499px;
                        padding: 14px 44px;
                        left: 28px;
                        z-index: 1000000;">
                        Tạo mới
                    </button>
            </form>
        </div>
@endsection
