<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class MenuController extends Controller
{
  protected  $language;

  public function __construct(LanguageRepositories $languageRepositories) {
 
    $this->language = $languageRepositories;
  }

  public function getMenu(Request $request) {
        $model = $request->input('model');
        $page = ($request->input('page')) ? $request->input('page') : 1;
        $keyword = $request->input('keyword') ?? null;
        $repositoriesName = 'App\Repositories\\'.ucfirst($model).'Repositories';
        if(class_exists($repositoriesName)) {
            $instanceRepositories = app($repositoriesName);
        }
        $payload = $this->conditionMenu(Str::snake($model) , $page , $keyword);
        $data = $instanceRepositories->paganation(...array_values($payload));
        return response()->json(['response' => $data]);
        }
        
  private function conditionMenu(string $model = '' , $page ,  $keyword):array {
    $join =  [
        [''.$model.'_translate as pct','pct.'.$model.'_id','=',''.$model.'.id'],
    ];
    if(strpos($model,'_cateloge') == false) {
        $join[] =  [''.$model.'_cateloge_'.$model.' as pcsp','pcsp.'.$model.'_id','=',''.$model.'.id'];
    }
     return [
        'select' => ['meta_link','name','id'],
        'condition' => [
            'record' => $page,
            ['status','','=', 1],
            ['language_id','=',$this->language->getCurrentLanguage()->id ?? 1],
            'where' => [
              ['name','LIKE','%'.$keyword.'%']
            ]
            
        ],
        'join' => $join ,
        'page' => 3,
        'groupBy' => [],
        'extend' => [],
        'order' => ['id' => 'desc'],
        'whereRaw' => []
    ];

  }


}
