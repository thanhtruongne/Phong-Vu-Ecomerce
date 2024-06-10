@extends('backend.layout.layout');
@section('title')
    Quản lý Slider
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('slider-create') }}              
            </div>       
            <form action="{{ route('private-system.management.slider.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                <div>
                    <div class="row" style="width:100%;margin-top:20px">  
                            @if ($errors->any())
                                <div class="alert alert-danger" style="margin: 0 -15px 0 15px">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    </div>                         
                </div>            
                    
                @php
                    $dataOld = [];
                   if(!empty(old('slide'))) {
                        $slides = old('slide');
                        foreach($slides['thumbnail'] as $key => $val) {
                            $dataOld[] = [
                                'thumbnail' => $val,
                                'desc' => $slides['desc'][$key],
                                'canonical' => $slides['canonical'][$key],
                                'window' => $slides['window'][$key],
                                'name' => $slides['name'][$key],
                                'alt' => $slides['alt'][$key],
                                'random_class' => $slides['random_class'][$key]
                            ];
                        };
                   }
                @endphp

                <div class="" style="margin: 0">
                    <div class="row">                       
                            <div class="col-lg-8">                        
                                <div class="ibox-content">
                                    <div style="display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        margin-left: -19px;
                                        border-bottom: 1px solid #ccc;
                                        margin-right: -19px;padding-bottom:14px;padding-left:12px;padding-right:12px">
                                        <h4>Thông tin Slider</h4>
                                        <div>
                                            <button type="button" class="btn btn-primary btn_generate_slider">Thêm slide  <i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div style="margin-left: -19px;margin-right: -19px;">
                                        {{-- <div class="wrapper_slider_thumbnail" id="sortable_books">
                                            @if (!empty($dataOld) && count($dataOld) > 0)
                                                @foreach ($dataOld as $keySlide => $slide)
                                                    <div class="thumbnail_item" style="height:286px;margin:12px 0;padding:16px 0;border-bottom: 1px solid #ddd">
                                                        <div class="col-lg-3">
                                                            <img src="{{ $slide['thumbnail'] }}" style="object-fit:cover" class="ck_finder_5" width="150" height="190">
                                                            <input type="hidden" name="slide[thumbnail][]" value="{{ $slide['thumbnail'] }}" class="hidden_image" value="">
                                                        </div>
                                                        <div class="col-lg-9" style="padding-right:0;padding-left:0;">
                                                            <ul class="nav nav-tabs">
                                                                <li class="active"><a href="#tab-1-{{ $slide['random_class'] }}" data-toggle="tab" aria-expanded="false">Thông ti chung</a></li>
                                                                <li><a href="#tab-2-{{ $slide['random_class'] }}" data-toggle="tab" aria-expanded="true">Thông ti SEO</a></li>
                                                            </ul>
                                                        <div style="border: 1px solid #ddd;border-top:none"><div class="tab-content">
                                                            <div id="tab-1-{{$slide['random_class'] }}" class="tab-pane active">
                                                                <div class="panel-body">
                                                                <div class="form-group" style="padding: 0 15px">
                                                                    <h4 for="">Mô tả</h4>
                                                                    <textarea name="slide[desc][]" id="" cols="30" class="form-control" style="height: 72px;width:100%" rows="10">{!! $slide['desc']!!}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-lg-8">
                                                                            <input type="text" value="{{ $slide['canonical'] }}" placeholder="URL" name="slide[canonical][]" class="form-control">
                                                                    </div>
                                                                    <div class="col-lg-4" style="height: 34px">
                                                                        <span>Mở ra tab mới</span>
                                                                        <input type="checkbox" {{ $slide['window'] == 1 ? 'checked' : '' }} name="slide[window][]" value="1">
                                                                    </div>
                                                                </div>
                                                                
                                                                </div>
                                                            </div> 
                                                            <div id="tab-2-{{ $slide['random_class'] }}" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="form-group" style="padding: 0 15px">
                                                                        <h4 for="">Tiêu đề ảnh</h4>
                                                                        <input name="slide[name][]" value="{{ $slide['name'] }}" class="form-control">
                                                                    </div>
                                                                    <div class="form-group" style="padding: 0 15px">
                                                                        <h4 for="">Mô tả ảnh</h4>
                                                                        <input name="slide[alt][]" value="{{$slide['alt'] }}" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <span style="position: relative; top: -236px; left: 661px;font-size: 22px;cursor: pointer" class="delete_thumbnail_detail"><i class="fa-solid fa-trash"></i></span>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <h4 style="padding: 30px 15px" class="message_empty_slider text-danger">Dữ liệu slider(thumbnails) trống </h4>
                                        </div> --}}@include('backend.Page.slider.component.thumbnails',['data' => $dataOld]);
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-lg-4">
                                <div class="ibox-content">
                                    <div style="
                                        margin-left: -19px;
                                        border-bottom: 1px solid #ccc;
                                        margin-right: -19px;padding-bottom:14px;padding-left:12px;padding-right:12px">
                                        <h4>Thiết lập thông tin</h4>
                                    </div>
                                    <div class="option_choose_slider" style="margin-top:20px">
                                        <div class="form-group" style="padding: 0 15px">
                                            <label for="">Têh slide</label>
                                            <input name="name" value="{{ old('name') }}"  class="form-control"/>
                                        </div>
                                        <div class="form-group" style="padding: 0 15px">
                                            <label for="">Từ khóa Slide</label>
                                            <input name="keyword" value="{{ old('keyword') }}" class="form-control"/>
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Chiều rộng</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input type="number"   name="setting[width]" value="{{ old('setting')['width']  ?? 0}}" class="form-control"/>
                                                <span style="position: absolute;top: 6px;right: 6px;">px</span>
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Chiều dài</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input 
                                                type="number" 
                                                 name="setting[height]" 
                                                 value="{{ old('setting')['height']  ?? 0}}"  class="form-control"/>
                                                <span style="position: absolute;top: 6px;right: 6px;">px</span>
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Hiệu ứng</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <select name="setting[effect]" id="" class="form-control select2">
                                                    @foreach (__('slider.effect') as $key => $slider)
                                                        <option 
                                                        {{ !empty(old('setting')['effect']) &&  old('setting')['effect'] == $key ? 'selected' : '' }} 
                                                        value="{{ $key }}">{{ $slider }}</option>
                                                    @endforeach
                                                </select>
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Mũi tên</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input 
                                                {{ !empty(old('setting')['arrow']) && old('setting')['arrow'] == 1 ? 'checked' : '' }}
                                                 type="checkbox"
                                                 name="setting[arrow]" value="1">
                                            </div>   
                                        </div>
                                        
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Điều hướng</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                @foreach (__('slider.directional') as $key =>  $item)
                                                    <div>
                                                        <input  
                                                            {{ !empty(old('setting')['directional']) && old('setting')['directional'] == $key ? 'checked' : '' }} 
                                                            type="radio"
                                                            id="{{ $key }}"
                                                            value="{{ $key }}"
                                                            name="setting[directional]">
                                                        <label for="{{ $key }}">{{ $item }}</label>
                                                    </div>
                                                @endforeach  
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Auto</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input type="checkbox" {{!empty(old('setting')['auto']) && old('setting')['auto'] == 1 ? 'checked' : '' }} name="setting[auto]" value="1">
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Code #</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input name="short_code" value="{{ old('short_code','') }}" class="form-control"/>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                    </div>
                </div>  
               
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                     <div class="col-sm-4 col-sm-offset-2">
                         <button type="submit" class="btn btn-primary" type="submit">Tạo mới</button>
                     </div>
                    </div>
                </form>
    </div>
@endsection

     