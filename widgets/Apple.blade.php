@php
   $object = $data->object;
   //chỉ lấy ra 1 promotion có tính cao nhất khi hết hạn lấy promotion kế tiếp
@endphp


<div class="widget_apple_product">
    <div class="">
        <div class="css-k9y40f" style="padding: 0 3px">
        
            {{-- render --}}
            <div class="tab-content" style="margin-top: -1px;border-radius: 5px 5px 0px 0px;" id="tab-content">
              <div class="d-flex justify-content-center align-items-center text-white flex-column"  style="height: 60px;background-color:#000000">
                  <div class="">Macbook M3 giảm thêm 300K</div>
                  <div class="">tặng thêm Balo cho Macbook Air</div>
              </div>
              <div class="" id="justified-tabpanel-0" aria-labelledby="{{ $data->short_code }}">
                <div class="css-i7g3g7" style="height: 410px">
                    <span style="box-sizing: border-box;display: block;overflow: hidden;width: initial;height: initial;background: none;opacity: 1;border: 0px;margin: 0px;padding: 0px;position: absolute;inset: 0px;">
                       <img src="{{ $data->album[0] }}" 
                        style="position: absolute;inset: 0px;box-sizing: border-box;padding: 0px;border: none;margin: auto;display: block;width: 0px;height: 0px;min-width: 100%;max-width: 100%;min-height: 100%;max-height: 100%;object-fit: cover;object-position: left top;"
                       alt="">
                    </span>
                    <div style="position: relative;text-align: right;padding: 20px;">
                        <a href="" style="text-decoration: none">
                           <span style="color: #fff">Xem tất cả</span>
                           <svg fill="none" viewBox="0 0 24 24" class="css-ymxljd" color="white" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8.49976 19.0001L15.4998 12.0001L8.49976 5.00012" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </a>
                    </div>
                    <div class="teko-row css-1qrgscw">
                        <div class="css-17ajfcv teko-col-2" style="margin: auto">
                                 Time
                        </div>
                        <div class="css-17ajfcv teko-col-10" style="max-width: 82.33%;">
                            <div class="css-gfmc8l">
                              @include('Frontend.layout.container.widgets.slider',['data' => $object])
                            </div>
                        </div>
                    </div>
                 </div>
              </div>
            </div>
        </div>
        
    </div>
</div>