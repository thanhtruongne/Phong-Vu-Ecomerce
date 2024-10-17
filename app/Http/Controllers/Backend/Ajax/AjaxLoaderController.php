<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Modules\Products\Entities\Attribute;

class AjaxLoaderController extends Controller
{
  public function load_ajax($func,Request $request)
  {
    if (method_exists($this, $func) && \Auth::check()) {
        $this->{$func}($request);
        exit();
    }
    return response()->json(['message' => 'Có lỗi xảy ra'],404);  


  }


  private function loadProductCategiresByCode(Request $request){
      $search = $request->search;
      $query = Categories::query();
      if ($search) {
        $query->where('name', 'like', '%'. $search .'%');
      }


      $query->orderBy('id', 'desc');
      $paginate = $query->paginate(10);
      $data['results'] = $query->select('id', 'name AS text')->get();;
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
    $data['results'] = $query->select('id', 'name AS text')->get();;
    if ($paginate->nextPageUrl()) {
        $data['pagination'] = ['more' => true];
    }

    return json_result($data);
  }



}
