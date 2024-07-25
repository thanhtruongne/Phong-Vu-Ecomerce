<?php

namespace App\Services;

use App\Models\PostCataloges;
use App\Repositories\PostCatelogeRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\PostCatalogeServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class PostCatelogeService extends BaseService implements PostCatalogeServiceInterfaces
{
    protected $postCatalogeRepositories;

    public function __construct(
        PostCatelogeRepositories $postCatalogeRepositories
        ) {
        $this->postCatalogeRepositories = $postCatalogeRepositories;
        parent::__construct();
    }
    public function paginate($request) 
    {
        $condition = [];
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
            ['status' ,'=', $request->status ?? 1]
        ];
        $postCataloge = $this->postCatalogeRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
           [ 'post_cateloge_translate as pct' , 'pct.post_cateloge_id','=','post_cateloge.id']
        ],
        $record,[],[],[],[]
        
        );
       return $postCataloge;
    }
    

    public function create($request) {
        DB::beginTransaction();
        try {
            $postCataloge = $this->createPostCatalogeIndex($request);
            //đồng thời tạo phân quyền role cho nhóm người dùng mới
            
            if($postCataloge->id > 0) {
                $this->createRouter(
                    $request->input('meta_link'),$postCataloge,
                    'PostCatalogeController',
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
            $postCataloge = $this->postCatalogeRepositories->findByid($id); 
            $check = $this->updatePostCataloge($request,$postCataloge);
            if($check == true) {
                $this->updateRouter(
                    $request->input('meta_link'),
                    $postCataloge,
                    'PostCatalogeController',
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
            $this->postCatalogeRepositories->update($request['id'], $status );  
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
          $this->postCatalogeRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->postCatalogeRepositories->deleteSoft($id);  
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
            $this->postCatalogeRepositories->restore($id);  
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
            $this->postCatalogeRepositories->deleteForce($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    private function requestOnlyPostCataloge() {
        return ['follow','status','image','album'];
    }

    private function createPostCatalogeIndex($request) {
        $data = $request->only($this->requestOnlyPostCataloge());
        //tạo nested set
  
        $data['album'] = !empty($request->input('album')) ? json_encode($request->input('album')) : '' ;
        $data['canonical'] = Str::slug($data['canonical']);
        $postCataloge = $this->postCatalogeRepositories->create($data); 
        $this->postCatalogeRepositories->createCategoriesByNode($request->only($this->createCategoriesNode()),$postCataloge);
        return $postCataloge;
    }
    


    private function updatePostCataloge($request,$postCataloge) {
        $data = $request->only($this->requestOnlyPostCataloge());
        $data['album'] = json_encode($request->input('album')) ?? $postCataloge->album;
        $data['canonical'] = Str::slug($data['canonical']);
        $check = $this->postCatalogeRepositories->update($postCataloge->id,$data);
        return $check;
    }

    private function createCategoriesNode() {
        return ['categories_id'];
    }
    private function requestOnlyPostCatalogeTranslate() {
        return ['name','description','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','post_cateloge.image','post_cateloge.status','post_cateloge.id'];
    }
}
