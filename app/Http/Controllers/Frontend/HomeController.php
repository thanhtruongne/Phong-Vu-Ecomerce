<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Brand;
use Modules\Products\Entities\Products;
use Modules\Widget\Entities\Widget;

interface  HomeDataControl{
  public function home(Request $request);
  
  public function productCategory(string $slug = '',Request $request);
}

class HomeController extends Controller implements HomeDataControl
{  
  
  public function home(Request $request){
    $widgets = Widget::whereNotNull('name')->where('status',1)->get();
    $data_widget = $this->getWidgetData($widgets);
    $slider = Slider::whereKeyword('slider-home')->first();
    $productCategory = ProductCategory::whereNull('parent_id')->get();
    $brands = Brand::whereNotNull('image')->with('products')->get();
    $products = $this->getProductsHome();
    return view('Frontend.page.home',['slider' => $slider,'productCategory' => $productCategory,'widgets' => $data_widget,'brands' => $brands,'products' => $products]);
  }


  public function productCategory(string $slug = '',Request $request) {
    $productCategory = ProductCategory::where('url',$slug)->first();
    if(!$productCategory) {
      abort(404);
    }
    $childCatehgory = ProductCategory::select(['id','name','icon','url','ikey'])
                      ->where('parent_id',$productCategory->id)
                      ->where('status',1)
                      ->get();

    //filter
    $products = $this->getProductByCategory($request,$productCategory,[]);
    $filters = $this->getFilterProductCategory($products);
    return view('Frontend.page.products.productCategory',
    [
            'productCategory' => $productCategory ,
            // 'products' => $products ,
            'childCatehgory' => $childCatehgory,
            'filters' => $filters,
          ]);

  }





}
