<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositories;
use App\Repositories\SliderRepositories;
use App\Repositories\SystemRepositories;
use App\Services\WidgetService;
use Illuminate\Http\Request;

class HomeController extends BaseController
{  
     protected $sliderRepositories,$widgetService,$productRepositories;
    // protected $language;
   public function __construct(
     // LanguageRepositories $languageRepositories,
     SliderRepositories $sliderRepositories,
     WidgetService $widgetService,
     ProductRepositories $productRepositories
    )
   {
     $this->sliderRepositories = $sliderRepositories;
     $this->widgetService = $widgetService;
     $this->productRepositories = $productRepositories;
     parent::__construct();
   }


   public function home(){
     //hạn chế dùng phương thức này vì khi gọi api ,goi dư các dữ liệu render
     $config = [ 
          'js' => [
              'frontend/js/library/custom.js'
          ]
     ];
     $widget = $this->widgetService->foundTheWidgetByKeyword([
          //product website
          ['keyword' => 'Brand_widget'],
          ['keyword' => 'category_outStanding','data-object' => true],
          ['keyword' => 'macbook_widget','promotion_variant' => true],
          ['keyword' => 'MSI_widget','data-object' => true,'promotion_variant' => true],
          ['keyword' => 'Link_kien_widget','data-object' => true,'promotion_variant' => true],
          //brand website
     ]);
  
     $Seo = $this->Seo;
     // Lấy ra các slider
    $slider = $this->sliderRepositories->findCondition(...$this->argumentSlider());
    //Sản phẩm nổ bật
    $productOutStanding = $this->productRepositories->getoutStandingProduct(12);
    return view('Frontend.page.home',compact('slider','Seo','widget','config'));
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
