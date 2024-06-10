<div class="wrapper_slider_thumbnail" id="sortable_books">
    @if (!empty($data) && count($data) > 0)
        @foreach ($data as $keySlide => $slide)
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
</div>