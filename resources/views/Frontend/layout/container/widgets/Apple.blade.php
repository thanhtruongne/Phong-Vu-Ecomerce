@php
   $flashSaleApple = $widget['deal-apple'];
   $data = $flashSaleApple->object;
   //chỉ lấy ra 1 promotion có tính cao nhất khi hết hạn lấy promotion kế tiếp
@endphp


<div class="widget_apple_product">
    <div class="container">
        <div class="css-k9y40f">
            <ul class="nav nav-tabs nav-justified css-j8f2xf" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link css-12c5axd active change" id="{{ $flashSaleApple->short_code }}" data-bs-toggle="tab" href="#justified-tabpanel-0" role="tab" aria-controls="justified-tabpanel-0" aria-selected="true"> 
                    {{ $flashSaleApple->name }}
                    <div class="mt-2">
                      {{ $flashSaleApple->short_code }}
                    </div>
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link css-12c5axd" id="justified-tab-1" data-bs-toggle="tab" href="#justified-tabpanel-1" role="tab" aria-controls="justified-tabpanel-1" aria-selected="false">
                     Much longer nav link 
                    </a>
                </li>
              </ul>
            {{-- render --}}
            <div class="tab-content" style="margin-top: -1px" id="tab-content">
              <div class="tab-pane active" id="justified-tabpanel-0" role="tabpanel" aria-labelledby="{{ $flashSaleApple->short_code }}">
                <div class="css-i7g3g7" style="height: 410px">
                    <span style="box-sizing: border-box;display: block;overflow: hidden;width: initial;height: initial;background: none;opacity: 1;border: 0px;margin: 0px;padding: 0px;position: absolute;inset: 0px;">
                       <img src="https://lh3.googleusercontent.com/wsOAFUd5nYsJSTi4Iuex4FYRLP8aCTWgMB-IdE1vvxbebq9J9qeKBRsc3UqKLn-QTZf9O-kJi1Gf8MdwS1hengv3jUcnkRGpww=rw-w1920" 
                        style="border-radius: 5px 5px 0px 0px;position: absolute;inset: 0px;box-sizing: border-box;padding: 0px;border: none;margin: auto;display: block;width: 0px;height: 0px;min-width: 100%;max-width: 100%;min-height: 100%;max-height: 100%;object-fit: cover;object-position: left top;"
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
                              @include('Frontend.layout.container.widgets.slider',['data' => $data])
                            </div>
                        </div>
                    </div>
                 </div>
              </div>
              <div class="tab-pane" id="justified-tabpanel-1" role="tabpanel" aria-labelledby="justified-tab-1">Tab 'Much longer nav link' selected</div>
              <div class="tab-pane" id="justified-tabpanel-2" role="tabpanel" aria-labelledby="justified-tab-2">Tab 3 selected</div>
            </div>
        </div>
        
    </div>
</div>