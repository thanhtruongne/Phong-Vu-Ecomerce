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
        $url = (($domain == true) ? config('apps.apps.url') : '').$canonical.(($suffix == true) ? config('apps.apps.suffix')  : '');
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
                $name = $item['item']->languages->first()->pivot->name;
                // dd($name);
                $canonical = makeTheURL($item['item']->languages->first()->pivot->canonical,true,true);
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
                            $name = $item['item']->languages->first()->pivot->name;
                            $canonical = makeTheURL($item['item']->languages->first()->pivot->canonical,true,true);
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
                                $child .= ' <a href="'.$canonical.'" class="css-1h3fn00">';
                                $child .= '<div class="" style="color:#434657;margin-bottom: 4px">'.$name.'</div>';
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
    function renderSystemInputImages(string $name = '' , $placeHoder ,  array $combineArraySystem = []) {
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