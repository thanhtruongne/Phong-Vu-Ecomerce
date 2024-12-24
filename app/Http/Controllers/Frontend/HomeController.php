<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Brand;
use Modules\Products\Entities\Products;
use Modules\Widget\Entities\Widget;



interface HomeDataControl{
  public function home(Request $request);

  public function productCategory(string $slug = '',Request $request);

  public function detailProduct(string $url = '',string $slug = '',Request $request);
}

class HomeController extends Controller implements HomeDataControl
{

  public function home(Request $request){
    $widgets = Widget::whereNotNull('name')->where('status',1)->get();
    $data_widget = $this->getWidgetData($widgets);
    $slider = \Cache::tags(['slider','brand'])->remember('sliders',\Carbon::now()->addDays(2),function(){
      return Slider::whereKeyword('slider-home')->first();
    });
    $brands = \Cache::tags(['slider','brands'])->remember('brands',\Carbon::now()->addDays(2),function(){
      return Brand::whereNotNull('image')->with('products')->get();
    });
    // $brands = Brand::whereNotNull('image')->with('products')->get();
    $productCategory = ProductCategory::whereNull('parent_id')->get();
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
    $arr_child = $productCategory->descendants->pluck('id')->toArray();
    //filter
    $products = $this->getProductByCategory($request,$arr_child,[]);
    $filters = $this->getFilterProductCategory($products);
    return view('Frontend.page.products.productCategory',
    [
            'productCategory' => $productCategory ,
            // 'products' => $products ,
            'childCatehgory' => $childCatehgory,
            'filters' => $filters,
          ]);

  }

  public function detailProduct(string $url = '' ,string $sku = '',Request $request) {
    $product = $this->getProductDetailByRequest($url,$sku);
    if(!$product) {
       abort(404);
    }
    $category_bread = ProductCategory::ancestorsAndSelf($product->product_category_id,['id','name','url']);
    $related_id =  $category_bread->pluck('id')->toArray();
    $childCategory =  $category_bread->pluck('name','url')->toArray();
    $productRelated = $this->getProductByCategory($request,$related_id,[],null);
    return view('Frontend.page.products.product.detail',
      [
        'product' => $product ,
        'childCategory' => $childCategory,
        'productRelated' => $productRelated
      ]
    );


  }





}
