<?php
namespace App\Services;

use App\Repositories\LanguageRepositories;
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
    protected $productCatelogeRepositories,$routerRepositories, $languageRepositories;

    public function __construct(
        ProductCatelogeRepositories $productCatelogeRepositories , 
        RouterRepositories $routerRepositories,
        LanguageRepositories $languageRepositories
        ) {
        $this->productCatelogeRepositories = $productCatelogeRepositories;
        $this->routerRepositories = $routerRepositories;
        $this->languageRepositories = $languageRepositories;
        parent::__construct($routerRepositories);
        
    }
    public function paginate($request) 
    {
        $condition = [];
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
            ['status' ,'=', $request->status ?? 1]
        ];
        $productCateloge = $this->productCatelogeRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
           [ 'product_cateloge_translate as pct' , 'pct.product_cateloge_id','=','product.id']
        ],
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
                $this->createTranslateProductCatelogePivot($request,$productCateloge); 
                $this->createRouter(
                    $request->input('meta_link'),
                    $productCateloge,
                    'ProductCatelogeController',
                    $this->languageRepositories->getCurrentLanguage()->id
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
                $this->updateTranslateProductCatelogePivot($id,$productCateloge,$request);
                $this->updateRouter(
                    $request->input('meta_link'),
                    $productCateloge,
                    'ProductCatelogeController',
                    $this->languageRepositories->getCurrentLanguage()->id
                );
            }         
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
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

    public function restore(int $id) {
        DB::beginTransaction();
        try {
            $this->productCatelogeRepositories->restore($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function deleteForce(int $id) {
        DB::beginTransaction();
        try {
            $this->productCatelogeRepositories->deleteForce($id);  
            $this->deleteRouter(
                $this->productCatelogeRepositories->findByid($id),
                'ProductCatelogeController',
                $this->languageRepositories->getCurrentLanguage()->id
            );
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    private function requestOnlyProductCateloge() {
        return ['follow','status','image','album'];
    }

    private function createProductCatelogeIndex($request) {
        $data = $request->only($this->requestOnlyProductCateloge());
        $data['album'] = !empty($request->input('album')) ? json_encode($request->input('album')) : '' ;
        $data['user_id'] = Auth::user()->id;
        $productCateloge = $this->productCatelogeRepositories->create($data);
        //tạo nested set
        $this->productCatelogeRepositories->createCategoriesByNode($request->only($this->createCategoriesNode()),$productCateloge);
        return $productCateloge;
    }
    

    private function createTranslateProductCatelogePivot($request,$productCateloge) {
        $payloadTranslate = $request->only($this->requestOnlyProductCatelogeTranslate());
        $payloadTranslate['meta_link'] = Str::slug($payloadTranslate['meta_link']);
        $payloadTranslate['languages_id'] = 1;
        $payloadTranslate['product_cateloge_id'] = $productCateloge->id;
        $this->productCatelogeRepositories->createTranslatePivot($productCateloge,$payloadTranslate,'languages'); 
    }

    private function updateProductCateloge($request,$productCateloge) {
        $data = $request->only($this->requestOnlyProductCateloge());
        $data['user_id'] = Auth::user()->id;
        $data['album'] = json_encode($request->input('album')) ?? $productCateloge->album;
        $check = $this->productCatelogeRepositories->update($productCateloge->id,$data);
        return $check;
    }

    private function updateTranslateProductCatelogePivot($id,$productCateloge,$request) {
        $payloadTranslate = $request->only($this->requestOnlyProductCatelogeTranslate());
        $payloadTranslate['languages_id'] = 1;
        $payloadTranslate['product_cateloge_id'] = $id;
        // tách ra khỏi bảng trung gian
        $detach = $productCateloge->languages()->detach([ $payloadTranslate['languages_id'],$id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->productCatelogeRepositories->createTranslatePivot($productCateloge,$payloadTranslate,'languages'); 
    }

    private function createCategoriesNode() {
        return ['categories_id'];
    }
    private function requestOnlyProductCatelogeTranslate() {
        return ['name','desc','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','product_cateloge.image','product_cateloge.status','product_cateloge.id'];
    }
}
