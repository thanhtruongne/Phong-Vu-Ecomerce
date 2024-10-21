<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Products\Entities\Attribute;

class AttributeController extends Controller
{


    public function index(){
        $categories = Attribute::whereNotNull('name')->get()->toTree()->toArray();
        $data = $this->rebuildTree($categories);
        // $categories = Attribute::whereNotNull('name')->get()->toTree()->toArray();
        // $data = $this->rebuildTree($categories);
        return view('products::attribute',['categories' => $data]);
    }


    public function getData(Request $request){
        $search = $request->input('search');
        $category_product_main = $request->input('category_product_main');
        $sort = $request->input('sort','id');
        $order = $request->input('order','desc');
        // $offset = $request->input('offset',0);
        // $limit = $request->input('limit',20);
        
        $query = Attribute::query();
        $query->select(['name','status','parent_id','id']);
        if($search){
            $query->where('name','like','%'.$search.'%');
        }
        if($category_product_main){
            $query->whereIn('id',explode(',',$category_product_main));
        }
        // $query->whereNull('parent_id');
        $query->orderBy($sort,$order);
        // $query->offset($offset);
        // $query->limit($limit);
        $count = $query->count();
        $rows = $query->get()->toTree();
        foreach($rows as $row){
            $row->category_child = count($row->children);
            // $row->edit_url= route('ProductCateloge.edit',['id' => $row->id]);
            $row->html = $this->renderHTML($row);
        }
        return response()->json(['rows' => $rows , 'total' =>$count]);
           
    }


    private function renderHTML($row){
        $html = '';
         if($row){
            foreach($row->children as $item){
                $hasChild =  count($item->children) > 0 ? 'is-expandable' : '';
                $html .= 
                  ' <details class="tree-nav__item '.$hasChild.'" open>
                        <summary class="tree-nav__item-title ">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="node" style="min-width:98%">
                                    <a class="overide" id="edit_'.$item->id.'" onClick="edit('.$item->id.')" href="#">'.$item->name.'</a>
                                </div>
                                <button id="row_'.$item->id.'" onClick="deleteRow('.$item->id.')" class="btn"><i class="fas fa-trash"></i></button>
                            </div>
                          
                        </summary>
                        '.$this->renderHTML($item).'
                    </details> ';
            }
         }
         return $html;
        
    }
    public function remove(Request $request){
        if($request->type && $request->type == 'all'){
            $ids = $request->input('ids', null);
            foreach ($ids as $id){
                if(!$check = Attribute::descendantsOf($id)->isEmpty()){
                    return response()->json(['status' => 'error','message' => 'Danh mục chứa hoặc tồn tại danh mục con']);
                }
                $remove = Attribute::find($id);
                $remove->delete();
            }
        }
        else {
            $id = $request->id;
            if(!$check = Attribute::descendantsOf($id)->isEmpty()){
                return response()->json(['status' => 'error','message' => 'Danh mục chứa hoặc tồn tại danh mục con']);
            }
            $remove = Attribute::find($id);
            $remove->delete();
        }
        return response()->json(['status' => 'success','message' => 'Xóa danh mục thành công']);
      
    }

    public function changeStatus(Request $request){
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required|in:0,1',
        ], $request, [
            'ids' => 'Trường dữ liệu chon không được trống',
            'status' => 'Trạng thái tróng !'
        ]);
        $id = $request->input('id');
        $ids = $request->input('ids', null);
        $status = $request->input('status') ?? 0;
        if(is_array($ids)) {
            foreach ($ids as $id) {
                $model = Attribute::find($id);
                $model->status = $status;
                $model->save();
            }
            return response()->json(['status' => 'success','message' => 'Thay đổi trạng thái thành công']);
        } elseif(isset($id) && !empty($id)) {
            $model = Attribute::find($id);
            $model->status = $status;
            $model->save();
            return response()->json(['status' => 'success','message' => 'Thay đổi trạng thái thành công']);
        }

        return response()->json(['status' => 'error','message' => 'Có1 lỗi xảy ra']);
      

    }


    public function form(Request $request){
        $categories = Attribute::whereNotNull('name')->get()->toTree()->toArray();
        $data = $this->rebuildTree($categories);
        if($request->id){
            $model = Attribute::find($request->id);
            return response()->json(['status' => 'success','model' => $model,'categories' => $data]);
            // return view('pages.categories.form',['model' => $model, 'ancestor' => $ancestor,'categories' => $data]);
        }
        return response()->json(['status' => 'error','message' => 'Có lỗi xảy ra !']);
    }


    public function save(Request $request){
        $rules = [
            'name' => 'required',
            // 'type' => 'required',
            'status' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên danh mục không được bỏ trống',
            // 'type.required' => 'Loại danh mục không được bỏ trống',
            'status.required' => 'Trạng thái bắt buộc chọn',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0] , 'status' => 'error']);
        }
        $model = Attribute::firstOrCreate(['id' => $request->id]);
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        if($request->category_parent_id){
            $parent = Attribute::find($request->category_parent_id);
            $parent->appendNode($model);
        }
        return response()->json(['message' => 'Lưu thành công' , 'status' => 'success']);
    }


 

}
