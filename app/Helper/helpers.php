<?php 
use Illuminate\Support\Str;
if(!function_exists('setActive')) {
    function setActive($route,array $data = []) { 
        if(count($data) == 4) {
            $temp = $data[2].'.'.$data[3];
            if(strcmp($route , $temp) == 0) return 'active';
        }
        else if(count($data) == 3) {
          
            if(in_array($route , $data)) return 'active';
        }
        return '';   
    }
    
}
if(!function_exists('shipping_Rule')) {
    function shipping_Rule(int $id) { 
        $html = [];
        foreach(config('apps.payment.shipping_rule') as $item) {
            if($item['id'] == $id) {
                $html = [
                    'title' => $item['title'],
                    'price' => $item['price']
                ];
                return $html;
            }
        }
    }
    
}
if(!function_exists('confirm_order_status')) {
    function confirm_order_status(string $val = '') { 
       $html = '';
       switch($val) {
            case 'unconfirmed' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">
                    Chưa xác nhận
                    <i  class="ms-2 fa-solid fa-xmark"></i>
                </span>';
                break;
            case 'confirmed' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-primary">Đã xác nhận
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 'paid' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">Đã thanh toán
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 'unpaid' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-danger">
                Chưa thanh toán
                <i  class="ms-2 fa-solid fa-credit-card"></i>
                </span>';
                break;   
            case 'pending' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-secondary">
                Chưa giao hàng <i  class="ms-2 fa-solid fa-arrow-up-from-bracket"></i>
                </span>';
                break;
            case 'process' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">Đang giao hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break;    
            case 'success' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                Giao hàng thành công
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;               
                
       };
       return $html;
    }
    
}
if(!function_exists('confirm_order_status_admin')) {
    function confirm_order_status_admin(string $val = '') { 
       $html = '';
       switch($val) {
            case 'unconfirmed' : 
                $html ='<span style="padding: 8px 9px;" class="label label-warning">
                    Chưa xác nhận
                    <i  class="ms-2 fa-solid fa-xmark"></i>
                </span>';
                break;
            case 'confirmed' : 
                $html ='<span style="padding: 8px 9px;" class="label label-primary">Đã xác nhận
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 'paid' : 
                $html ='<span style="padding: 8px 9px;" class="label label-success">Đã thanh toán
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 'unpaid' : 
                $html ='<span style="padding: 8px 9px;" class="label label-danger">
                Chưa thanh toán
                <i  class="ms-2 fa-solid fa-credit-card"></i>
                </span>';
                break;   
            case 'pending' : 
                $html ='<span style="padding: 8px 9px;" class="label label-secondary">
                Chưa giao hàng <i  class="ms-2 fa-solid fa-arrow-up-from-bracket"></i>
                </span>';
                break;
            case 'process' : 
                $html ='<span style="padding: 8px 9px;" class="label label-warning">Đang giao hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break;    
            case 'success' : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                Giao hàng thành công
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;               
                
       };
       return $html;
    }
    
}
if(!function_exists('payment_status')) {
    function payment_status(string $val = '') { 
       $html = '';
       switch($val) {
            case 'vnpay' : 
                $html ='<span style="background-color:#000000bf;padding:6px 10px;border-radius:8px" class="text-white fw-bold">Thanh toán qua VnPay 
                <img style="object-fit:contain" width="50" height="50" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900651/vnpay-logo-CCF12E3F02-seeklogo.com_iqf7ks.png"/></span>';
                break;
            case 'momo' : 
                $html ='<span style="background-color:#a50064;padding:6px 10px;border-radius:8px" class="text-white fw-bold">Thanh toán qua Momo 
                <img style="object-fit:contain" width="50" height="50" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900882/momo_icon_square_pinkbg_RGB_jauyz1.png"/></span>';
                break;
            case 'zalo' : 
                $html ='<span>Thanh toán qua ZaloPay 
                <img style="object-fit:contain" width="50" height="50" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900961/ZaloPay-vuong_zxeof9.png"/></span>';
                break;
            case 'cod' : 
                $html ='<span>Thanh toán khi nhận hàng';
                break;    
       };
       return $html;
    }
    
}
if(!function_exists('payment_svg')) {
    function payment_svg(string $val = '') { 
       $html = '';
       switch($val) {
            case 'vnpay' :  
               $html = '<img style="object-fit:contain" width="50" height="50" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900651/vnpay-logo-CCF12E3F02-seeklogo.com_iqf7ks.png"/>';
                break;
            case 'momo' : 
              $html = '<img style="object-fit:contain" width="50" height="50" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900882/momo_icon_square_pinkbg_RGB_jauyz1.png"/>';
                break;
            case 'zalo' : 
              $html =  '<img style="object-fit:contain" width="50" height="50" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900961/ZaloPay-vuong_zxeof9.png"/>';
                break; 
       };
       return $html;
    }
    
}

if(!function_exists('proccess_shipping_fe')) {
    function proccess_shipping_fe(string $val = '') { 
       $html = '';
       switch($val) {
            case 'pending' :  
               $html = 'Đang chuẩn bị hàng <i class="ms-1 fa-solid fa-box"></i>';
                break;
            case 'process' : 
                $html = 'Đang giao hàng <i class="ms-1 fa-solid fa-truck-fast"></i>';
                break;
            case 'success' : 
                $html = 'Giao hàng thành công <i class="ms-1 fa-solid fa-check"></i>';
                break; 
       };
       return $html;
    }
    
}

if(!function_exists('order_shipping_icon')) {
    function order_shipping_icon(int $val) { 
       $html = '';
       switch($val) {
            case  1:  
               $html = 'Đang chuẩn bị hàng <i class="ms-1 fa-solid fa-box"></i>';
                break;
            case 'process' : 
                $html = 'Đang giao hàng <i class="ms-1 fa-solid fa-truck-fast"></i>';
                break;
            case 'success' : 
                $html = 'Giao hàng thành công <i class="ms-1 fa-solid fa-check"></i>';
                break; 
       };
       return $html;
    }
    
}

if(!function_exists('order_shipping_status')) {
    function order_shipping_status(int $val) { 
       $html = '';
       switch($val) {
            case 1 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">
                        Chưa tiếp nhận
                    <i  class="ms-2 fa-solid fa-xmark"></i>
                </span>';
                break;
            case 2: 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-primary">Đã tiếp nhận
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 3 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">Đã lấy hàng/Đã nhập kho
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 4 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-danger">
                    Đã điều phối giao hàng/Đang giao hàng
                <i  class="ms-2 fa-solid fa-credit-card"></i>
                </span>';
                break;   
            case 5 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                        Đã giao hàng/Chưa đối soát <i  class="ms-2 fa-solid fa-arrow-up-from-bracket"></i>
                </span>';
                break;
            case 6 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">Đã đối soát
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break;    
            case 7 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                    Không lấy được hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;               
            case 8 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                       Hoãn lấy hàng <i  class="ms-2 fa-solid fa-arrow-up-from-bracket"></i>
                </span>';
                break;
            case 9 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">Không giao được hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break;    
            case 10 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                    Delay giao hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;  
            case 11 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">
                       Đã đối soát công nợ trả hàng
                    <i  class="ms-2 fa-solid fa-xmark"></i>
                </span>';
                break;
            case 12: 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-primary">Đã điều phối lấy hàng/Đang lấy hàng
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 13 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">Đơn hàng bồi hoàn
                <i  class="ms-2 fa-solid fa-check"></i>
                </span>';
                break;
            case 20 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-danger">
                   Đang trả hàng (COD cầm hàng đi trả)
                <i  class="ms-2 fa-solid fa-credit-card"></i>
                </span>';
                break;   
            case 21 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                       Đã trả hàng (COD đã trả xong hàng)<i  class="ms-2 fa-solid fa-arrow-up-from-bracket"></i>
                </span>';
                break;
            case 123 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">Shipper báo đã lấy hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break;    
            case 127 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                    Shipper (nhân viên lấy/giao hàng) báo không lấy được hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;               
            case 128 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                        Shipper báo delay lấy hàng <i  class="ms-2 fa-solid fa-arrow-up-from-bracket"></i>
                </span>';
                break;
            case 45 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-warning">Shipper báo đã giao hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break;    
            case 49 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                   Shipper báo không giao được giao hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;     
            case 410 : 
                $html ='<span style="padding: 8px 9px;" class="badge text-bg-success">
                    Shipper báo delay giao hàng
                <i  class="ms-2 fa-solid fa-truck-fast"></i>
                </span>';
                break ;             
       };
       return $html;
    }
    
}


if(!function_exists('execPostRequest')) {
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}

if(!function_exists('conbineArraySystem')) {
    function conbineArraySystem($data, string $keyword = '', string $content = '') {
        $payload = [];
        if(is_array($data)) {
            foreach($data as $key => $val) {
               $payload[$val[$keyword]] = $val[$content];
            }
        }
         if(is_object($data)) {
            foreach($data as $key => $val) {
               $payload[$val->{$keyword}] = $val->{$content} ;
            }
           
        }
        return $payload;
    }
} 

if(!function_exists('renderCombineMenu')) {
    function renderCombineMenu($payload , int $parent_id = 0) {
    //   dd($payload);
        $data = [];
        if(!is_null($payload) && !empty($payload)) {
            foreach($payload as $key => $item) {                
                if($item->parent == $parent_id) {  
                    $data[] = [
                        'item' => $item,
                        'children' => renderCombineMenu($payload,$item->id)
                    ];  
                }
            }
        }   
        return $data;   
     
    }
} 

if(!function_exists('makeTheURL')) {
    function makeTheURL(string $canonical = '' , bool $domain = true , bool $suffix = false) {
        //    check phần url có https
        if(strpos($canonical , 'https') !== false) {
            return $canonical;
        }
        $url = (($domain == true) ? config('apps.apps.url') : '').'/'.$canonical.(($suffix == true) ? config('apps.apps.suffix')  : '');
        return $url;
    }
}

if(!function_exists('convert_price')) {
    function convert_price(string $price = '' , bool $title = true) {
       return ($title == false) ? str_replace('.','',$price) : number_format($price,0,',','.');
    }
}




if(!function_exists('renderMenuDynamicFrontEndParent')) {
    function renderMenuDynamicFrontEndParent($data) {
        $parent = '';
        if(isset($data) && !is_null($data)) {
            foreach($data as $key => $item) {
                $name = $item['item']->name;
                // dd($name);
                $canonical = makeTheURL($item['item']->canonical ?? '',true,true);
                $slug = Str::slug($name);
                $parent .= '<a href="'.$canonical.'" class="css-1h3fn00 set_ui_menu" data-title="menu_'.$slug.'">';
                $parent .= '<div class="css-73wobg">';
                $parent .= '<div class="image_category">';
                $parent .= '<div style="position: relative;display: inline-block;overflow: hidden;height: 100%;width: 100%;">';
                $parent .= '<img class="h-100 w-100" src="'.$item['item']->image.'"/>';
                $parent .= '</div>';
                $parent .= '</div>';
                $parent .= '<div  class="css-13yxnyc" style="flex: 1 1 0%;">';
                $parent .= ''.$name.'';
                $parent .= '</div>';
                $parent .= '</div>';
                $parent .= '</a>';
                $parent .= '---';
            }

            
            return $parent;
        }
       
      
    }
} 


if(!function_exists('renderMenuDynamicFrontEndChild')) {
    function renderMenuDynamicFrontEndChild($data , $parent_id = 0 , int $count = 1 , $type = 'html') {
        $child = '';
        if(isset($data) && !is_null($data)) {
            if($type = 'html') {
                // dd($data);
                foreach($data as $key => $item) {
                            $name = $item['item']->name;
                            $canonical = makeTheURL($item['item']->canonical ?? '',true,true);
                            // $child .= ' <a href="'.$canonical.'" class="css-1h3fn00">';
                            // $child .= '<div class="" style="color:#434657;margin-bottom: 4px">'.$name.'</div>';
                            // $child .= ' </a>';
                            // $child .= '---';
                            $slug = Str::slug($name);
                            if($count == 1) {
                                $child .= '<a href="'.$canonical.'" class="css-1h3fn00 set_ui_menu" data-title="menu_'.$slug.'">';
                                $child .= '<div class="css-73wobg">';
                                $child .= '<div class="image_category">';
                                $child .= '<div style="position: relative;display: inline-block;overflow: hidden;height: 100%;width: 100%;">';
                                $child .= '<img class="h-100 w-100" src="'.$item['item']->image.'"/>';
                                $child .= '</div>';
                                $child .= '</div>';
                                $child .= '<div  class="css-13yxnyc" style="flex: 1 1 0%;">';
                                $child .= ''.$name.'';
                                $child .= '</div>';
                                $child .= '</div>';
                                $child .= '</a>';
                                $child .= '---';
                            }
                            else {
                                $color = count($item['children']) > 0  ? '#1435c3' : '#434657';
                                $bold = count($item['children']) > 0  ? 'fw-bold' : '';
                                $fontsize =  count($item['children']) > 0  ? 'font-size:17px;' : '';
                                $child .= ' <a href="'.$canonical.'" class="css-1h3fn00">';
                                $child .= '<div class="'.$bold.'" style="color:'.$color.';margin-bottom: 4px;'.$fontsize.'">'.$name.'</div>';
                                $child .= ' </a>';
                                $child .= '---';
                            }
                           
                        if(count($item['children'])) {    
                            $child .= '<div class="css-fej9ea menu_'.$slug.' w-100 hidden">';
                            $child .= '<div class="" style="margin-bottom:1.5rem">';
                            $child .= renderMenuDynamicFrontEndChild($item['children'],$item['item']->parent, $count + 1 , $type);
                            $child .= '</div>';
                            $child .= '</div>';
                            
                        }   
               
                }
                return $child;
            }
        }
       
      
    }
} 



if(!function_exists('renderSystemInputText')) {
    function renderSystemInputText(string $name = '' , array $combineArraySystem = []) {
           return 
            '
            <div class="col-sm-10">
                <input 
                type="text"
                value="'.old($name,!empty($combineArraySystem[$name]) ? $combineArraySystem[$name] : '').'" 
                name="config['.$name.']"
                class="form-control">
            </div>    
            ';
    }
}

if(!function_exists('renderSystemInputImages')) {
    function renderSystemInputImages(string $name = '' ,string $placeHoder = '' ,  array $combineArraySystem = []) {
           return 
            '
            <div class="col-sm-10 ckfinder_2" data-type="'.$name.'">
                <input 
                type="text"
                value="'.old($name,!empty($combineArraySystem[$name]) ? $combineArraySystem[$name] : '').'" 
                name="config['.$name.']"
                placeholder="'.$placeHoder.'"
                class="form-control upload_url">
            </div>    
            ';
    }
}
if(!function_exists('renderSystemInputTextArea')) {
    function renderSystemInputTextArea(string $name = '',array $combineArraySystem = []) {
           return 
            '
            <div class="col-sm-10">
               <textarea name="config['.$name.']" class="form-control">
                '.old($name , !empty($combineArraySystem[$name]) ? $combineArraySystem[$name] : '').'
               </textarea>
            </div>    
            ';
    }
}

if(!function_exists('renderSystemInputSelect')) {
    function renderSystemInputSelect(string $name = '' , array $data = [], array $combineArraySystem = []) {
        $html = '';
        $html .= '<div class="col-sm-10">';
        $html .= '<select class="select2 form-control" name="config['.$name.']">';
        foreach($data as $key => $val) {
            $html .= '<option '.(!empty($combineArraySystem) &&  +$combineArraySystem[$name] == $key ? 'selected': " " ).'  value="'.$key.'" name="'.$name.'">'.$val.'</option>';
        }       
        $html .=  '</select>';  
        $html .=  '</div>';     
        return $html;
    }
}
if(!function_exists('findClass')) {
     function findClass(string $app = '',string $dot = '',string $model = '') {
        $nameSpace = "\App\\".$app.'\\'.ucfirst($model).$dot;
        if(class_exists($nameSpace)) {
           $instance = app($nameSpace);
        }
        return $instance;
     }
}

if(!function_exists('renderDiscountInfomation')) {
    function renderDiscountInfomation($promotion) {
       if($promotion->promotionMethod == 'product_and_qualnity') {
          $discountValue = $promotion->info['info']['promotion'];
          $discounType = $promotion->info['info']['type'] ;
          return '<div>Chiết khấu: <span class="label label-primary">'.$discountValue.$discounType.'</span></div>';
       }
       else  return '<div> <a href="'.route('private-system.management.promotion.edit',$promotion->id).'" class="text-primary">Xem chi tiết</a> </div>'; 
       
    }
}
if(!function_exists('renderInfomationPromotion')) {
    function renderInfomationPromotion($promotion) {
       $data = '';
        switch($promotion->promotionMethod) {
            case 'order_amount_range' : 
                $data = 'Chiết khấu theo tổng giá trị đơn hàng';
                break;
            case 'product_and_qualnity' : 
                $data = 'Chiết khấu theo từng sản phẩm';
                break;   
            case 'product_and_range' : 
                $data = 'Chiết khấu theo từng số lượng sản phẩm';
                break; 
            case 'discount_by_qualnity' : 
                $data = 'Giảm giá khi mua sản phẩm';
                break;
        }
        return '<span>'.$data.'</span>';
       
    }
}

if(!function_exists('profile')) {
    function profile() {
       return session()->get('profile'); 
    }
}

if(!function_exists('json_result')) {
function json_result($result_data, $decode = false)
{
    header('Content-Type: application/json');
    if ($decode) echo htmlspecialchars_decode(json_encode($result_data));
    else echo json_encode($result_data);
    exit();
}

}
