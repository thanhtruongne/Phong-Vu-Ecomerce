<?php

namespace App\Services;
use App\Repositories\ProductCatelogeRepositories;
use App\Repositories\PromotionRepositories;
use App\Repositories\RouterRepositories;
use App\Repositories\WidgetRepositories;
use App\Services\Interfaces\ProductServiceInterfaces as ProductService;
use App\Services\Interfaces\WidgetServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class WidgetService extends BaseService implements WidgetServiceInterfaces
{
    protected $widgetRepositories,
    $promotionRepositories,
    $productCatelogeRepositories,
    $productService
    ;

    public function __construct(
         WidgetRepositories $widgetRepositories,
         ProductService $productService,
         PromotionRepositories $promotionRepositories,
         ProductCatelogeRepositories $productCatelogeRepositories
         ) {
        $this->widgetRepositories = $widgetRepositories;
        $this->promotionRepositories = $promotionRepositories;
        $this->productService = $productService;
        parent::__construct();
        $this->productCatelogeRepositories = $productCatelogeRepositories;
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $condition['status'] = +$request->status ?? 1;
        $record = $request->input('record') ?: 6;
        $slider = $this->widgetRepositories->paganation(
        ['*'],
        $condition,[],$record,[],[],[],[]
        );
        // dd($slider);
       return $slider;
    }

    public function create($request ) {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','keyword','model','desc','short_code']);
            $data['model_id'] = $request->input('model_id.id');
            $data['album'] = $request->input('album');
            $this->widgetRepositories->create($data);
           
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage()); die();
            return false;
        }
    }

    public function update(int $id ,$request)  {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','keyword','model','desc','short_code']);
            $data['model_id'] = $request->input('model_id.id');
            $data['album'] = $request->input('album');
            $this->widgetRepositories->update($id,$data);
           
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            // return false;
        }
    }

    public function changeStatus($request) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $request['status'] 
            ];
            $this->widgetRepositories->update($request['id'], $status );  
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
          $this->widgetRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->widgetRepositories->deleteSoft($id);  
           
;            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    } 

    // public function findTheWidgetByService(string $keyword = '' , $language_id = 0 ,$params) {
    //     $widget = $this->widgetRepositories->findCondition([
    //         ['keyword','=',$keyword],
    //         ['status','=',1]
    //     ],[],[],'first');
        
    //     if($widget->id > 0) {
    //         $ModeltRepositories = $this->loadingClass('Repositories','Repositories',$widget->model);
    //         $widgetModel = $ModeltRepositories->findCondition(...$this->argumentModel($widget,$params,$language_id));
    //         $model = lcfirst(str_replace('Cateloge','',$widget->model)).'s';
    //         if(strpos($widget->model,'Cateloge') && isset($params['data-object']) && $params['data-object'] == true && $model == 'products') {
    //             if(count($widgetModel)) {
    //                 foreach($widgetModel as $key => $object) {
                      
    //                     $product_id = $object->products->pluck('id');
    //                     //dymnamic tạo thêm các promotion cho product
    //                     $promotion = $this->promotionRepositories->findByProductPromotion($product_id);
    //                     //sau đó foreach gán vào widget
    //                     if($promotion) {
    //                         foreach($object->products as $index => $product) {
    //                               foreach($promotion as $index_promotion => $item_promotion) {
    //                                     if($item_promotion['product_id'] == $product->id) {
    //                                         $object->products[$index_promotion]->promotions = $item_promotion;
    //                                     }
    //                               }
    //                         };
    //                     }

    //                     if(isset($params['children']) && $params['children'] == TRUE ) {
    //                        $object->children = $this->productCatelogeRepositories->findCondition([
    //                             ['LEFT','>',$object->LEFT],
    //                             ['RIGHT','<',$object->RIGHT],
    //                             ['status','=',1]
    //                        ],[],[],'multiple');

    //                     }
    //                 }
    //             }
    //             dd($widgetModel);
    //         }
    //         return $widgetModel;
    //     }
    // }

    private function loadingClass(string $app = '',string $dot = '',string $model = '') {    
        $nameSpace = "\App\\".$app.'\\'.ucfirst($model).$dot;
        if(class_exists($nameSpace)) {
            $instance = app($nameSpace);
        }
        return $instance;
         
    }
    private function argumentModel($widget,$params,$relation) {    
        // dd($widget,$params,$relation);
        // nếu trong model có cateloge thì trò vào lấy các nme
        if(strpos($widget->model,'Cateloge') && isset($params['children'])) {
            $model = lcfirst(str_replace('Cateloge','',$widget->model)).'s';
            $relation[$model] = function($query) use($params) {
                $query->limit($params['limit'] ?? 12);
                $query->where('status','=',1);
            };
            $withCount[] = $model;  
        }
      
        return [
            'condition' => [
                ['status','=',1]
            ],
            'params' => [
                'whereIn' => 'id',
                'whereValues' => $widget->model_id
            ],
            'relation' => $relation ?? [''],
            'type' => 'multiple',
            'withCount' => $withCount ?? []

        ];     
    }


    public function foundTheWidgetByKeyword(array $payload) {
        $whereIn = [];
        if(isset($payload)) {
            foreach($payload as $key => $item) {
                $whereIn[] = $item['keyword'];
            }
        }
        $widgets = $this->widgetRepositories->getWidgetByKeyWord($whereIn,'name');
        $data=[];
        if(!is_null($widgets)) {
            foreach($widgets as $key_widget =>  $widget) {
               $class = $this->loadingClass('Repositories','Repositories',$widget->model);
               $object = $class->findCondition(...$this->argumentModel($widget,$payload[$key_widget],[] ));
               $model = lcfirst(str_replace('Cateloge','',$widget->model)).'s' ?? lcfirst($widget->model);
               // tồn tại phần cateloge lấy ra các nhóm sản phẩm       
                if(count($object) && !is_null($object) && strpos($widget->model,'Cateloge')) {
                   foreach($object as $object_key =>  $object_value) {
                    //tìm các danh mục con chứa các danh mục cha trường hợp có payload truyền vào co children
                   // danh mục cấp 1
                   // hạn chế dùng truy vấ1nn này khi loop mất rất nhiều query truy vấn loading chậm
                        if( isset($payload[$key_widget]['children'])  && $payload[$key_widget]['children'] == true ) {
                            $childrenArgument = $this->childrenArgument([$object_value->id],['']);
                            $object->children = $class->findCondition(...$childrenArgument);   
                        }
                        if( isset($payload[$key_widget]['data-object']) && $payload[$key_widget]['data-object'] == true) {
                            $idCond = [];
                            //đệ quy = mysql tìm các danh mục con chứa sản phẩm của danh cha
                            //lấy ra được danh mục con cũa danh mục hiện tại và chính nó
                            $child = $class->recursiveCategory($object_value->id,str_replace('s','',$model));
                            foreach($child as $childCond) {
                                $idCond[] = $childCond->id;
                            }
                            $classRepo = $this->loadingClass('Repositories','Repositories',ucfirst(str_replace('s','',$model)));
                            //tìm danh mục cha để push product của danh mục con và cả product của danh mục cha vào
                            if($object_value->RIGHT - $object_value->LEFT > 1) {
                                $object_value->{$model} = $classRepo->findObjectCategoryID($idCond,str_replace('s','',$model));

                            }
                            // tìm kiếm thêm promotion cho products
                            if( isset($payload[$key_widget]['promotion']) && $payload[$key_widget]['promotion'] == true ) {    
                                //trường hợp set promotion cho danh mục cha
                                if(isset($object_value->{$model}) && !empty($object_value->{$model})) {  
                                    $product_id =  $object_value->{$model}->pluck('id')->toArray();
                                    $object_value->{$model} = $this->productService->CombineArrayProductHavePromotionByWhereIn($product_id,$object_value->{$model},'product'); 
                                }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                            }
                           
                            
                        }
                   }
                }
               //trường hợp là các sản phẩm
               else {
                // $product_id = $object->pluck('id')->toArray();       
                // $object = $this->productService->CombineArrayProductHavePromotionByWhereIn($product_id,$object,'products'); 

                if(isset($payload[$key_widget]['promotion_variant']) && $payload[$key_widget]['promotion_variant'] == true) {               
                    foreach($object as $variant_items) {
                       $product_variant_id = $variant_items->product_variant->pluck('id')->toArray(); 
                       $variant_items->variant = $this->productService->CombineArrayProductHavePromotionByWhereIn($product_variant_id,$variant_items->product_variant,'variant'); 
                    }  
                   
                }
               }
               $widget->object = $object;
               $data[$payload[$key_widget]['keyword']] = $widget;
            }
            
        }
        return $data;
    }

    private function childrenArgument($object_id , $relation) {

        $condition = [
            ['status','=',1]
        ];
        return [
            'condition' => $condition,
            'params' => [
                'whereIn' => 'parent',
                'whereValues' => $object_id
            ],
            'relation' => $relation,
            'type' => 'multiple',
            'withCount' => []
        ];
    }
}
