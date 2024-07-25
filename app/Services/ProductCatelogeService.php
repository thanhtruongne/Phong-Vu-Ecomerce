<?php
namespace App\Services;

use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\AttributeRepositories;
use App\Repositories\ProductCatelogeRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\ProductCatelogeServiceInterfaces;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class ProductCatelogeService extends BaseService implements ProductCatelogeServiceInterfaces
{
    protected $productCatelogeRepositories,$attributeRepositories,$attributeCatelogeRepositories;

    public function __construct(
        ProductCatelogeRepositories $productCatelogeRepositories, 
        AttributeRepositories $attributeRepositories,
        AttributeCatelogeRepositories $attributeCatelogeRepositories
        ) {
        $this->productCatelogeRepositories = $productCatelogeRepositories;
        $this->attributeRepositories = $attributeRepositories;
        $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
        parent::__construct();
        
    }
    public function paginate($request) 
    {
        $condition = [];
        $record = $request->input('record') ?: 6;
        if($request->has('status')){
            $condition['where'] = [
                ['status' ,'=', $request->status]
            ];
        }
        $productCateloge = $this->productCatelogeRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [],
        $record,[],[],[],[]
        
        );
       return $productCateloge;
    }
    

    public function create($request) {
        DB::beginTransaction();
        try {
            $productCateloge = $this->createProductCatelogeIndex($request);
            //đồng thời tạo phân quyền role cho nhóm người dùng mới
           
            if($productCateloge->id > 0) {
                // $this->createTranslateProductCatelogePivot($request,$productCateloge); 
                $this->createRouter(
                    $request->input('canonical'),
                    $productCateloge,
                    'ProductCatelogeController',
                );
            }      
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $productCateloge = $this->productCatelogeRepositories->findByid($id); 
            $check = $this->updateProductCateloge($request,$productCateloge);
            if($check == true) {
                if( $request->input('categories_id') != $productCateloge->id ) {
                    $this->productCatelogeRepositories->UpdateCategoriesByNode($id,
                    ['name' => $request->input('name'),'categories_id' => $request->input('categories_id')]);
                }
                $this->updateRouter(
                    $request->input('canonical'),
                    $productCateloge,
                    'ProductCatelogeController',
                );
            }         
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }

    public function changeStatus($request) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $request['status'] 
            ];
            $this->productCatelogeRepositories->update($request['id'], $status );  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    public function ChangeStatusAll(array $data) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $data['value']
            ];
          $this->productCatelogeRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            // return false;
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            $this->productCatelogeRepositories->deleteSoft($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    private function createProductCatelogeIndex($request) {
        $data = $request->only($this->requestOnlyProductCatelogeTranslate());
        $data['canonical'] = Str::slug($data['canonical']);
        $data['album'] = !empty($request->input('album')) ? json_encode($request->input('album')) : '' ;
        $productCateloge = $this->productCatelogeRepositories->create($data);
        //tạo nested set
        $this->productCatelogeRepositories->createCategoriesByNode($request->only($this->createCategoriesNode()),$productCateloge);
        return $productCateloge;
    }
    
 
    private function updateProductCateloge($request,$productCateloge) {
        $data = $request->only($this->requestOnlyProductCatelogeTranslate());
        $data['album'] = json_encode($request->input('album')) ?? $productCateloge->album;
        $data['canonical'] = Str::slug( $data['canonical']);
        $check = $this->productCatelogeRepositories->update($productCateloge->id,$data);
        return $check;
    }


    private function createCategoriesNode() {
        return ['categories_id'];
    }
    private function requestOnlyProductCatelogeTranslate() {
        return ['name','desc','content','meta_title','meta_desc','meta_keyword','canonical','status','image','album'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','product_cateloge.image','product_cateloge.status','product_cateloge.id'];
    }


    public function OverrideAttribute($product) {
       $attribute = $product->attribute;
       $attributeCatelogeID = +$product->product_cateloge_id;
       $productCateloge = $this->productCatelogeRepositories->findByid($attributeCatelogeID);

       if(!is_array($productCateloge->attributes)){
          $data['attributes'] = $attribute;
       }
       else {
          $array = $productCateloge->attributes;
          foreach(json_decode($attribute) as $key => $item){
            if(!isset($array[$key])){
                $array[$key] = $item;
            }
            else { 
                $array[$key] = array_values(array_unique(array_merge($array[$key],$item)));
            }
          }
           $flag = array_merge(...$array);
 
           //lấy ra các attribute id tồn tại trong product và product cateloge
          $attributePluck = $this->attributeRepositories->findAttributeProductVariantID($flag,$productCateloge->id);
   
          $data['attributes'] = array_map(function($array_list) use($attributePluck){
            return array_intersect($array_list,$attributePluck->all());
            
          },$array); 
       }
       $this->productCatelogeRepositories->update($productCateloge->id,$data);
       return $data;
    }


    public function filterList(array $attribute = []){
        $attributeCatelogeId = array_keys($attribute);
        $attributeID = array_unique(array_merge(...$attribute));
        $attributeCateloge = $this->attributeCatelogeRepositories->findCondition([
            ['status','=',1]
        ],[
            'whereIn' => 'id',
            'whereValues' => $attributeCatelogeId
        ],[],'multiple',[]);

        $attributeField = $this->attributeRepositories->findCondition([
            ['status','=',1]
        ],[
            'whereIn' => 'id',
            'whereValues' => $attributeID
        ],[],'multiple',[]);
        // dd($attributeCateloge,$attributeField);
        foreach($attributeCateloge as $key => $attributeCateloge_item){ 
            $attributeItem = [];
            foreach($attributeField as $index => $attributeField_value){
                if($attributeField_value->attribute_cateloge_id === $attributeCateloge_item->id){
                    $attributeItem[] = $attributeField_value;
                    $attributeCateloge_item->attributes = $attributeItem;
                }
            }
        }
        return $attributeCateloge;
    }
    
}
