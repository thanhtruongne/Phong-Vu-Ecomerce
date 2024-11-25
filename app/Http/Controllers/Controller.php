<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Modules\Products\Entities\SkuVariants;
use Modules\Products\Entities\Products;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    protected function validateRequest($rules, Request $request, $attributeNames = null)
    {
        $validator = \Validator::make($request->all(), $rules);
        if ($attributeNames) {
            $validator->setAttributeNames($attributeNames);
        }
         
        if ($validator->fails()) {
            json_result(['message' => $validator->errors()->all()[0],'status' => 'error']);
        }
    }

    protected function rebuildTree($data,$parent_id = 0){
        if(isset($data) && count($data) > 0){
            foreach($data as $key => $children){
                $sum[] = [
                    'name' => $children['name'],
                    'value' => $children['id'],
                    'children' => count($children['children']) > 0 ? self::rebuildTree($children['children'],$children['id']) : []
                ];
            }
             
            return  $sum;
        }
    }

    protected function getWidgetData($widgets) {
        $data = [];
        foreach($widgets as $index => $widget) {
            if($widget->model_id && $widget->keyword) {
                $item = [];
                foreach($widget->model_id as $index => $value) {
                    $instance = self::handleMadeClass('Products',$value && $value['type'] == 'variant' ? 'SkuVariants' : 'Products','Modules');
                    $slug = $value && $value['type'] == 'variant' ? "sku_variants" : "product";
                    $model = $instance::query();
                    $model->from($slug.' as a');
                    $model->select(self::selectQueryDynamic($value['type']));
                    if($instance && $value['type'] == 'product') {
                        $model->join('brand as b','b.id','=','a.brand_id');
                    } else {
                        $model->join('product as c','c.id','=','a.product_id');
                        $model->join('brand as b','b.id','=','c.brand_id');
                    }
                    $model->where('a.sku_code',$value['sku']);
                    $model->with(self::getRelationMade($value['type']));
                    $row =  $model->first();
                    if($row)
                        $item[] = $row;
                }
                $widget->data = $item;
            }
        }
        return $widgets;
    }

    private function selectQueryDynamic(string $type): array{
      if($type && $type == 'variant') {
        return ['a.id','a.name','a.sku_code','a.slug','a.price','a.album','a.product_id',\DB::raw('UPPER(b.name) as brand_name')];
      } elseif($type && $type == 'product'){
        return ['a.id','a.name','a.product_category_id','a.image','a.price',\DB::raw('UPPER(b.name) as brand_name'),'a.quantity'];
      }
      else return [];
    }

    private function getRelationMade(string $type): array {
        if($type && $type == 'variant') {
            return ['promotion','product'];
        } elseif($type && $type == 'product'){
            return ['promotion','product_category'];
        }
        else return [];
    }


    private function handleMadeClass(string $app = '',string $model = '',string $type = 'App') {
        $namespace = '';
        if($type && $type != 'App' && $type == 'Modules') {
            $nameSpace = "\Modules\\".$app.'\\'.'Entities'.'\\'.ucfirst($model);
        }else {
            $nameSpace = "\App\\".$app.'\\'.ucfirst($model);
        }
        if(class_exists($nameSpace)) {
           $instance = app($nameSpace);
        }
        return $instance;
    }


}
