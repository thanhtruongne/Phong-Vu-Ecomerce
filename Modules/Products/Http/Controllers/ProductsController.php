<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Products;
use Modules\Products\Entities\SkuVariants;

class ProductsController extends Controller
{

    public function index(){
        $data = ProductCategory::whereNotNull('name')->get()->toTree()->toArray();
        $ProductCategory = $this->rebuildTree($data);

        $dataAttribute = Attribute::whereNotNull('name')->get()->toTree()->toArray();
        $attribute = $this->rebuildTree($dataAttribute);


        return view('products::products.index',['attributes' => $attribute , 'productCateloge' => $ProductCategory]);
    }
    
    public function getData(Request $request){
        $search = $request->search;
        $offset = $request->input('offset',0);
        $limit = $request->input('limit',20);
        $sort = $request->input('sort','id');
        $order = $request->input('order','DESC');
        $category_product_main = $request->category_product_main ? explode(',',$request->category_product_main) : $request->category_product_main;; 
        $attribute_ids = $request->attribute_ids ? explode(',',$request->attribute_ids) : $request->attribute_ids;
        $brand_id = $request->brand_id ? explode(',',$request->brand_id) : $request->brand_id;
        $query = Products::query();
        $query->from('product as a');
        $query->select(self::selectDynamic());
        $query->leftJoin('product_attribute_relation as b','b.product_id','=','a.id');
        $query->leftJoin('attributes as c','c.id','=','b.attribute_id');
        $query->join('product_category as d','d.id','=','a.product_category_id');
        $query->join('brand as e','e.id','=','a.brand_id');
        if($search){
            $query->where('a.name','like' ,$search.'%');
            // $query->orWhere('b.name as product_variant_name','like','&'.$search.'%');
        }
        if($attribute_ids){
            $query->whereIn('b.attribute_id',$attribute_ids);
        }
        if($brand_id){
            $query->whereIn('e.id',$brand_id);
        }
        if($category_product_main){
            $query->whereIn('d.id',$category_product_main);
        }
        $query->orderBy($sort,$order);
        $query->offset($offset);
        $query->limit($limit);
        $query->distinct();
        // $count = $query->count();
        $rows = $query->get();     
        foreach($rows as $row) {
            $row->edit_url = route('private-system.product.edit',['id' => $row->id,'type' => $this->getNameType($row->type) ]);
            if($row->is_single){
                $row->price =null;      
                $row->quantity =null;      
            } else 
                $row->price = numberFormat($row->price);      
            
            $row->attribute_name = $this->renderAttribute($row);
            $row->variant_name = $this->renderHTML($row);
      
        }
        // dd($rows);
        return response()->json(['rows' => $rows , 'total' => count($rows)]);
    }


    public function form(Request $request,$id = null){
        // dd($request->type,$this->type_params);
        if(!$request->type || is_numeric($request->type) || !in_array($request->type,$this->type_params())){
            abort(404);
        }
        $type = $request->type;
        //get product-cateloge
        $dataId = ProductCategory::where('ikey',$type)->value('id');
        $categories = ProductCategory::descendantsOf($dataId)->toTree($dataId)->toArray();
        $data = $this->rebuildTree($categories);
        $model = Products::firstOrNew(['id' => $id]);
        $sku_idxs = [];
        $attributes_model = [];  
        //  //get attribute
        $parent_attribute = Attribute::where('ikey',$type)->first();
        $attributes = $parent_attribute->children->select(['name','id','parent_id']); 
        if($model && !is_null($model->is_single)){
            $sku_idxs = $model->sku_variant->pluck('sku_idx')->toArray();
            // $model->sku_variant
            foreach($model->attributes as $key => $attribute){
                $attri_ids = [];    
                $attribute_parent = Attribute::where(['id' => $key , 'status' => 1])->first(['name','id']);
                $attri_ids['name'] = $attribute_parent->name;$attri_ids['id'] = $attribute_parent->id;
                foreach($attribute as $item){
                    $attri_ids['option'][] = [
                        'name' => Attribute::where(['id' => $item , 'status' => 1])->value('name'),
                        'id' => $item
                    ];
                }
               $attributes_model[] = $attri_ids;
            }
            $model->attributes = $attributes_model;
        }
        if($model && $model->id > 0 && is_null($model->is_single)){
            foreach ($model->attributes_item as $key => $val) {                        
                $attribute_data_item = Attribute::where('id',$val->parent_id)->first(['name','id']);                              
                $val->parent_name = $attribute_data_item->name;
                $val->parent_id = $attribute_data_item->id;
            }   
            if($model->price)
                $model->price = numberFormat($model->price);
        }
        return view('products::products.form',['model' => $model , 'categories' => $data , 'attributes' => $attributes , 'sku_idxs'=> $sku_idxs]);
    }



    public function save(Request $request){
        if($request->is_single && $request->is_single == 'on'){
            $this->validateRequest([
                'category_id' => 'required',
                'name' => 'required|string',
                'brand_id' => 'required',
             ],$request,Products::getAttributeName());
         }
         else {
            $this->validateRequest([
                'name' => 'required|string',
                'description' => 'required',
                'content' => 'required',
                'brand_id' => 'required',
                'album' => 'required',
                'image' => 'required',
                'attribute' => 'required',
                'category_id' => 'required',
             ],$request,Products::getAttributeName());
        }
        if($request->type && !in_array($request->type,$this->type_params())){
            json_result(['message' => 'Có lỗi xảy ra vui lòng thử lại','status' => 'error']);
        }
          
        $model = Products::firstOrNew(['id' => $request->id]);
        //  tạo variant
        if($request->is_single){
            $model->fill($request->except(['sku','quantity','attribute']));
            $model->is_single = 2;
            $model->price = null;
            $model->type = $this->getNameType($request->type);
            $model->product_category_id = $request->category_id;
            $attributes_parent_ids = $request->attribute_id;
            $variants = [];
            $sku_idx = [];
            ksort($attributes_parent_ids);
            $sku_idx = json_decode($request->attribute_varian_idx);
            foreach($attributes_parent_ids as $key =>  $attribute_item){
                // compare các giá trị gán chúng vào index của item
                $attribute_cateloge = Attribute::where('id',$key)->first(['name','id']);
                $variants_attribute = [];
                foreach($attribute_item as $index => $val){
                    //gán data vào variantts
                    $variants_attribute[$index] = Attribute::where('id',$val)->value('name');
                }
                $variants[] = [
                    'id' => $attribute_cateloge->id,
                    'name' => $attribute_cateloge->name,
                    'options' => $variants_attribute
                ];
            }
            $model->variants = $variants;
            $model->attributes = $attributes_parent_ids;
            if($model->save()){
                $model->attributes_item()->sync((array_unique(array_merge(...$attributes_parent_ids) ?: [])));
                // $model->sku_variants()->delete();
                foreach($sku_idx as $key => $sku){
                    $variant = SkuVariants::firstOrNew(['sku_code' => $request->variants['sku'][$key]]);
                    $variant->product_id = $model->id;
                    $variant->sku_idx = $sku;
                    // $variant->sku_code = $request->variants['sku'][$key];
                    $variant->name = $request->name .'('.str_replace(',','/',$request->productVariants['name'][$key]).')';
                    $variant->slug =\Str::slug($request->name);
                    $variant->price = (int)str_replace('.','',$request->variants['price'][$key]);
                    $variant->stock = $request->variants['qualnity'][$key];
                    $variant->album = $request->variants['album'][$key];
                    $variant->save();
                }
            }
         

        }
        else {    
             $model = Products::firstOrNew(['id' => $request->id]);
             $model->fill($request->except(['attribute'])); 
             
             //check data category có n6ội dung
             $checkCategoriesId = ProductCategory::find($request->category_id);
          
             if($checkCategoriesId->descendants && count($checkCategoriesId->descendants) > 0){
                json_result(['message' => 'Vui lòng chọn danh mục sản phẩm có chủ đề ','status' => 'error']);
             }
             $model->product_category_id = $request->category_id;
             $model->type = $this->getNameType($request->type);
            if($request->attribute){
                $attribute_name_convert = Attribute::whereIn('id',array_unique($request->attribute))->get()->pluck('name')->toArray();
            }
           
             
            if($request->id){
                $name = str_contains($model->name,'(') ?  explode('(',$model->name) : null;
                $model->slug = $name ? $name[0] :  \Str::slug($request->name);
                if($name)
                    $model->name = $name[0] . ' ('.implode('/',$attribute_name_convert) .')';
                else  {
                    $model->name = $request->name.' ('.implode('/',$attribute_name_convert) .')';
                }            
            } else {
                $model->name = $request->name.' ('.implode('/',$attribute_name_convert) .')';
                $model->slug = \Str::slug($request->name);
             } 
             $model->sku_code = $request->sku;   
             $model->price = (int)str_replace([',','.'],'',$request->cost);
             $model->album = json_encode($request->album);    
             if($model->save()){
                $model->attributes_item()->sync((array_unique($request->attribute ?: [])));
             }
        }
        json_result(['message' => 'Lưu thành công','status' => 'success','redirect' => route('private-system.product')]);
    }



    public function remove(Request $request){
        if($request->type && $request->type == 'all'){
            $ids = $request->input('ids', null);
            foreach ($ids as $id){
               $model = Products::find($id);
               if(!$model->sku_variant->isEmpty()){
                    json_result(['message' => 'Sản phẩm còn tồn tại các variant con','status' => 'error']);
               }
               $model->promotion->detach();
               $model->attributes_item->detach();
               $model->delete();
            }
        }
        return response()->json(['status' => 'success','message' => 'Xóa sản phẩm thành công']);
      
    }

    public function remove_variant(Request $request){
        // if($request->type && $request->type == 'all'){
            // $id = $request->input('id', null);
            // // foreach ($ids as $id){
            // $model = ProductVariant::find($id);
            // $model->delete();
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

    private function renderHTML($row){
        $html = '';
        $data = $row->sku_variant ?? [];
         if($row){
            foreach($data as $key => $item){
                $html .= 
                  '<details class="tree-nav__item" open>
                        <summary class="tree-nav__item-title ">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="node" style="min-width:98%">
                                    <a class="overide" href="#">'.$item->name.' - '.$item->sku_code.' - '.numberFormat($item->price).' VND - '.$item->stock.'</a>
                                </div>
                                <button id="row_'.$item->id.'" onClick="deleteRow('.$item->id.')" class="btn"><i class="fas fa-trash"></i></button>
                            </div>
                          
                        </summary>
                    </details> ';
            }
         }
         return $html;
        
    }

    private function renderAttribute($row){
      $html = '';
      if( !is_null($row->is_single) && $row->variants){
        foreach($row->variants as $variant){
            $html .= $variant['name'].': '.implode(', ',$variant['options']).' ; <br>';
        }
      }
      else {
        if($row->attributes_item) {
            foreach($row->attributes_item as $attribute){
                $html .= $attribute->name.'- ';
            }
        }
      
      }
    
      return $html;
    }

    private function selectDynamic(){
      return ['a.name','a.id','a.price','a.quantity','a.product_category_id','a.status','a.sku_code',
      'a.views','a.type','a.image','d.name as category_name','e.name as brand_name'];
    }

    //set tạm
    private function setPriceCurrency($variants) {
        
    }
}

