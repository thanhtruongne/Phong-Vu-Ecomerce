@extends('backend.layout.layout');
@section('title')
    Quản lý sản phẩm
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
            {{ Breadcrumbs::render('product.create') }}           
                   
                
            </div>
            <div class="ibox-content">
                  <div>
                       <h2 class="text-success fw-bold">{{ $title['title'] }}</h2>
                  </div>
                <div>
                     <form action="{{route('private-system.management.product.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="display: flex;justify-content:space-between;width:100%;margin-top:20px">
                            <div class="col-lg-10">
                                 <div >
                                     <div class="ibox-content">
                                              <div style="margin: 20px 0px;">
                                                  <h3 class="text-success">{{ $title['general-information'] }}</h3>
                                              </div>
          
                                              <div class="" style="margin-top: 5px">
                                                      <div class="form-group">                               
                                                          <label class="col-sm-2 control-label">Tiêu đề (*)</label>
                                                          <div class="col-sm-10">
                                                              <input type="text" value="{{ old('name') }}" name="name" class="form-control onchange_title_seo_input">
                                                          </div>         
                                                      </div>
                                                      @if ($errors->has('name'))
                                                      <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('name') }}(*)</div>
                                                  @endif
                                              </div>
                                              <div class="" style="margin-top: 14px">
                                                  <div class="form-group">                               
                                                      <label class="col-sm-2 control-label">Mô tả (*)</label>
                                                      <div class="col-sm-10">
                                                          <textarea data-target="desc" id="desc" name="desc" class="form-control ckEdition">
                                                              {!! old('desc') !!}
                                                          </textarea>
                                                      </div>         
                                                  </div>
                                                  @if ($errors->has('desc'))
                                                  <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('desc') }}(*)</div>
                                              @endif
                                          </div>
                                          <div class="" style="margin-top: 5px">
                                              <div class="form-group">                               
                                                  <label class="col-sm-2 control-label">Nội dung (*)</label>
                                                  <div class="col-sm-10">
                                                      <textarea data-target="content" id="content" name="content" class="form-control ckEdition">
                                                          {!! old('content') !!}
                                                      </textarea>
                                                  </div>         
                                              </div>
                                              @if ($errors->has('content'))
                                              <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('content') }}(*)</div>
                                          @endif
                                      </div>                     
                                     </div>
                                  
                                 </div>

                                 <div>
                                    @include('backend.component.album',['title' => $title['album'],'name'=>'album'])
                                 </div>
 
                                 <div>
                                    {{-- variants --}}
                                    @include('backend.Page.product.product.component.variants')
                                 </div>

                                 <div>
                                     @include('backend.component.seo',['title' => $title['SEO-title']])
                                 </div>                 
                            </div>
                             <div class="col-lg-3">
                              <div style="height: 100%">
                                       {{-- Set giá trị mặc dịnh cho các fill variants --}}
                                <div class="ibox-content">
                                    <div style="margin: 20px 0px;">
                                        <h3 class="text-success">Thông tin chung</h3>
                                    </div>
                                   
                                    <div class="form-group" style="margin-top: 8px"><label class="control-label">Mã sản phẩm  (*)</label>
                                        <div class="">
                                            <input type="text" value="{{ old('code_product') }}" name="code_product" class="form-control">
                                        </div>
                                         @if ($errors->has('code_product'))
                                            <div class="mt-3 text-left text-danger italic" style="position: relative;left:-1px;top:10px;">{{ $errors->first('code_product') }}(*)</div>
                                        @endif
                                    </div>
                    
                            
                                    <div class="form-group" style="margin-top: 8px"><label class="control-label">Xuất xứ  (*)</label>
                                        <div class="">
                                            <input type="text" value="{{ old('name') }}" name="form" class="form-control">
                                        </div>
                                         @if ($errors->has('categories_sublist'))
                                            <div class="mt-3 text-left text-danger italic" style="position: relative;left:-1px;top:10px;">{{ $errors->first('categories_sublist') }}(*)</div>
                                        @endif
                                    </div>

                                    <div class="form-group" style="margin-top: 8px"><label class="control-label">Giá sản phẩm (mặc định)  (*)</label>
                                        <div class="">
                                            <input type="number" value="{{ old('price') }}" name="price" class="form-control">
                                        </div>
                                         @if ($errors->has('price'))
                                            <div class="mt-3 text-left text-danger italic" style="position: relative;left:-1px;top:10px;">{{ $errors->first('price') }}(*)</div>
                                        @endif
                                    </div>
                                  
                                </div>

                                  <div class="ibox-content">
                                      <div style="margin: 20px 0px;">
                                          <h3 class="text-success">{{ $title['infomation-contact'] }}</h3>
                                      </div>
                                      <div class="form-group" style="margin-top: 8px">
                                        <label class="control-label">Chọn danh mục cha (*)</label>
                                          <div class="">
                                              <select class="form-control select2" name="product_cateloge_id">
                                                      <option value="1">Root</option>
                                                  @foreach ($categories as $category)
                                                      <option {{ old('product_cateloge_id') == $category->id ? 'selected' : '' }}  value="{{ $category->id }}">
                                                          {{ str_repeat('|---',($category->depth > 0) ? $category->depth : 0) }}{{ $category->product_cateloge_translate->first()->name }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                           @if ($errors->has('product_cateloge_id'))
                                              <div class="mt-3 text-left text-danger italic" style="position: relative;left:130px">{{ $errors->first('product_cateloge_id') }}(*)</div>
                                          @endif
                                      </div>
                                   
                                      <div class="form-group" style="margin-top: 8px"><label class="control-label">Nhóm sản phẩm con (*)</label>
                                          <div class="">
                                              <select class="form-control select2" name="categories_sublist[]" multiple="multiple">                                         
                                                  @foreach ($categories as $key => $category)
                                                      <option 
                                                      {{ in_array($category->id,old('categories_sublist',[])) == true ? 'selected' : '' }}
                                                      value="{{$category->id}}">
                                                          {{ str_repeat('|---',($category->depth > 0) ? $category->depth : 0) }}{{ $category->product_cateloge_translate->first()->name }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                           @if ($errors->has('categories_sublist'))
                                              <div class="mt-3 text-left text-danger italic" style="position: relative;left:-1px;top:10px;">{{ $errors->first('categories_sublist') }}(*)</div>
                                          @endif
                                      </div>
                                      <div class="form-group" style="margin-top: 40px"><label class="control-label">Hình ảnh  (*)</label>
                                          <div class="ckfinder_12" style="border: 1px solid #ccc;cursor: pointer;" data-type="image">
                                              <input type="text" name="image" hidden >
                                              <img class="image_post_cataloge" style="width:100%" src={{ old('image') ?? "https://res.cloudinary.com/dcbsaugq3/image/upload/v1710723724/ogyz2vbqsnizetsr3vbm.jpg" }} alt="">
                                          </div>
                                          @if ($errors->has('image'))
                                              <div class="mt-3 text-left text-danger italic" >{{ $errors->first('image') }}(*)</div>
                                          @endif
                                         
                                      </div>
                                  </div>
                                 
                                  <div class="ibox-content" style="margin-top:30px" >
                                      <div style="margin: 20px 0px;">
                                          <h3 class="text-success">{{ $title['infomation-advance'] }}</h3>
                                      </div>
                                      <div class="form-group" style="margin-top: 8px"><label class="control-label">Chọn tình trạng (*)</label>
                                          <div class="">
                                              <select class="form-control select2" name="status">
                                                  @foreach ($title['status'] as $key =>  $status)
                                                      <option {{ $key == 1 ? 'selected' : '' }} value="{{ $key }}">{{ $status }}</option>
                                                  @endforeach                                   
                                              </select>
                                          </div>
                                           @if ($errors->has('status'))
                                              <div class="mt-3 text-left text-danger italic">{{ $errors->first('status') }}(*)</div>
                                          @endif
                                      </div>
                                      <div class="form-group" style="margin-top: 8px"><label class="control-label">Chọn mục điều hướng (*)</label>
                                          <div class="">
                                              <select class="form-control select2" name="follow">
                                                  @foreach ($title['follow'] as $key =>  $follow)
                                                  
                                                      <option {{ $key == 1 ? 'selected' : '' }} value="{{ $key }}">{{ $follow }}</option>
                                                  @endforeach   
                                              </select>
                                          </div>
                                           @if ($errors->has('follow'))
                                              <div class="mt-3 text-left text-danger italic">{{ $errors->first('follow') }}(*)</div>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                               
                             </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                           <div class="col-sm-4 col-sm-offset-2">
                               <button class="btn btn-primary" type="submit">Tạo mới</button>
                           </div>
                      
                     </form>
                </div>
            </div>
         
        </div>
    </div>
@endsection

     