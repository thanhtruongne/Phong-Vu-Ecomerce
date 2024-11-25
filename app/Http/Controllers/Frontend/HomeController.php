<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Repositories\SliderRepositories;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;
use Modules\Widget\Entities\Widget;

class HomeController extends Controller
{  
    

   public function home()
   {

     $widgets = Widget::whereNotNull('name')->where('status',1)->get();
     $data_widget = $this->getWidgetData($widgets);
     $slider = Slider::whereKeyword('slider-home')->first();
     $productCategory = ProductCategory::whereNull('parent_id')->get();
    //  $categories
     return view('Frontend.page.home',['slider' => $slider,'productCategory' => $productCategory,'widgets' => $data_widget]);
   }





}
