<?php

namespace App\Services;

use App\Models\PostCataloges;
use App\Repositories\PostRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\PostServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class PostService extends BaseService implements PostServiceInterfaces
{
    protected $postRepositories;

    public function __construct(
         PostRepositories $postRepositories,
         ) {
        $this->postRepositories = $postRepositories;
        parent::__construct();
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 6;
        if($request->has('status')){
            $condition['where'] = [
                ['status','=',$request->status ?? 1],
            ];
        }

        $post = $this->postRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        [
            ['post_cateloge_post as pcsp','post.id','=','pcsp.post_id'],
           
        ],
        $record,
        $this->getPaginateIndex(),
        [],[],$this->whereRawCondition($request) ?? []
        );
        // dd($post);
       return $post;
    }


    public function create($request) {
        DB::beginTransaction();
        try {
            $post = $this->createPostService($request);
            if($post->id > 0) {
                // tạo bảng mới trug gian ghi đè 
                $catalogeSublist = $this->handlePostCataloge($request);
                $post->post_cateloge_post()->sync($catalogeSublist);
                $this->createRouter($request->input('canonical'),$post,'PostController');
             
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            // DB::rollBack();
            echo new Exception($e->getMessage()); die();
            // return false;
        }
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $post = $this->postRepositories->findByid($id); 
            $check = $this->updatePostService($request,$post);
            if($check == true)  {
                $this->updatePostCatalogePostService($request,$post);
                $this->updateRouter($request->input('meta_link'),$post,'PostController');
            }
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
            $this->postRepositories->update($request['id'], $status );  
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
          $this->postRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->postRepositories->deleteSoft($id);  
           
;            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function restore(int $id) {
        DB::beginTransaction();
        try {
            $this->postRepositories->restore($id);  
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
            $this->postRepositories->deleteForce($id);  
            $this->deleteRouter(
                $this->postRepositories->findByid($id),
                'PostController',
            );
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    
    private function handlePostCataloge($request) {
        return array_unique(array_merge($request->categories_sublist,[$request->post_cateloge_id]));
    }

    private function requestOnlyPostCataloge() {
        return ['follow','status','image','post_cateloge_id','album',
    'name','desc','content','meta_title','meta_desc','meta_keyword','canonical'
    ];
    }
    private function requestOnlyPostCatalogeTranslate() {
        return ['name','desc','content','meta_title','meta_desc','meta_keyword','canonical'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['post.name','image','status','id','post.post_cateloge_id'];
    }

    private function whereRawCondition($request) {
        if($request->integer('categories') > 0 && $request->input('categories') != 'none' ) {
            return [
                [
                    'pcsp.post_cateloge_id IN (
                        SELECT post_cateloge.id  FROM post_cateloge 
                        WHERE `LEFT` >= (SELECT `LEFT` from post_cateloge as cat  where cat.id = ?)
                        AND `RIGHT` <= (SELECT `RIGHT` from post_cateloge as cat  where cat.id = ?)
                    )',
                    [$request->integer('categories'),$request->integer('categories')]
                ]
            ];
        }
    }

    private function createPostService($request) {
        $data = $request->only($this->requestOnlyPostCataloge());
        $data['canonical'] = Str::slug($data['canonical']);
        $data['album'] = json_encode($data['album']);
        $data['user_id'] = auth('admin')->user()->id;
        $post = $this->postRepositories->create($data);  
        return $post;
    }

    
    private function updatePostService($request,$post) {
        $data = $request->only($this->requestOnlyPostCataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? $post->album;
        $data['user_id'] = Auth::user()->id;
        $check = $this->postRepositories->update($post->id,$data);
        return $check;
    }

    private function updatePostCatalogePostService($request,$post) {

    }
}
