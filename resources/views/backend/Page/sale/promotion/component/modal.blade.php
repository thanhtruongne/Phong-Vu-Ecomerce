<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 800px;left: -85px;">
            <div class="modal-body">
                <div style="border-bottom:1px solid #ccc ; padding:0 12px 12px 12px;margin-left: -30px;margin-right: -30px;">
                    <h3 class="row" style="padding: 0 15px" >Chọn sản phẩm</h3>       
                    <p style="font-style: italic;" class="text-info">Chọn và tìm kiếm sản phẩm theo các từ khóa : tên ,code , sku ....</p>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="submit_menu_keyword">
                            <div class="form-group" style="margin: 20px 0 0 0">
                                <div style="position: relative">
                                    <input type="text" value="" name="name" class="form-control on_keyup_promotion_product" style="padding-left: 40px">
                                    <span style="position: absolute;top: 9px;left: 16px;font-size: 18px;">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <span class="loading hidden" style="position: absolute;top: 7px;right: 11px;font-size: 21px;">
                                        <i class="fa-solid fa-spinner fa-spin-pulse"></i>
                                    </span>
                                </div>
                                <div class="data_render_product_promotion" style="overflow:auto">
                                     {{-- render product promotion --}}
                                </div>
                                <div class="paganation_render">

                                </div>
                            </div>
                
                       
                    </div>
            </div>
        </div>
        <div class="" style="width:100%;margin-top:12px;text-align:right">
            <button type="button"  data-dismiss="modal" class="btn btn-secondary">Hủy</button>
            <button type="submit" class="btn btn-primary submit_product_promotion" data-dismiss="modal">Xác nhận</button>
        </div>
    </div>
</div>