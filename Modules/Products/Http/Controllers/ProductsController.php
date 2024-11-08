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

    private $type_params = [];

    // public function __contructor(){
    //     $this->type_params = ['laptop','phone','electric','accessory'];
    // }
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
        $query = Products::query();
        $query->from('product as a');
        $query->select(['a.*','d.name as category_name']);
        $query->leftJoin('product_attribute_relation as b','b.product_id','=','a.id');
        $query->leftJoin('attributes as c','c.id','=','b.attribute_id');
        $query->leftJoin('product_category as d','d.id','=','a.product_category_id');
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
            $row->edit_url = route('private-system.product.edit',['id' => $row->id,'type' => $this->getNameType($row->type) ]);
            if($row->is_single){
                $row->price =null;      
                $row->quantity =null;      
            }
            else 
                $row->price = numberFormat($row->price);      
               
            $row->attribute_name = $this->renderAttribute($row);
            $row->variant_name = $this->renderHTML($row);
      
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
        $dataId = ProductCategory::where('ikey',$type)->value('id');
        $categories = ProductCategory::descendantsOf($dataId)->toTree($dataId)->toArray();
        $data = $this->rebuildTree($categories);
        $model = Products::firstOrNew(['id' => $id]);
        // if($model){
        //     $model->price = numberFormat($model->price);
        //     if($model->product_variant){
        //         foreach($model->product_variant as $item){
        //             $attributes = json_decode($item->attribute);
        //             $data = [];
        //             foreach($attributes as $attribute){
        //                 $val = Attribute::where('id',$attribute)->first();
        //                 $data[] = [
        //                     'parent_name' => $val->ancestors->first()->name,
        //                     'id' => $val->id,
        //                     'name' => $val->name,
        //                     'parent_id' => $val->parent_id
        //                 ];
        //             }
        //             $item->attribute = $data;
        //             $item->album = json_decode($item->album);
        //         }
        //     }
        // }
        //  //get attribute
        $parent_attribute = Attribute::where('ikey',$type)->first();
        $attributes = $parent_attribute->children->select(['name','id','parent_id']);
        // return view('products::products.form',['categories' => $data ,'category_main' => $dataMain, 'model' => $model , 'attributes' => $attributes]);
        return view('products::products.form',['model' => $model , 'categories' => $data , 'attributes' => $attributes]);
    }



    public function save(Request $request){
        if($request->is_single && $request->is_single == 'on'){
            $this->validateRequest([
                'category_id' => 'required',
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
            $attributes_ids = $request->attribute_id;
            $attributes = [];
            $sku_idx = [];
            ksort($attributes_ids);
            $sku_idx = json_decode($request->attribute_varian_idx);
            foreach($attributes_ids as $key =>  $attribute_item){
                // compare các giá trị gán chúng vào index của item
                $attribute_cateloge = Attribute::where('id',$key)->first(['name','id']);
                $variants_attribute = [];
                foreach($attribute_item as $index => $val){
                    //gán data vào variantts
                    $variants_attribute[$index] = Attribute::where('id',$val)->value('name');
                }
                $attributes[] = [
                    'id' => $attribute_cateloge->id,
                    'name' => $attribute_cateloge->name,
                    'options' => $variants_attribute
                ];
            }
            $model->variants = $attributes;
            if($model->save()){
                $model->sku_variants()->delete();
                foreach($sku_idx as $key => $sku){
                    $variant = new SkuVariants();
                    $variant->product_id = $model->id;
                    $variant->sku_idx = $sku;
                    $variant->sku_code = $request->variants['sku'][$key];
                    $variant->name = $request->name .'('.str_replace(',','/',$request->productVariants['name'][$key]).')';
                    $variant->slug =\Str::slug($variant->name);
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
            //  $attribute = Attribute::whereIn('id',$request->attribute)->get(['id','name','parent_id']);
             $attribute_name_convert = Attribute::whereIn('id',array_unique($request->attribute))->get()->pluck('name')->toArray();
             
             if($request->id){
                $name = str_contains($model->name,'(') ?  explode('(',$model->name) : null;
                if($name)
                    $model->name = $name[0] . ' ('.implode('/',$attribute_name_convert) .')';
                else 
                    $model->name = $request->name.' ('.implode('/',$attribute_name_convert) .')';
             }
             else $model->name = $request->name.' ('.implode('/',$attribute_name_convert) .')';
             $model->sku_code = $request->sku;  
             $model->price = (int)str_replace([',','.'],'',$request->cost);
             $model->album = json_encode($request->album);    
             if($model->save()){
                $model->attributes()->sync((array_unique($request->attribute ?: [])));
             }
        }
        json_result(['message' => 'Lưu thành công','status' => 'success','redirect' => route('private-system.product')]);
    }



    public function remove(Request $request){
        if($request->type && $request->type == 'all'){
            $ids = $request->input('ids', null);
            foreach ($ids as $id){
               $model = Products::find($id);
               if(!$model->sku_variants->isEmpty()){
                    json_result(['message' => 'Sản phẩm còn tồn tại các variant con','status' => 'error']);
               }
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
        $data = $row->sku_variants ?? [];
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
      if($row->variants){
        foreach($row->variants as $variant){
            $html .= $variant['name'].': '.implode(', ',$variant['options']).' ; <br>';
          }
      }
    
      return $html;
    }
}

