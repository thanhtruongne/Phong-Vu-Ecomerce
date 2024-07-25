<div class="ibox-content" style="margin-top:20px;height:auto">
    <div class="form-horizontal">
            <div style="margin: 20px 0px;">
                <h3 class="text-success">CÁC PHIÊN BẢN SẢN PHẨM</h3>
                <p>Cho phép các sản phẩm có nhiều phiên bản khác nhau như 
                    <strong class="text-danger">màu sắc</strong> và
                    <strong class="text-danger">size</strong>
                    . Chọn các phiên bản bên dưới 
                </p>
            </div>
            <div>
             <div class="row">
                <div class="i-checks">
                    <label for="accept_variants_attribute" class="label_attribute_variants"> 
                        <input 
                            type="checkbox" 
                            class="form-check-input"
                            value="1"
                            {{
                              ( old('accept_variants_attribute') == 1  || (!empty($product) && count($product->product_variant) > 0)) ? 'checked' : ''
                            }}
                            id="accept_variants_attribute"
                            name="accept_variants_attribute" 
                            style="position: relative;top:2px;margin-right:4px"> 
                            
                        <i></i>
                         Sản phẩm này có nhiều variants
                    </label>
                </div>
                @php
                    $variantAttributeCateloge =
                     old('attributeCateloge') ? 
                     old('attributeCateloge') : 
                    (
                        !empty($product->attributeCateloge) ? json_decode($product->attributeCateloge) : [] 
                    );
                   
                @endphp
                <div class="row label_choose_attribute {{ old('accept_variants_attribute') == 1 ? '' : 'hidden' }}" style="margin:12px 0px">
                    <div class="col-lg-3">
                        <div class="attribute_title text-success">
                            Chọn thuộc tính
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="attribute_title text-success">
                          Chọn giá trị tìm kiếm nhập từ khóa
                        </div>
                    </div>
                </div>
                <div class="vartiant_body ">
                    <div class="variant_list_render">
                        @if($variantAttributeCateloge)
                            @foreach($variantAttributeCateloge as $key => $OldItem)
                                <div class="variant_item" style="height: 60px;margin-bottom:12px">
                                    <div class="col-lg-3">
                                        <select name="attributeCateloge[]" class="vartiant_choose niceSelect" style="width: 100%;margin-bottom:20px">
                                            <option value="0">Chọn thuộc tính</option>
                                            @foreach ($attributeCateloge as $attribute)
                                                    <option {{ $OldItem  == $attribute->id  ? 'selected' : '' }} value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>      
                                    </div>
            
                                    <div class="col-lg-7">
                                        <select 
                                        name="attribute[{{ $OldItem }}][]" 
                                        class="selectVariants variants-{{ $OldItem }} form-control"
                                        multiple 
                                        data-catid='{{ $OldItem }}'
                                        ></select>
                                        {{-- <input type="text" name="select_data" class="form-control" disabled style="height: 42px"> --}}
                                    </div>
                                    <div class="col-lg-1">
                                    <button class="btn btn-danger remove_element_attribute" type="button" style="height:42px">
                                        <i class="fa-solid fa-dumpster"></i>
                                    </button>
                                    </div>
                                </div>    
                            @endforeach
                        @endif
                       
                    </div>
                    <div style="margin-top: 20px;padding-left:15px" class="foot_variants hidden" >
                        <button type="button" class="btn btn-outline-info button_add_attribute_variants" > 
                           Thêm biến thể
                        </button>
                    </div>
                </div>
               

             </div>
            </div>             
    </div>
</div>
<div class="ibox-content" style="margin-top:20px;height:auto">
    <div class="form-horizontal">
        <table class="table table-bordered variantsTable"  style="margin: 20px 0px;">
          <thead></thead>
          <tbody></tbody>
        </table>
        {{-- <div class="render_variants_update" style="margin: 20px -15px;border-top:1px solid #ccc;padding-top: 15px">
          
        </div> --}}

    </div>
</div>
<script>
    //xử lý bằng jquery
    let attributeCateloges = @json($attributeCateloge->map(function($item) {
         $name = $item->name;
         return [
            'name' => $name,
            'id' => $item->id
        ];
    })->values());
    let attribute = '{{ base64_encode(json_encode(old('attribute') ? old('attribute') : (!empty($product->attribute) ? json_decode($product->attribute) : [] ) )) }}';
    let variant = '{{ base64_encode(json_encode(old('variants')  ? old('variants') : (!empty($product->variant) ? json_decode($product->variant) : [] )  )) }}';
</script>