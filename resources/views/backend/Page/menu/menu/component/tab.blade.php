
    <div class="panel-body">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Nhấn vào tạo liên kết Menu</a>
                    </h5>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <h4>Tạo menu</h4>
                        <ul style="list-style-type:decimal">
                            <li>Cài đặt các menu hiển thị</li>
                      
                        </ul>
                        <button type="button" class="btn btn-secondary add_item_content_menu">Thêm menu <i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </div>
            @foreach(__('model')['model'] as $key =>  $item) 
             <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" class="choose_menu_item" data-model="{{ $item['model'] }}" data-parent="#accordion" href="#{{ $item['model'] }}">
                            {{ $item['name'] }}
                        </a>
                    </h4>
                </div>
                <div id="{{ $item['model'] }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div>
                             <input type="text" class="form-control on_keyup_item_attribute" placeholder="Gõ để tìm kiếm">
                        </div>
                        <div class="model_checkbox_data" style="margin: 12px 0 ">
                            {{-- Render checkbox --}}     
                        </div>
                        <div class="tab_menu_paginate" style="margin-top:12px">
                                {{-- Render paginate --}}
                        </div>
                        
                    </div>
                </div>
             </div> 
                
            @endforeach
          

        </div>
    </div>