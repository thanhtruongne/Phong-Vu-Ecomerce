<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\ProductCateloge;
use Modules\Products\Entities\Products;

class ProductsController extends Controller
{
    public function index(){
        $data = ProductCateloge::whereNotNull('name')->get()->toTree()->toArray();
        $productCateloge = $this->rebuildTree($data);

        $dataAttribute = Attribute::whereNotNull('name')->get()->toTree()->toArray();
        $attribute = $this->rebuildTree($dataAttribute);


        return view('products::products.index',['attributes' => $attribute , 'productCateloge' => $productCateloge]);
    }
    
    public function getData(Request $request){
        $search = $request->search;
        $offset = $request->input('offset',0);
        $limit = $request->input('limit',20);
        $sort = $request->input('sort','id');
        $order = $request->input('order','DESC');
        $category_product_main = $request->category_product_main;
        $query = Products::query();
        $query->from('product as a');
        $query->select(['a.*']);
        $query->leftJoin('product_variant as b','b.product_id','=','a.id');   
        // $query->whereExists(function($subquery) {
        //   return  $subquery->leftJoin('product_variant as b','b.product_id','=','a.id');   
        // });
        if($search){
            $query->where('a.name','like','&'.$search.'%');
            $query->orWhere('b.name as product_variant_name','like','&'.$search.'%');
        }
        $query->orderBy($sort,$order);
        $query->offset($offset);
        $query->limit($limit);
        $query->disableCache();
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row) {
            $attribute = array_keys(get_object_vars(json_decode($row->attributeFilter)));
            $nameAttribute = Attribute::whereIn('id',$attribute)->pluck('name')->toArray();
            $row->edit_url = route('private-system.product-cateloge.edit',['id'=> $row->id]);
            $row->price = numberFormat($row->price);
            $row->category_name = ProductCateloge::whereId($row->product_cateloge_id)->value('name');
            $row->attribute_name = implode(' - ',$nameAttribute);
            // $row->created_at =  date("M d, Y",strtotime($row->created_at));
        }



        return response()->json(['rows' => $rows , 'total' => $count]);
    }


    public function form(Request $request){
        $data = ProductCateloge::whereNotNull('name')->get()->toTree()->toArray();
        $categories = $this->rebuildTree($data);
        if($request->id){
           
        }
        return view('products::products.form',['categories' => $categories]);
    }



    public function save(Request $request){
         $this->validateRequest([
            'name' => 'required|string',
            'cost' => 'required',
            'desc' => 'required',
            'content' => 'required',
            'album' => 'required_if:is_single,on',
            'category_id' => 'required'
         ],$request,[
            'name.required' => 'Tên sản phẩm không được trống',
            'name.string' => 'Tên sản phẩm không hợp lệ',
            'cost.required' => 'Giá sản phẩm không được trống',
            'desc.required' => 'Mô tả sản phẩm không được trống',
            'content.required' => 'Nội dung sản phẩm không được trống',
            'album.required_if'=> 'Ảnh sản phẩm không được trống',
            'category_id.required' => 'Danh mục sản phẩm không được trống'
         ]);
         
         // tạo variant
         if($request->is_single){
               
         }
         else {
             $model = Products::firstOrNew(['id' => $request->id]);
             $model->fill($request->all());
             $model->product_cateloge_id = $request->category_id;
             $model->code = $request->sku;
             $attribute = Attribute::whereIn('id',$request->attribute)->get(['id','name','parent_id']);
             $model->name = $request->name.' ('.implode('/',$attribute->pluck('name')->toArray()) .')';
             // lưu các giá trị attribute khi filter
             $model->attributeFilter = json_encode($attribute->pluck('id','parent_id')->toArray());
             $model->price = (int)str_replace('.','',$request->cost);
             $model->galley = json_encode($request->album);    
             $model->save();

        }
        json_result(['message' => 'Lưu thành công','status' => true,'redirect' => route('private-system.product')]);
    }




}
