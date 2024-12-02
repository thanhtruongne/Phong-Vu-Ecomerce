<?php

namespace Modules\Products\Http\Controllers;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\Brand;

class BrandController extends Controller
{

    public function index(){
        $brands = Brand::whereNotNull('name')->with('products')->get();
        return view('products::brand',['brands' => $brands]);
    }


    public function getData(Request $request){
        $search = $request->input('search');;
        $sort = $request->input('sort','id');
        $order = $request->input('order','DESC');
        $offset = $request->input('offset',0);
        $limit = $request->input('limit',6);
        
        $query = Brand::query();
        if($search){
            $query->where('name','like',$search.'%');
        }
        $query->orderBy($sort,$order);
        $query->offset($offset);
        $query->limit($limit);
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row){
            $row->edit_url= route('private-system.product-brand.edit',['id' => $row->id]);
        }
        return response()->json(['rows' => $rows , 'total' =>$count]);
           
    }

    public function remove(Request $request){
        if($request->type && $request->type == 'all'){
            $ids = $request->input('ids', null);
            if(!is_array($ids) && count($ids) <= 0) {
                return response()->json(['status' =>  StatusReponse::ERROR,'message' => trans('admin.message_error')]);
            }
            foreach ($ids as $id){
                $check =  Brand::find($id);
                if($check->products()->exists()){
                    return response()->json(['status' => StatusReponse::ERROR,'message' => 'Thương hiệu có sản phẩm chứa']);
                }
                $check->delete();
            }
            return response()->json(['status' => StatusReponse::SUCCESS,'message' => 'Xóa danh mục thành công']);
        }
        return response()->json(['status' => StatusReponse::ERROR,'message' => trans('admin.message_error')]);
      
      
    }

    public function changeStatus(Request $request){
        $this->validateRequest([
            // 'ids' => 'required',
            'status' => 'required|in:0,1',
        ], $request, [
            // 'ids' => 'Trường dữ liệu chon không được trống',
            'status' => 'Trạng thái tróng !'
        ]);
        $id = $request->input('id');
        $ids = $request->input('ids', null);
        $status = $request->input('status') ?? 0;
        if(is_array($ids)) {
            foreach ($ids as $id) {
                $model = Brand::find($id);
                $model->status = $status;
                $model->save();
            }
            return response()->json(['status' => StatusReponse::SUCCESS,'message' => 'Thay đổi trạng thái thành công']);
        } elseif(isset($id) && !empty($id)) {
            $model = Brand::find($id);
            $model->status = $status;
            $model->save();
            return response()->json(['status' => StatusReponse::SUCCESS,'message' => 'Thay đổi trạng thái thành công']);
        }

        return response()->json(['status' =>  StatusReponse::ERROR,'message' => trans('admin.message_error')]);
      

    }


    public function form(Request $request){
        $model = Brand::firstOrNew(['id' => $request->id]);
        return response()->json(['status' => StatusReponse::SUCCESS,'model' => $model]);
    }

    public function save(Request $request){
        $this->validateRequest(
            [   
                'name' => 'required',
                'image' => 'required',
                'status' => 'required'
            ],$request,Brand::getAttributeName()
        );
        
        $model = Brand::firstOrCreate(['id' => $request->id]);
        $model->fill($request->all());
        $model->save();
        return response()->json(['message' => trans('admin.message_success') , 'status' => StatusReponse::SUCCESS]);
    }


 

}
