<?php
namespace App\Repositories;

use App\Models\ProductVariant;
use App\Repositories\Interfaces\ProductVariantsRepositoriesInterfaces;
use Illuminate\Http\Request;

 class ProductVariantsRepositories extends BaseRepositories implements ProductVariantsRepositoriesInterfaces  {
    
    public function __construct(ProductVariant $model)
    {
        $this->model = $model;
    }

    // public function getProductById($id , $language  = 1) {
    //     return $this->model->select([
    //                         'product.id',
    //                         'product.image',
    //                         'product.status',
    //                         'product.follow',
    //                         'product.album',
    //                         'product.product_cateloge_id',
    //                         'pct.name',
    //                         'pct.content',
    //                         'pct.desc',
    //                         'pct.meta_title',
    //                         'pct.meta_desc',
    //                         'pct.meta_keyword',
    //                         'pct.meta_link',
    //                         ])
    //                         ->join('product_translate as pct','pct.product_id','=','product.id')
    //                         ->where('pct.languages_id','=',$language)
    //                         ->with([
    //                             'product_cataloge'
    //                         ])
    //                         ->find($id);
    // }
    public function findProductVariant($attributeID,$product_Id,string $type = 'single') {
           $query =  $this->model->where([
              ['code','=',implode(', ',$attributeID)],
              ['product_id','=',$product_Id]
           ]);
           if($type == 'single') return $query->first();
           else return $query->get();
   }

   public function getVariantSkuProduct(string $sku = '',string $nameCode = '',int $id = 0) {
        return $this->model->select($this->selectVariantSku())
        ->join('product as pv','pv.id','=','product_variant.product_id')
        ->where('product_variant.sku',$sku)->where('product_variant.status',1)
        ->first();
   }
   
   private function selectVariantSku() {
      return ['product_variant.id as variant_id','pv.id as product_id','product_variant.code','sku','qualnity','product_variant.price','product_variant.album','product_variant.barcode','product_variant.name'];
   }



 }