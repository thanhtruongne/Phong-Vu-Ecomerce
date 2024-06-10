<div class="col-lg-6">
    <div class="ibox-content " style="height: 1000px;">
             <div style="margin: 20px 0px;">
                 <h3 class="text-success">Thông tin tạo bản dịch</h3>
             </div>

             <div class="clear_both" style="margin-top: 5px">
                     <div class="form-group">                               
                         <label class="col-sm-2 control-label">Tiêu đề nhóm bài viết (*)</label>
                         <div class="col-sm-10">
                             <input disabled type="text" value="{{ old('name',$previous->name) }}" name="name" class="form-control onchange_title_seo_input">
                         </div>         
                     </div>
                     @if ($errors->has('name'))
                     <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('name') }}(*)</div>
                 @endif
             </div>
             <div class="" style="margin-top: 14px">
                 <div class="form-group clear_both">                               
                     <label class="col-sm-2 control-label">Mô tả (*)</label>
                     <div class="col-sm-10">
                         <textarea data-target="desc" id="desc" name="desc" disabled class="form-control ckEdition">
                             {!! old('desc',$previous->desc) !!}
                         </textarea>
                     </div>         
                 </div>
                 @if ($errors->has('description'))
                 <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('description') }}(*)</div>
             @endif
         </div>
         <div class="" style="margin-top: 5px">
             <div class="form-group clear_both">                               
                 <label class="col-sm-2 control-label">Nội dung (*)</label>
                 <div class="col-sm-10">
                     <textarea data-target="content" disabled id="content" name="content" class="form-control ckEdition">
                         {!! old('content',$previous->content) !!}
                     </textarea>
                 </div>         
             </div>
             @if ($errors->has('content'))
             <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('content') }}(*)</div>
         @endif
     </div>        
    </div>
    <div class="ibox-content" style="margin-top:20px;height:500px">
        <div class="form-horizontal">
                <div style="margin: 20px 0px;">
                    <h3 class="text-success">Cấu hình SEO</h3>
                </div>
                <div style="margin: 12px 0px" class="SEO">
                     <h2 class="title_seo">{{ old('meta_title',($previous->meta_title) ?? 'Báo Thanh Niên: Tin tức 24h mới nhất, tin nhanh, tin nóng ..') }}</h2>
                     <span class="link_seo">{{ old('meta_link',($previous->meta_link) ?? 'http://localhost:8000/private') }} </span>
                     <p class="desc_seo">{{ old('meta_desc',($previous->meta_desc) ?? 'Tin tức 24h, đọc báo TN cập nhật tin nóng online Việt Nam và thế giới mới nhất trong ngày, tin nhanh thời sự, chính trị, xã hội hôm nay, tin tức, top news ...') }}</p>
                </div>
                <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tiêu đề SEO (*)</label>
                    <div class="col-sm-10">
                        <input type="text" disabled value="{{ old('meta_title',($previous->meta_title) ?? '') }}" name="meta_title" class="form-control title_seo_link_meta">
                    </div>
                    @if ($errors->has('meta_title'))
                        <div class="mt-3 text-left text-danger italic" style="position: relative;left:146px">{{ $errors->first('meta_title') }}(*)</div>
                    @endif
                </div>
                <div class="form-group " style="margin-top: 8px"><label class="col-sm-2 control-label">Từ khóa SEO (*)</label>
                     <div class="col-sm-10">
                         <input type="text" disabled value="{{ old('meta_keyword',($previous->meta_keyword) ?? '') }}" name="meta_keyword" class="form-control">
                     </div>
                     @if ($errors->has('meta_keyword'))
                         <div class="mt-3 text-left text-danger italic" style="position: relative;left:146px">{{ $errors->first('meta_keyword') }}(*)</div>
                     @endif
                 </div>
                 <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Mô tả SEO (*)</label>
                     <div class="col-sm-10">
                         <textarea value="{{ old('meta_desc') }}" disabled name="meta_desc" class="form-control desc_seo_title">{{ old('meta_desc',($previous->meta_desc) ?? '') }}</textarea>
                     </div>
                     @if ($errors->has('meta_desc'))
                         <div class="mt-3 text-left text-danger italic" style="position: relative;left:146px"   >{{ $errors->first('meta_desc') }}(*)</div>
                     @endif
                 </div>
    
                 <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Đường dẫn SEO (*)</label>
                     <div class="col-sm-10">
                         <input placeholder="Nhập tiếp tục url theo đường dãn bên dưới " disabled type="text" value="{{ old('meta_link',($previous->meta_link) ?? '') }}" name="meta_link" class="form-control link_seo_href_title">
                     </div>
                     <div >
                         <span style="padding-left: 15px;margin:12px 0px">{{ env('APP_URL_DEFAULT') }}</span>
                     </div>
                     @if ($errors->has('meta_link'))
                         <div class="mt-3 text-left text-danger italic" style="position: relative;left:146px">{{ $errors->first('meta_link') }}(*)</div>
                     @endif
                 </div>              
        </div>
    </div>
</div>