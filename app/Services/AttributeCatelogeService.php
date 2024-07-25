<?php
namespace App\Services;

use App\Repositories\CategoriesRepositories;
use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\AttributeCatelogeServiceInterfaces;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class AttributeCatelogeService extends BaseService implements AttributeCatelogeServiceInterfaces
{
    protected $attributeCatelogeRepositories;

    public function __construct(
        AttributeCatelogeRepositories $attributeCatelogeRepositories , 
        ) {
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
        
        $attributeCateloge = $this->attributeCatelogeRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [],
        $record,[],[],[],[]
        
        );
       return $attributeCateloge;
    }
    

    public function create($request) {
        DB::beginTransaction();
        try {
            //đồng thời tạo phân quyền role cho nhóm người dùng mới
            $attributeCateloge = $this->createAttributeCatelogeIndex($request);    
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
            $attributeCateloge = $this->attributeCatelogeRepositories->findByid($id); 
            $check = $this->updateAttributeCateloge($request,$attributeCateloge);
            if($check == true) $this->updateTranslateAttributeCatelogePivot($id,$attributeCateloge,$request);         
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
            $this->attributeCatelogeRepositories->update($request['id'], $status );  
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
          $this->attributeCatelogeRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->attributeCatelogeRepositories->deleteSoft($id);  
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
            $this->attributeCatelogeRepositories->restore($id);  
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
            $this->attributeCatelogeRepositories->deleteForce($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    private function requestOnlyAttributeCateloge() {
        return ['status','image','album',
           'name','desc','content','meta_title','meta_desc','meta_keyword','canonical'
        ];
    }

    private function createAttributeCatelogeIndex($request) {
        $data = $request->only($this->requestOnlyAttributeCateloge());   
        $data['album'] = !empty($request->input('album') ? json_encode($request->input('album')) : ''); 
        $data['canonical'] = Str::slug($data['canonical']);
        $attributeCateloge = $this->attributeCatelogeRepositories->create($data);
        //tạo nested set
        $this->attributeCatelogeRepositories->createCategoriesByNode($request->only($this->createCategoriesNode()), $attributeCateloge);
        return $attributeCateloge;
    }
    

    private function createTranslateAttributeCatelogePivot($request,$attributeCateloge) {
        $payloadTranslate = $request->only($this->requestOnlyAttributeCatelogeTranslate());
        $payloadTranslate['meta_link'] = Str::slug($payloadTranslate['meta_link']);
        $payloadTranslate['languages_id'] = 1;
        $payloadTranslate['attribute_cateloge_id'] = $attributeCateloge->id;
        $this->attributeCatelogeRepositories->createTranslatePivot($attributeCateloge,$payloadTranslate,'languages'); 
    }

    private function updateAttributeCateloge($request,$attributeCateloge) {
        $data = $request->only($this->requestOnlyAttributeCateloge());
        $data['user_id'] = Auth::user()->id;
        $data['album'] = json_encode($request->input('album')) ?? $attributeCateloge->album;
        $check = $this->attributeCatelogeRepositories->update($attributeCateloge->id,$data);
        return $check;
    }

    private function updateTranslateAttributeCatelogePivot($id,$attributeCateloge,$request) {
        $payloadTranslate = $request->only($this->requestOnlyAttributeCatelogeTranslate());
        $payloadTranslate['languages_id'] = 1;
        $payloadTranslate['attribute_cateloge_id'] = $id;
        // tách ra khỏi bảng trung gian
        $detach = $attributeCateloge->languages()->detach([ $payloadTranslate['languages_id'],$id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->attributeCatelogeRepositories->createTranslatePivot($attributeCateloge,$payloadTranslate,'languages'); 
    }

    private function createCategoriesNode() {
        return ['categories_id','name'];
    }
    private function requestOnlyAttributeCatelogeTranslate() {
        return ['name','desc','content','meta_title','meta_desc','meta_keyword','canonical'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','attribute_cateloge.image','attribute_cateloge.status','attribute_cateloge.id'];
    }
}
