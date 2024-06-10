<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepositories;
use App\Repositories\SliderRepositories;
use App\Services\Interfaces\WidgetServiceInterfaces as  WidgetService;
use Illuminate\Http\Request;

class HomeController extends BaseController
{  
     protected $sliderRepositories,$widgetService;
    // protected $language;
   public function __construct(
     LanguageRepositories $languageRepositories,
     SliderRepositories $sliderRepositories,
     WidgetService $widgetService
    )
   {
     $this->sliderRepositories = $sliderRepositories;
     $this->widgetService = $widgetService;
     parent::__construct($languageRepositories);
   }


   public function home(){
     //hạn chế dùng phương thức này vì khi gọi api ,goi dư các dữ liệu render
     // $widget = [
     //      //truyền phần params để nhận biết chọn về khuyến mãi hay sản phẩm
     //      'category' => $this->widgetService->findTheWidgetByService('widget-main-category',$this->language->getCurrentLanguage()->id,[
     //           'children' => true
     //           ,'data-object' => true
     //      ]),

     // ];

     $widget = $this->widgetService->foundTheWidgetByKeyword([
          //trỏ phần danh mục lấy ra các danh mục con chưa danh mục cha và các sản phẩm khi có model là product
          // ['keyword' => 'widget-main-category','children' => true ,'data-object' => true,'promotion' => true],
          // ['keyword' => 'product-outstanding'],
          ['keyword' => 'deal-apple']
     ],$this->language->getCurrentLanguage()->id);
    //   Tạo global phần system
    $slider = $this->sliderRepositories->findCondition(...$this->argumentSlider());
    return view('Frontend.page.home',compact('slider','widget'));
   }

   private function argumentSlider() {
     return [
          'condition' => [
               ['status','=',1],
               ['keyword','=','main-slide']
          ],
          'params' => [], 
          'relation' => [],
          'type' => 'first'
     ];
   }
}
