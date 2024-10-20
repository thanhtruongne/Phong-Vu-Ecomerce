<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    public function validateRequest($rules, Request $request, $attributeNames = null)
    {
        $validator = \Validator::make($request->all(), $rules);

        if ($attributeNames) {
            $validator->setAttributeNames($attributeNames);
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' =>'error']);
        }
    }

    public function rebuildTree($data,$parent_id = 0){
        if(isset($data) && count($data) > 0){
            foreach($data as $key => $children){
                if($parent_id == $children['parent_id']){
                    $sum[] = [
                       'name' => $children['name'],
                       'value' => $children['id'],
                       'children' => count($children['children']) ? self::rebuildTree($children['children'],$children['id']) : []
                   ];
                }
            }
             
            return  $sum;
        }
    }
}
