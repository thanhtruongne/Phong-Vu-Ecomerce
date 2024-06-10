<div class="col-lg-6" >
    <form action="{{ route('private-system.management.configuration.language.translate.dynamic') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="option[detach_id]" value="{{ $option['id'] }}">
    <input type="hidden" name="option[model]" value="{{ $option['model'] }}">
    <input type="hidden" name="option[languages_id]" value="{{ $option['languages_id'] }}">
    <div class="ibox-content" style="height: 1000px;">
             <div style="margin: 20px 0px;">
                 <h3 class="text-success">Thông tin tạo bản dịch</h3>
             </div>

              <div class="clear_both" style="margin-top: 5px">
                    <div class="form-group">                               
                         <label class="col-sm-2 control-label">Tiêu đề nhóm bài viết (*)</label>
                         <div class="col-sm-10">
                             <input type="text" value="{{ old('translate_name',$dataFollow->name ?? '') }}" name="translate_name" class="form-control onchange_title_seo_input">
                         </div>         
                     </div>
                     @if ($errors->has('translate_name'))
                     <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('translate_name') }}(*)</div>
                 @endif
             </div>
             <div class="" style="margin-top: 14px">
                 <div class="form-group clear_both">                               
                     <label class="col-sm-2 control-label">Mô tả (*)</label>
                     <div class="col-sm-10">
                         <textarea data-target="translate_desc" id="translate_desc" name="translate_desc" class="form-control ckEdition">
                             {!! old('translate_desc',$dataFollow->desc ?? '') !!}
                         </textarea>
                     </div>         
                 </div>
                
         </div>
         <div class="" style="margin-top: 5px">
             <div class="form-group">                               
                 <label class="col-sm-2 control-label">Nội dung (*)</label>
                 <div class="col-sm-10">
                     <textarea data-target="translate_content" id="translate_content" name="translate_content" class="form-control ckEdition">
                         {!! old('translate_content',$dataFollow->content ?? '') !!}
                     </textarea>
                 </div>         
             </div>
           
     </div>
        
    
           
    </div>
    <div>
        <div class="ibox-content" style="margin-top:20px;height:500px">
            <div class="form-horizontal">
                    <div style="margin: 20px 0px;">
                        <h3 class="text-success">Cấu Hình SEO</h3>
                    </div>
                    <div style="margin: 12px 0px" class="SEO">
                         <h2 class="translate_title_seo">{{ old('translate_meta_title',($dataFollow->meta_title) ?? 'Báo Thanh Niên: Tin tức 24h mới nhất, tin nhanh, tin nóng ..') }}</h2>
                         <span class="translate_link_seo">{{ old('translate_meta_link',($dataFollow->meta_link) ?? 'http://localhost:8000/private') }} </span>
                         <p class="translate_desc_seo">{{ old('translate_meta_desc',($dataFollow->meta_desc) ?? 'Tin tức 24h, đọc báo TN cập nhật tin nóng online Việt Nam và thế giới mới nhất trong ngày, tin nhanh thời sự, chính trị, xã hội hôm nay, tin tức, top news ...') }}</p>
                    </div>
                    <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tiêu đề SEO (*)</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('translate_meta_title',($dataFollow->meta_title) ?? '') }}" name="translate_meta_title" class="form-control translate_meta_title">
                        </div>
                       
                    </div>
                    <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Từ khóa SEO (*)</label>
                         <div class="col-sm-10">
                             <input type="text" value="{{ old('translate_meta_keyword',($dataFollow->meta_keyword) ?? '') }}" name="translate_meta_keyword" class="form-control">
                         </div>
                      
                     </div>
                     <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Mô tả SEO (*)</label>
                         <div class="col-sm-10">
                             <textarea value="{{ old('translate_meta_desc') }}" name="translate_meta_desc" class="form-control translate_meta_desc">{{ old('translate_meta_desc',($dataFollow->meta_desc) ?? '') }}</textarea>
                         </div>
                         
                     </div>
        
                     <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Đường dẫn SEO (*)</label>
                         <div class="col-sm-10">
                             <input placeholder="Nhập tiếp tục url theo đường dãn bên dưới " type="text" value="{{ old('translate_meta_link',($dataFollow->meta_link) ?? '') }}" name="translate_meta_link" class="form-control translate_meta_link">
                         </div>
                         <div >
                             <span style="padding-left: 15px;margin:12px 0px">{{ env('APP_URL_DEFAULT') }}</span>
                         </div>
                         @if ($errors->has('translate_meta_link'))
                     <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('translate_meta_link') }}(*)</div>
                 @endif
                     </div>              
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-sm-offset-2">
        <button class="btn btn-primary" type="submit" style="position: fixed;bottom:38px;right:36px;z-index:190000000">Cập nhật</button>
    </div>     
</form>
</div>
