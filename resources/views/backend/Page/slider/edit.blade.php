@extends('backend.layout.layout');
@section('title')
    Quản lý Slider
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('slider-edit') }}              
            </div>       
            <form action="{{ route('private-system.management.slider.update',$slider->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                   $setting = json_decode($slider->setting,true);
                   $item = json_decode($slider->item,true);
                   $code = $slider->short_code;
                  
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
                                          @include('backend.Page.slider.component.thumbnails',['data' => !empty($dataOld) ? $dataOld : $item]);
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
                                            <input name="name" value="{{ old('name',$slider->name) }}"  class="form-control"/>
                                        </div>
                                        <div class="form-group" style="padding: 0 15px">
                                            <label for="">Từ khóa Slide</label>
                                            <input name="keyword" value="{{ old('keyword',$slider->keyword) }}" class="form-control"/>
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Chiều rộng</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input type="number"   name="setting[width]" value="{{ !empty($setting) ? $setting['width'] : old('setting')['width']}}" class="form-control"/>
                                                <span style="position: absolute;top: 6px;right: 6px;">px</span>
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Chiều dài</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input 
                                                type="number" 
                                                 name="setting[height]" 
                                                 value="{{ !empty($setting) ? $setting['height'] : old('setting')['height']}}"  class="form-control"/>
                                                <span style="position: absolute;top: 6px;right: 6px;">px</span>
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Hiệu ứng</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <select name="setting[effect]" id="" class="form-control select2">
                                                    @foreach (__('slider.effect') as $key => $slider)
                                                        <option 
                                                        {{ (!empty($setting['effect']) ? $setting['effect'] : old('setting')['effect']) == $key ? 'selected' : '' }} 
                                                        value="{{ $key }}">{{ $slider }}</option>
                                                    @endforeach
                                                </select>
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Mũi tên</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input 
                                                {{ (!empty($setting['arrow']) ? $setting['arrow'] : old('setting')['arrow']) == '1' ? 'checked' : '' }} 
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
                                                        {{ (!empty($setting['directional']) ? $setting['directional'] : old('setting')['directional']) == $key ? 'checked' : '' }} 
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
                                                <input type="checkbox" {{ (!empty($setting['auto']) ? $setting['auto'] : old('setting')['auto']) == '1' ? 'checked' : '' }}  name="setting[auto]" value="1">
                                            </div>   
                                        </div>
                                        <div class="form-group" style="padding: 0 15px;display:flex;align-items:center">
                                            <div class="col-lg-4" style="padding-left: 0">Code #</div>
                                            <div class="col-lg-8" style="padding-right: 0;position: relative;">
                                                <input type="text" name="short_code" value="{{ old('short_code',$code) }}" class="form-control"/>
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
                         <button type="submit" class="btn btn-primary" type="submit">Cập nhật mới</button>
                     </div>
                    </div>
                </form>
    </div>
@endsection

     