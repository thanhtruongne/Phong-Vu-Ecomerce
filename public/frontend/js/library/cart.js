(function($) {
    "use strict";
    var Data = {};

   Data.removeRowIDCart = () => {
      $(document).on('click','.delete_cart_row',function(e) {
        let _this = $(this);
        let rowID = _this.attr('data-id');
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
            window.location.href = `${Server_Frontend}/removeCart/${rowID}`;
         }
       });
      })
   }

   Data.ClearAllCart = () => {
      $(document).on('click','.clear_cart',function(e) {
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
               window.location.href = `${Server_Frontend}/emptyCart`;
            }
          });
      })
   }

   Data.ChangeQuantityCart = () => {
      $(document).on('click','.click_change_quantity',function(e){
        
         let _this = $(this);
         let parent = _this.parents('div.css-1qgaj65');
         let inputQuantity = Number($(parent).find('input').val());
         if(_this.hasClass('plus')) inputQuantity++;
         else if(inputQuantity > 1) inputQuantity--;
   
         $(parent).find('input').val(inputQuantity);
         let rowId = $(parent).attr('data-id');
       
         let timeout = setTimeout(() => {
            
            Data.AjaxChangeQuantity(inputQuantity,rowId,_this);
            clearTimeout(timeout);
         },300);
      })
   }

   Data.AjaxChangeQuantity = (quantity,rowId,_this) => {
       $.ajax({
         type : "GET",
         url : `${Server_Frontend}/ajax/dashboard/updateQuantityCart`,
         data : {
            'quantity' : quantity,
            'rowId' : rowId
         },
         success : function(data) {
            if(data) {
               console.log(data);
             let parent = _this.parents('.teko_self_row');
             $(parent).find('.css-rmdhxt.price_all').html(data?.price + 'đ');
             $('#price_yet_cart').html(Data.number_format(data?.total) + 'đ');
             $('#price_total_cart').html(Data.number_format(data?.total) + 'đ');
            }
         },
         error : function(error) {
            console.log(error);
         }
       })
   }

   Data.number_format = (number, decimals = 0, dec_point = '.', thousands_sep = '.') => {
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
   


   $(document).ready(function() {
      Data.removeRowIDCart();
      Data.ChangeQuantityCart();
      Data.ClearAllCart();
   })

})(jQuery);