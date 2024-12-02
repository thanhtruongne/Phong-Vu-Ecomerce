<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\Brand;
class AjaxLoaderController extends Controller
{
  public function load_ajax($func,Request $request)
  {
    if (method_exists($this, $func)) {
        $this->{$func}($request);
        exit();
    }
    return response()->json(['message' => 'Có lỗi xảy ra'],404);  


  }

  private function loadProductBrand(Request $request) {
    $search = $request->search;
    $query = Brand::query();
    if ($search) {
      $query->where('name', 'like', '%'. $search .'%');
    }


    $query->orderBy('id', 'desc');
    $paginate = $query->paginate(10);
    $data['results'] = $query->select('id', 'name AS text')->get();
    if ($paginate->nextPageUrl()) {
        $data['pagination'] = ['more' => true];
    }

    return json_result($data);
  }


  private function loadProductCategiresByCode(Request $request){
      $search = $request->search;
      $query = Categories::query();
      if ($search) {
        $query->where('name', 'like', '%'. $search .'%');
      }


      $query->orderBy('id', 'desc');
      $paginate = $query->paginate(10);
      $data['results'] = $query->select('id', 'name AS text')->get();
      if ($paginate->nextPageUrl()) {
          $data['pagination'] = ['more' => true];
      }

      return json_result($data);


  }

  private function loadAttribute(Request $request){
    $search = $request->search;
    $parent_id = $request->parent_id;
    $query = Attribute::query();
    if ($search) {
      $query->where('name', 'like', '%'. $search .'%');
    }

    if($parent_id){
      $query->where('parent_id',$parent_id);
    }

    $query->orderBy('id', 'desc');
    $query->where('status',1);
    $paginate = $query->paginate(10);
    $data['results'] = $query->select('id', 'name AS text')->get();
    if ($paginate->nextPageUrl()) {
        $data['pagination'] = ['more' => true];
    }

    return json_result($data);
  }

  private function loadAttributeByType(Request $request){
    $search = $request->search;
    $type = $request->type;
    $parent_id = Attribute::where('ikey',$type)->value('id');
    $query = Attribute::query();
    if ($search) {
      $query->where('name', 'like', '%'. $search .'%');
    }
    $query->where(function($subquery) use($parent_id){
        $subquery->where('parent_id',$parent_id);
        $subquery->where('status',1);
    });
    $query->orderBy('id', 'desc');
    $paginate = $query->paginate(10);
    $data['results'] = $query->select('id', 'name AS text')->get();
    if ($paginate->nextPageUrl()) {
        $data['pagination'] = ['more' => true];
    }

    return json_result($data);
  }



}
