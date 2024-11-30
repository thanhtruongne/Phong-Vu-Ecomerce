<?php

namespace Modules\Promotions\Http\Controllers;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Products;
use Modules\Promotions\Entities\Promotions;

class PromotionsController extends Controller
{

    public function index()
    {
        return view('promotions::index');
    }

    public function getData(Request $request) {
        $search = $request->input('search');
        $offset = $request->input('offset',0);
        $limit = $request->input('limit',20);
        $sort = $request->input('sort','id');
        $order = $request->input('order','DESC');

        $query = Promotions::query();
        if($search){
            $query->where('name','like',$search.'%');
        }
        $query->offset($offset);
        $query->limit($limit);
        $query->orderBy($sort,$order);
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row) {
            $row->edit_url = route('private-system.promotions.edit',['id' => $row->id]);
            $row->amount = numberFormat($row->amount);  
            $row->startDate = datetime_convert($row->startDate);
            if($row->endDate){
                $row->endDate = datetime_convert($row->endDate);
            }
        }
        return response()->json(['rows' => $rows , 'total' => $count]);
    }

    public function remove(Request $request){

    }

    public function form(Request $request, $id = null) {
       $product_cateloges = ProductCategory::whereNotNull('name')->get()->toTree()->toArray();
       $data_category = $this->rebuildTree($product_cateloges);

       $model = Promotions::firstOrNew(['id' => $id]);
       if($model) {
           
            $model->amount = numberFormat($model->amount);
            $model->startDate = \Carbon::parse($model->startDate)->format('d/m/Y H:i');
            if($model->endDate) 
                $model->endDate = \Carbon::parse($model->endDate)->format('d/m/Y H:i');
              
       }
       return view('promotions::form',['categories' => $data_category, 'model' => $model]);
    }

    public function save(Request $request){
        $this->validateRequest([
            'name' => 'required',
            'code' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'startDate' => 'required',
            // 'endDate' => 'null'
        ],$request,Promotions::getAttributeName());
        if($request->promotion && $request->category_id){
            json_result(['message' => 'Sản phẩm chọn không được bỏ trống','status' => StatusReponse::ERROR]);
        }  
        if(!$request->neverEndDate &&  is_null($request->endDate)) {
            json_result(['message' => 'Thời gian kết thúc không được bỏ trống','status' => StatusReponse::ERROR]);
        }
        \DB::beginTransaction();
        try {
            $model = Promotions::firstOrNew(['id' => $request->id]);
            $model->description = $request->description;
            $model->startDate = \Carbon::createFromFormat('d/m/Y H:i',$request->startDate);
            if(!$request->neverEndDate){  
                $model->endDate = \Carbon::createFromFormat('d/m/Y H:i',$request->endDate);
            }
            else 
                $model->neverEndDate = (int)$request->neverEndDate;
            
            $model->name = $request->name;
            $model->code = $request->code;
            $model->amount = (int)str_replace([',','.'],'',$request->amount);
            $model->thumbnail = $request->image;
            if($model->save()){
                if($request->promotion){
                    $data =  json_decode($request->promotion,true);
                    foreach($data as $item){
                        if($item['type'] == 1){
                            $model->sku_variants()->detach($item['variant_id']);
                            $model->sku_variants()->attach($item['variant_id']); 
                        }
                        else {
                            $model->products()->detach($item['id']);
                            $model->products()->attach($item['id']); 
                        }                 
                    }
                }
                if($request->category_id){
                    $datas = explode(',',$request->category_id);

                    $model->product_category()->detach();
                    $model->product_category()->sync($datas);
                } 
            }
     
            \DB::commit();
            return response()->json(['message' => 'Tạo khuyến mãi thành công','status' => StatusReponse::SUCCESS,'redirect' => route('private-system.promotions.index')]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json(['message' => $th->getMessage(),'status' => StatusReponse::ERROR,'code' => 400]);

        }
      
    }




    public function getDataByPromotion(Request $request){
       $search = $request->input('search');
       $query = Products::query();
       $query->select(['a.id as product_id','a.sku_code as product_sku','a.name as product_name','c.album as variant_album','c.name as variant_name','c.price as variant_price','c.sku_code as variant_sku','c.stock as variant_stock','c.id as variant_id','a.image','a.price','a.quantity','b.name as category_name']);
       $query->from('product as a');
       $query->leftJoin('product_category as b','b.id','=','a.product_category_id');
       $query->leftJoin('sku_variants as c','c.product_id','=','a.id');
       //tránh trùng lặp product riêng
       $query->whereNotExists(function($subquery){          
            $subquery->selectRaw(1);
            $subquery->from('promotion_product_relation as d');
            $subquery->whereRaw('a.id = d.product_id');
            $subquery->groupBy('d.product_id');
            // $subquery->havingRaw('COUNT(d.product_id) > 2');
       });

    //    //tránh trùng lặp variant
        $query->whereNotExists(function($sub_query_2){
            $sub_query_2->selectRaw(1);
            $sub_query_2->from('promotion_variants_relation as e');
            $sub_query_2->whereRaw('c.id = e.sku_id');
            $sub_query_2->groupBy('e.sku_id');
            // $sub_query_2->havingRaw('COUNT(e.sku_id) > 2');
       });

       if($search){
            $query->where('a.name','like',$search.'%');
            $query->orWhere('a.sku_code','like',$search.'%');
            $query->orWhere('c.name','like',$search.'%');
            $query->orWhere('c.sku_code','like',$search.'%');
       }
       $query->where('a.status',1);
       $count = $query->count();
    //    $query->with('sku_variant');
       $rows =  $query->paginate(12);
       return response()->json(['rows' => $rows , 'count' => $count]);
    }
   
}
