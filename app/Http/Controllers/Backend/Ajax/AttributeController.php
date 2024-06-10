<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AttributeRepositoriesInterfaces as AttributeRepositories;
use App\Repositories\LanguageRepositories;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
  protected $attributeRepository , $language;

  public function __construct(AttributeRepositories  $attributeRepository , LanguageRepositories $languageRepositories) {
    $this->attributeRepository = $attributeRepository;
    $this->language = $languageRepositories;
  }

  public function getAttribute(Request $request) {
    $payload = $request->input();
    $attributes = $this->attributeRepository->searchAttribute($payload['search'],$payload['id'],$this->language->getCurrentLanguage()->id);
    $attributeMap = $attributes->map(function($attribute) {
      return [
        'id' => $attribute->id,
        'text' => $attribute->attribute_translate->first()->name
      ];
    })->all();
    return response()->json(array('items' => $attributeMap ));
  }

  public function findAttributeVariants(Request $request) {
      $payload['attribute'] = $request->input('attribute');
      $payload['attributeCatelogeId'] = $request->input('attributeCatelogeId');

      $attribute = $payload['attribute'][$payload['attributeCatelogeId']];
      if(count($attribute)) {
        $attributes = $this->attributeRepository->findAttributeByIdArray($attribute , $this->language->getCurrentLanguage()->id);
      }
      $temp = [];
      if($attributes ) {
        foreach($attributes as $Key => $val) {
          $temp[] = [
            'id' => $val->id,
            'name' => $val->name
           ];
        }      
      }
      return response()->json(array('items' =>$temp ));
  }

}
