<?php

namespace Modules\Widget\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\Products;
use Modules\Widget\Entities\Widget;
use App\Enums\Enum\StatusReponse;
class WidgetController extends Controller
{
   
    public function index()
    {
        return view('widget::index');
    }

    public function getData(Request $request) {
        $search = $request->input('search');
        $offset = $request->input('offset',0);
        $limit = $request->input('limit',20);
        $sort = $request->input('sort','id');
        $order = $request->input('order','DESC');

        $query = Widget::query();
        if($search){
            $query->where('name','like',$search.'%');
            $query->orWhere('keyword','like',$search.'%');

        }
        $query->offset($offset);
        $query->limit($limit);
        $query->orderBy($sort,$order);
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row) {
            $row->edit_url = route('private-system.widget.edit',['id' => $row->id]);
        }
        return response()->json(['rows' => $rows , 'total' => $count]);
    }

    public function save(Request $request) {
       $this->validateRequest([
        'name' => 'required',
        'model_id' => 'required',
        'keyword' => 'required',
        'short_code' => 'required',
        'image' => 'required',
       ],$request,Widget::getAttributeName());

       $model = Widget::firstOrNew(['id' => $request->id]);
       $model->name = $request->name;
       $model->keyword = $request->keyword;
       $model->short_code = $request->short_code;
       $model->image = $request->image;
       $model->content = $request->content;
       $item = [];
       $model_id = $request->model_id;
       foreach($model_id['product_id'] as $index => $value) {
          $item[] = [
            'product_id' => $value,
            'variant_id' =>  $model_id['variant_id'][$index],
            'sku' =>  $model_id['code'][$index],
            'type' => $value != "null" ? 'product' : 'variant',
            'image' => $model_id['image'][$index],
            'name' => $model_id['name'][$index],
          ];
       }
      $model->model_id = $item;
      if($model->save()){
        return response()->json(['status' => StatusReponse::SUCCESS,'message' => trans('admin.message_success'),'redirect' => route('private-system.widget')]);
      }
      return response()->json(['status' => StatusReponse::ERROR,'message' => trans('admin.message_error')]);
    }
    

    public function remove(Request $request){

    }

    public function form(Request $request, $id = null) {
        $model = Widget::firstOrNew(['id' => $id]);
        return view('widget::form',['model' => $model]);
    }

    public function changeStatus(Request $request) {

    }

    public function getDataProduct(Request $request) {
        $keyword = $request->input('keyword');
        $query = Products::query();
        $query->select(['a.id as product_id','a.sku_code as product_sku','a.name as product_name','c.album as variant_album','c.name as variant_name','c.price as variant_price','c.sku_code as variant_sku','c.stock as variant_stock','c.id as variant_id','a.image','a.price','a.quantity','b.name as category_name']);
        $query->from('product as a');
        $query->leftJoin('product_category as b','b.id','=','a.product_category_id');
        $query->leftJoin('sku_variants as c','c.product_id','=','a.id');
 
        if($keyword){
             $query->where('a.name','like',$keyword.'%');
             $query->orWhere('a.sku_code','like',$keyword.'%');
             $query->orWhere('c.name','like',$keyword.'%');
             $query->orWhere('c.sku_code','like',$keyword.'%');
        }
        $query->where('a.status',1);
        $count = $query->count();
        $rows =  $query->get();
        foreach($rows as $row) {
            if($row->variant_id) {
                $row->variant_album = explode(',',json_decode($row->variant_album))[0];
            }
        }
        return response()->json(['rows' => $rows , 'count' => $count]);
    }

    
}
