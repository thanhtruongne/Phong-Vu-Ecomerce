<div class="ibox-content" style="margin-top:20px;height:auto">
    <div class="form-horizontal">
            <div style="margin: 20px 0px;">
                <h3 class="text-success">{{ $title }}</h3>
            </div>
            <div>
                <div class="text-center">
                    <div class="check_hidden_image_album {{ isset($data->album) && !empty($data->album) && $data->album != 'null' ? 'hidden' : '' }}">
                        <img class="ckfinder_3" width="120" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" alt="">
                        <div style="font-size:12px"><strong>Nhấn vào để chọn ảnh phiêm bản </strong><br></div>
                    </div>
                    <div class="ul_upload_view_album clearfix" style="list-style-type: none" id="sortable_books">
                        @if (isset($data) && !empty($data))
                        @php
                            $album = !is_array($data) ? json_decode($data->album) : ($data ?? []);
                        @endphp
                        @if (!empty($album) && count($album) > 0)
                            @foreach ($album as $item) 
                            <li class="item_album" style="float:left;margin: 0 12px 12px 12px">
                                <img height="120" src="{{ $item }}" width="150" alt="">
                                <input type="hidden" name="{{ $name }}[]" value="{{ $item }}"/>
                                <button type="button" class="trash_album" >
                                    <i class="fa-solid fa-trash"></i>
                                </button >
                            </li>
                            @endforeach
                        @endif
                   
                     @endif
                    </div>
                </div>
                
            </div>    
            @if ($errors->has('album'))
            <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('album') }}(*)</div>
        @endif             
    </div>

</div>