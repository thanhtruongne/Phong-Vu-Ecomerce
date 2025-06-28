@extends('backends.layouts.layouts')


@section('page_title')

@section('breadcrumbs')
    @php
        $breadcum = [
            [
                'name' => trans('admin.manager_slider'),
                'url' => route('private-system.slider')
            ],
            [
                'name' => 'Tạo slider',
                'url' => '#'
            ],
        ];

    @endphp
<div class="row mb-3 mt-2 bg-white">
    <div class="col-md-12 px-0">
        @include('backends.layouts.components.breadcrumb',$breadcum)
    </div>
</div>

@endsection

@section('content')

    <div class="row bg-white backend-container pt-3" style="margin-left: -15px;margin-right:-15px">
        <div class="col-md-12 pb-3">
            <div class="">

                <div class="row">
                    <form id="form-slider-save" class="w-100 form-horizontal form-ajax" style="padding: 0 15px" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$model->id}}">
                        <div class="ibox-title d-flex justify-content-between my-3" style="padding: 0 5px">
                            <span class="btn">Thông tin chung</span>
                            <button class="btn" id="submit-btn-data" type="submit">Lưu <i class="fa fa-save"></i></button>
                        </div>
                        <div class="w-100 d-flex">
                            <div class="col-lg-5">
                                <div>
                                    <div class="ibox-content">
                                        <div class="" style="display: flex;justify-content:space-between">
                                            <div class="form-group col-lg-5">
                                                <label class="control-label" style="margin-bottom:10px">Tên slider <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" name="name" value="{{ $model->name }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <label class="control-label" style="margin-bottom:10px">Từ khóa <span class="text-danger">(*)</span></label>
                                                <div class="">
                                                <input type="text" name="keyword" value="{{ $model->keyword }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" style="margin-bottom:10px">Mô tả khuyến mãi <span class="text-danger">(*)</span></label>
                                            <div class="">
                                                <textarea name="content" class="editor" data-target="content" id="content" cols="30" rows="10">{!! $model->content !!}</textarea>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-7" style="height: 500px">
                                <div class="ibox-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Thông tin Slider</h4>
                                        <div>
                                            <button type="button" class="btn btn_generate_slider">Thêm slider <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    {{-- render slider + --}}
                                    <div class="wrapper_slider_thumbnail sortable">
                                        @if ($model->id && isset($model->item) && !empty($model->item) )
                                            @foreach ($model->item as $index => $slider)
                                                <div class="thumbnail_item d-flex justify-content-between align-items-center" style="height:286px;margin:12px 0;padding:16px 0;border-bottom: 1px solid #ddd">
                                                    <div class="col-lg-3">
                                                        <img src="{{ $slider['image'] }}" style="object-fit:cover" class="ck_finder_5" width="150" height="190">
                                                        <input type="hidden" name="slider[thumbnail][]" value="{{ $slider['image'] }}" class="hidden_image" value="">
                                                    </div>
                                                    <div class="col-lg-8" style="padding-right:0;padding-left:0;">
                                                        <div style="border: 1px solid #ddd;">
                                                            <div class="tab-content">
                                                                <div id="tab" class="tab-pane active">
                                                                    <div class="panel-body">
                                                                        <div class="form-group" style="padding: 0 15px">
                                                                            <h4 for="">Mô tả</h4>
                                                                            <textarea name="slider[desc][]" id="" cols="30" class="form-control" style="height: 72px;width:100%" rows="10">{!! $slider['content']!!}</textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-lg-8">
                                                                                    <input type="text" value="{{ $slider['url'] }}" placeholder="URL" name="slider[canonical][]" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn delete_thumbnail_detail"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
<script>
    // Xử lý submit form
    $('#form-slider-save').submit(function(e) {
        e.preventDefault();
        const form = $(this)[0];
        const formData = new FormData(form); // Sử dụng FormData để hỗ trợ file
        const desc = CKEDITOR.instances['content'].getData();
        formData.append('content', desc); // Thêm nội dung CKEditor

        $('#submit-btn-data').html('<i class="fa fa-spinner fa-spin"></i> Lưu').attr('disabled', true);

        saveProductData(formData);
    });

    function saveProductData(formData) {
        $.ajax({
            type: 'POST',
            url: '{{ route('private-system.slider.save') }}',
            data: formData,
            processData: false, // Không xử lý dữ liệu (cần cho FormData)
            contentType: false, // Không set contentType (cần cho FormData)
            dataType: 'json',
            success: function(result) {
                $('#submit-btn-data').html('<i class="fa fa-save"></i> Lưu').attr('disabled', false);
                if (result.status === 'success') {
                    show_message(result.message, result.status);
                    window.location.href = result.redirect;
                } else if (result.status === 'error') {
                    show_message(result.message, result.status);
                }
            },
            error: function(result) {
                $('#submit-btn-data').html('<i class="fa fa-save"></i> Lưu').attr('disabled', false);
                show_message('Lỗi dữ liệu', 'error');
            }
        });
    }

    // Thêm slider mới
    $(document).on('click', '.btn_generate_slider', function() {
        const row = $('.wrapper_slider_thumbnail');
        row.append(createRowSliderThumbnail());
        checkRowLengthSlider();
    });

    // Kiểm tra số lượng slider
    function checkRowLengthSlider() {
        const message = $('.wrapper_slider_thumbnail .message_empty_slider');
        if ($('.thumbnail_item').length > 0) {
            message.hide();
        } else {
            message.show();
        }
    }

    // Tạo HTML cho slider mới
    function createRowSliderThumbnail(image = null) {
        const random = Math.ceil(Math.random() * 100);
        const row = $('<div>').addClass('thumbnail_item d-flex justify-content-between align-items-center').attr('style', 'height:286px; margin:12px 0; padding:16px 0; border-bottom: 1px solid #ddd;');
        const thumbnail = $('<div>').addClass('col-lg-3');
        const img = $('<img>')
            .attr('src', image || 'https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg')
            .attr('style', 'object-fit:cover;')
            .addClass('ck_finder_5')
            .attr('width', '150')
            .attr('height', '190');
        const inputHidden = $('<input>')
            .attr('type', 'hidden')
            // .attr('name', 'slider[thumbnail][]')
            .val(image || '');
        const inputFile = $('<input>')
            .attr('type', 'file')
            .attr('name', 'slider[thumbnail][]')
            .addClass('slider-file-input')
            // .attr('style', 'display:none;');

        thumbnail.append(img).append(inputHidden).append(inputFile);

        const dataInput = $('<div>').addClass('col-lg-8').attr('style', 'padding-right:0; padding-left:0;');
        const div = $('<div>').attr('style', 'border: 1px solid #ddd;');
        const tabContent = $('<div>').addClass('tab-content');
        const html = createTabPanelBody(random);
        tabContent.append(html);
        div.append(tabContent);
        dataInput.append(div);

        const divDelete = $('<div>').addClass('col-lg-1');
        const buttonDelete = $('<button>').addClass('btn delete_thumbnail_detail').attr('type', 'button').append('<i class="fa fa-trash"></i>');
        divDelete.append(buttonDelete);

        row.append(thumbnail).append(dataInput).append(divDelete);
        return row;
    }

    // Tạo tab panel cho slider
    function createTabPanelBody(random) {
        return `
            <div id="tab-${random}" class="tab-pane active">
                <div class="panel-body">
                    <div class="form-group" style="padding: 0 15px;">
                        <h4>Mô tả</h4>
                        <textarea name="slider[desc][]" class="form-control" style="height: 72px; width:100%;" rows="10"></textarea>
                    </div>
                    <div class="form-group" style="padding: 0 15px;">
                        <input type="text" placeholder="URL" name="slider[canonical][]" class="form-control">
                    </div>
                </div>
            </div>`;
    }

    // Xóa slider
    $(document).on('click', '.delete_thumbnail_detail', function() {
        $(this).parents('.thumbnail_item').remove();
        checkRowLengthSlider();
    });

    // Xử lý CKFinder
    $(document).on('click', '.ck_finder_5', function() {
        const element = $(this).siblings('.slider-file-input'); // Liên kết với input file
        const image = $(this);
        CKFinder.popup({
            chooseFiles: true,
            onInit: function(finder) {
                finder.on('files:choose', function(evt) {
                    const file = evt.data.files.first();
                    image.attr('src', file.getUrl()); // Cập nhật hình ảnh
                    element.siblings('input[name="slider[thumbnail][]"]').val(file.getUrl()); // Cập nhật input ẩn
                    // Tạo sự kiện change để input file được nhận diện
                    element[0].files = evt.data.files.toArray().map(f => f._file); // Gán file thực tế vào input
                    element.trigger('change');
                });
            }
        });
    });
</script>
@endsection
