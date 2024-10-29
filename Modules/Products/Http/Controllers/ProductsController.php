<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\ProductCateloge;
use Modules\Products\Entities\Products;
use Modules\Products\Entities\ProductVariant;

class ProductsController extends Controller
{

    private $type_params = [];

    // public function __contructor(){
    //     $this->type_params = ['laptop','phone','electric','accessory'];
    // }
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
        $category_product_main = $request->category_product_main ? explode(',',$request->category_product_main) : $request->category_product_main;; 
        $attribute_ids = $request->attribute_ids ? explode(',',$request->attribute_ids) : $request->attribute_ids;
        $query = Products::query();
        $query->from('product as a');
        $query->select(['a.*']);
        $query->leftJoin('product_attribute_relation as b','b.product_id','=','a.id');
        $query->leftJoin('attribute as c','c.id','=','b.attribute_id');
        $query->leftJoin('product_cateloge as d','d.id','=','a.product_cateloge_id');
        // // $query->whereExists(function($subquery) {
        //   return  $subquery->leftJoin('product_variant as b','b.product_id','=','a.id');   
        // });
        if($search){
            $query->where('a.name','like','%'.$search.'%');
            // $query->orWhere('b.name as product_variant_name','like','&'.$search.'%');
        }
        if($attribute_ids){
            $query->whereIn('b.attribute_id',$attribute_ids);
        }
        if($category_product_main){
            $query->whereIn('d.id',$category_product_main);
        }
        $query->orderBy($sort,$order);
        $query->offset($offset);
        $query->limit($limit);
        $query->distinct();
        $query->disableCache();
        $count = $query->count();
        $rows = $query->get();
        foreach($rows as $row) {
            $attribute = array_keys(get_object_vars(json_decode($row->attributeFilter)));
            $nameAttribute = Attribute::whereIn('id',$attribute)->pluck('name')->toArray();
            $row->edit_url = route('private-system.product.edit',['id' => $row->id,'type' => $this->getNameType($row->type) ]);
            $row->price = numberFormat($row->price);
            $row->category_name = ProductCateloge::whereId($row->product_cateloge_id)->value('name');
            $row->attribute_name = implode(' - ',$nameAttribute);
            $row->variant_name = $this->renderHTML($row);
            if(!$row->product_variant->isEmpty()) {
                $row->sku = implode(' - ',$row->product_variant->pluck('sku')->toArray());
                $row->price = null;
            }       
      
        }
        // dd($rows);
        return response()->json(['rows' => $rows , 'total' => $count]);
    }


    public function form(Request $request,$id = null){
        // dd($request->type,$this->type_params);
        if(!$request->type || is_numeric($request->type) || !in_array($request->type,$this->type_params())){
            abort(404);
        }
        $type = $request->type;
        //get product-cateloge
        $dataId = ProductCateloge::where('ikey',$type)->value('id');
        $categories = ProductCateloge::descendantsOf($dataId)->toTree($dataId)->toArray();
        $data = $this->rebuildTree($categories);
        $model = Products::firstOrNew(['id' => $id]);
        if($model){
            $model->price = numberFormat($model->price);
            if($model->product_variant){
                foreach($model->product_variant as $item){
                    $attributes = json_decode($item->attribute);
                    $data = [];
                    foreach($attributes as $attribute){
                        $val = Attribute::where('id',$attribute)->first();
                        $data[] = [
                            'parent_name' => $val->ancestors->first()->name,
                            'id' => $val->id,
                            'name' => $val->name,
                            'parent_id' => $val->parent_id
                        ];
                    }
                    $item->attribute = $data;
                    $item->album = json_decode($item->album);
                }
            }
        }
        $categories_main = Categories::where(function($query) use($type){
            $query->where('ikey',$type);
            // $query->where('ikey','!=','');
        })->value('id');
        //get categories
        $dataMain = $this->rebuildTree(Categories::descendantsOf($categories_main)->toTree($categories_main)->toArray());
         //get attribute
        $parent_attribute = Attribute::where('ikey',$type)->first();
        $attributes = Attribute::descendantsOf($parent_attribute->id)->toTree($parent_attribute->id);
        return view('products::products.form',['categories' => $data ,'category_main' => $dataMain, 'model' => $model , 'attributes' => $attributes]);
    }

    private function renderHTML($row){
        $html = '';
        $data = $row->product_variant;
         if($row){
            foreach($data as $key => $item){
                $html .= 
                  '<details class="tree-nav__item" open>
                        <summary class="tree-nav__item-title ">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="node" style="min-width:98%">
                                    <a class="overide" href="#">'.$item->name.' - '.$item->sku.' - '.numberFormat($item->price).' VND - '.$item->qualnity.'</a>
                                </div>
                                <button id="row_'.$item->id.'" onClick="deleteRow('.$item->id.')" class="btn"><i class="fas fa-trash"></i></button>
                            </div>
                          
                        </summary>
                    </details> ';
            }
         }
         return $html;
        
    }

    public function save(Request $request){
        if($request->is_single && $request->is_single == 'on'){
            $this->validateRequest([
                'cost' => 'required',
                'category_id' => 'required',
                'image' => 'required',
                'name' => 'required|string',
             ],$request,Products::getAttributeName());
         }
         else {
            $this->validateRequest([
                'name' => 'required|string',
                'desc' => 'required',
                'content' => 'required',
                'album' => 'required',
                'image' => 'required',
                'category_id' => 'required',
                'categories_main_id' => 'required'
             ],$request,Products::getAttributeName());
        }
        if($request->type && !in_array($request->type,$this->type_params())){
            json_result(['message' => 'Có lỗi xảy ra vui lòng thử lại','status' => 'error']);
        }

        $model = Products::firstOrNew(['id' => $request->id]);
        //  tạo variant
        if($request->is_single){
            $attribute = $request->attribute;
            $model->fill($request->except(['sku','qu`alnity','image','attribute']));
            $model->is_single = 2;
            $model->code = \Str::random(10);
            $arrAttribute = array_unique(array_merge(...$attribute ?: []));
            $model->attributeFilter = json_encode($arrAttribute);
            $model->price = 0;
            $model->image = $request->image;
            $model->qualnity = array_sum($request->qualnity);
            $model->product_cateloge_id = $request->category_id;
            if($model->save()){
                $model->attributes()->sync(($arrAttribute ?: []));
                foreach($attribute as $key => $item){
                    if($request->categories_main_variant[$key]){
                        $attribiute_variants = $request->categories_main_variant[$key] ? explode(',',$request->categories_main_variant[$key]) : [];
                        $checkArr = [];
                        foreach($attribiute_variants as $attribute_variant){
                            $check = Categories::where('id',$attribute_variant)->whereNotNull('parent_id')->first();
                            if(!$check) 
                               json_result(['message' => 'Vui lòng chọn thuộc tính filter sản phẩm có nội dung','status' => 'error']); 
                            if(in_array($check->parent_id,$checkArr))
                               json_result(['message' => 'Vui lòng chọn thuộc tính filter mỗi danh mục attribute có 1 chủ đề','status' => 'error']);
                            else
                               $checkArr[] = $check->parent_id;
                        }
                    }
                    $variant = ProductVariant::firstOrNew(['id' => $request->attribute_id[$key] ?? null]);
                    $attribute = Attribute::whereIn('id',$item)->get(['id','name','parent_id']);
                    $variant->name = $request->name.' ('.implode('/',$attribute->pluck('name')->toArray()) .')';
                    $variant->user_id = profile()->id;
                    $variant->sku = $request->sku[$key];
                    $variant->product_id = $model->id;
                    $variant->album = json_encode($request->variant_album[$key]);
                    $variant->image = (string)$request->variant_album[$key][0];
                    $variant->qualnity = $request->qualnity[$key];
                    $variant->price = (int)str_replace('.','',$request->cost[$key]);
                    $variant->attribute = json_encode($request->attribute[$key]);
                    $variant->save();
                }
            }

        }
         
        else {
                
             $model = Products::firstOrNew(['id' => $request->id]);
             $categories_main = explode(',',$request->categories_main_id) ?? [];
             $checkArr = [];
             //check categories_main để filter data
             foreach($categories_main as $item){
                $check = Categories::where('id',$item)->whereNotNull('parent_id')->first();
                if(!$check) 
                   json_result(['message' => 'Vui lòng chọn thuộc tính filter sản phẩm có nội dung','status' => 'error']); 
                if(in_array($check->parent_id,$checkArr))
                   json_result(['message' => 'Vui lòng chọn thuộc tính filter mỗi danh mục attribute có 1 chủ đề','status' => 'error']);
                else
                   $checkArr[] = $check->parent_id;
            }

             $model->fill($request->except(['attribute'])); 
             //check data category có n6ội dung
             $checkCategoriesId = ProductCateloge::find($request->category_id);
            //  dd($checkCategoriesId->descendants);
          
             if($checkCategoriesId->descendants && count($checkCategoriesId->descendants) > 0){
                json_result(['message' => 'Vui lòng chọn danh mục sản phẩm có chủ đề ','status' => 'error']);
             }
             $model->product_cateloge_id = $request->category_id;
             $model->type = $this->getNameType($request->type);
             $attribute = Attribute::whereIn('id',$request->attribute)->get(['id','name','parent_id']);
             if($request->id){
                $name = str_contains($model->name,'(') ?  explode('(',$model->name) : null;
                if($name)
                    $model->name = $name[0] . ' ('.implode('/',$attribute->pluck('name')->toArray()) .')';
                else 
                    $model->name = $request->name.' ('.implode('/',$attribute->pluck('name')->toArray()) .')';
             }
             else $model->name = $request->name.' ('.implode('/',$attribute->pluck('name')->toArray()) .')';
             // lưu các giá trị attribute khi filters
             $model->attributeFilter = json_encode($attribute->pluck('id','parent_id')->toArray());
             $model->price = (int)str_replace([',','.'],'',$request->cost);
             $model->galley = json_encode($request->album);    
             if($model->save()){
                $model->attributes()->sync((array_unique($request->attribute ?: [])));
                if(isset($categories_main) && is_array($categories_main)){
                    //lưu data categde963 filter
                   $model->categories()->sync($categories_main);
                }
             }

        }
        json_result(['message' => 'Lưu thành công','status' => 'success','redirect' => route('private-system.product')]);
    }


    public function remove(Request $request){
        if($request->type && $request->type == 'all'){
            $ids = $request->input('ids', null);
            foreach ($ids as $id){
               $model = Products::find($id);
               if(!$model->product_variant->isEmpty()){
                    json_result(['message' => 'Sản phẩm còn tồn tại các variant con','status' => 'error']);
               }
               $model->delete();
            }
        }
        return response()->json(['status' => 'success','message' => 'Xóa sản phẩm thành công']);
      
    }

    public function remove_variant(Request $request){
        // if($request->type && $request->type == 'all'){
            $id = $request->input('id', null);
            // foreach ($ids as $id){
            $model = ProductVariant::find($id);
            $model->delete();
            // }
        // }
        return response()->json(['status' => 'success','message' => 'Xóa sản phẩm variant thành công']);
      
    }

    private function getNameType($type){
        if(!is_int($type)){
            return $type == 'laptop' ? 1 : ($type == 'electric' ? 2 : ($type == 'accessory' ? 3 : 4));
        }
        else {
            return $type == 1 ? 'laptop' : ($type == 2 ? 'electric' : ($type == 3 ? 'accessory' : 'phone'));
        }
       
    }

    private function type_params(){
        return ['laptop','phone','electric','accessory'];
    }

}
