
    $(document).on('click','.delete_cart_row',function(e) {
        let _this = $(this);
        let rowID = _this.attr('data-id');
        let parent = _this.parents('.row_other');
        Swal.fire({
            title : 'Chú ý',
            text: "Bạn có muốn xóa item này khỏi giỏ hàng",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa"
        }).then((result) => {
            if (result.isConfirmed) {
                let data = AjaxRemoveCart('single',rowID);
                parent.remove();
                return false;
            }
        });
    })

    function AjaxRemoveCart(type = 'single',rowID = null) {
        let url = type == 'single' ? Server_Frontend + `removeCart/${rowID}` : Server_Frontend + 'emptyCart';
        let option = type == 'single' ? null :  {row : rowID};
        $.ajax({
            type : "POST",
            url : url,
            data :option,
            success : function(data) {
                if(data?.status == 'success'){
                    if((data?.single_remove == 1 && data?.total == 0) || data?.clear_all == 1) {
                        console.log(data)
                        $('#total_render_cart').html(
                            `<div class="css-1bqbden">
                                <div class="">
                                    <div class="css-18zym6u">
                                        <div class="css-11f6yue w-100">
                                            <img 
                                            src="https://shopfront-cdn.tekoapis.com/static/empty_cart.png" 
                                            style="width: 100%;height: 100%;object-fit: inherit;position: absolute;top: 0px;left: 0px;" alt="">
                                        </div>
                                        <div class="css-1qoenic">Giỏ hàng chưa có sản phẩm nào</div>
                                        <a class="buy-now css-fhio94" href="{{ route('home') }}" style="text-decoration: none">
                                            <div type="body" class="button-text css-2h64mz" color="white">Mua sắm ngay</div>
                                        </a>
                                    </div>
                                </div>
                            </div>`)
                    } else {       
                        $('#price_yet_cart').html(number_format(data?.total) + 'đ');
                        $('#price_total_cart').html(number_format(data?.total) + 'đ');
                    }                
                } 
            },
            error : function(error) {
               console.log(error);
            }
          })
    }
   

    $(document).on('click','.clear_cart',function(e) {
        let parent = $('#total_render_cart');
        let html = `     <div class="css-1bqbden">
                    <div class="">
                        <div class="css-18zym6u">
                            <div class="css-11f6yue w-100">
                                <img 
                                src="https://shopfront-cdn.tekoapis.com/static/empty_cart.png" 
                                style="width: 100%;height: 100%;object-fit: inherit;position: absolute;top: 0px;left: 0px;" alt="">
                            </div>
                            <div class="css-1qoenic">Giỏ hàng chưa có sản phẩm nào</div>
                            <a class="buy-now css-fhio94" href="{{ route('home') }}" style="text-decoration: none">
                                <div type="body" class="button-text css-2h64mz" color="white">Mua sắm ngay</div>
                            </a>
                        </div>
                    </div>
                </div>`
        e.preventDefault();
        Swal.fire({
        title: "Chú ý",
        icon: "warning",
        text : 'Bạn có muốn xóa tất cả sản phẩm khỏi giỏ hàng',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa"
        }).then((result) => {
            if (result.isConfirmed) {
                parent.html(html)
                AjaxRemoveCart('multiple',null);
                return false;
            }
        });
    })
    const debounceUpdateQuantity = debounce(function () {
            let _this = $(this);
            let parent = _this.parents('div.css-1qgaj65');
            let inputQuantity = Number($(parent).find('input').val());
            if(inputQuantity == 1 && _this.hasClass('minus')){
                return;
            }
            if(_this.hasClass('plus')) inputQuantity++;
            else if(inputQuantity > 1) inputQuantity--;
            $(parent).find('input').val(inputQuantity);
          
            let rowId = $(parent).attr('data-id');
            AjaxChangeQuantity(inputQuantity,rowId,_this)
        
    }, 200); 

    $('.click_change_quantity').on('click',debounceUpdateQuantity)
   

  function AjaxChangeQuantity(quantity,rowId,_this) {
       $.ajax({
         type : "POST",
         url :  Server_Frontend + 'ajax/updateQuantityCart',
         data : {
            'quantity' : quantity,
            'rowId' : rowId
         },
         success : function(data) {
            if(data) {
                console.log(data);
                let parent = _this.parents('.teko_self_row');
                $(parent).find('.css-rmdhxt.price_all').html(number_format(data?.price) + ' đ');
                $('#price_yet_cart').html(number_format(data?.total) + ' đ');
                $('#price_total_cart').html(number_format(data?.total) + ' đ');
            }
         },
         error : function(error) {
            console.log(error);
         }
       })
   }

   function number_format(number, decimals = 0, dec_point = '.', thousands_sep = '.')  {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
      var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function (n, prec) {
              var k = Math.pow(10, prec);
              return '' + Math.round(n * k) / k;
          };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
 } 



 //checkout 
 
   

