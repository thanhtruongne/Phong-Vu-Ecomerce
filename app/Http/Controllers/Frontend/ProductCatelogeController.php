<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductCateloge;
use App\Repositories\ProductCatelogeRepositories;
use App\Services\Interfaces\ProductCatelogeServiceInterfaces as ProductCatelogeService;
use App\Services\Interfaces\ProductServiceInterfaces as  ProductService;
use Illuminate\Http\Request;

class ProductCatelogeController extends BaseController
{  
    protected $productService,$productCatelogeRepositories,$productCatelogeService;
   
    // protected $language;
    public function __construct(
        ProductService $productService,
        ProductCatelogeRepositories $productCatelogeRepositories,
        ProductCatelogeService $productCatelogeService
    )
   {
     $this->productService = $productService;
     $this->productCatelogeRepositories = $productCatelogeRepositories;
     $this->productCatelogeService = $productCatelogeService;
     parent::__construct();
   }
   
   public function index($id,$request) {
      // lấy ra productCateloge
      $productCateloge = $this->productCatelogeRepositories->getProductCatelogeById($id);
    //   dd(ProductCateloge::withDepth()->with('ancestors')->find($productCateloge->id));
      $descentanofCateloge = $this->productCatelogeRepositories->getChildrenDescendantsOf($productCateloge->id);
      $filter = null;
      if(!empty($productCateloge->attributes) && count(json_decode($productCateloge->attributes,true)) > 0) {
        $filter = $this->productCatelogeService->filterList(json_decode($productCateloge->attributes,true));
      }
      $config = [
            'link' => [
                'frontend/styles/plugins/nouislider.min.css',
                'frontend/styles/plugins/metisMenu.min.css',
            ],
            'js' => [
                'frontend/js/plugins/nouislider.min.js',
                'frontend/js/library/custom.js',
                'frontend/js/plugins/metisMenu.min.js',
            ],
           'js_link' => [
              'https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js',
              'https://cdn.jsdelivr.net/npm/metismenu'
            ]
      ];
      //get Seo
      $Seo = $this->Seo;
      //tìm sản phẩm của productCateloge
      $products = $this->productService->paginate($request,$productCateloge,'variant','promotion');
      
      return view('Frontend.page.products.productCategory',compact('products','Seo','config','filter','descentanofCateloge','productCateloge'));
   }
   
}
