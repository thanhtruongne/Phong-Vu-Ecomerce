<?php
namespace App\Repositories;

use App\Models\ProductVariantTranslate;
use App\Repositories\Interfaces\ProductVariantTranslateRepositoriesInterfaces;

 class ProductVariantTranslateRepositories extends BaseRepositories implements ProductVariantTranslateRepositoriesInterfaces  {
    
    public function __construct(ProductVariantTranslate $model)
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
 }