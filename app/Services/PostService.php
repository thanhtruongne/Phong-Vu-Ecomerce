<?php

namespace App\Services;

use App\Models\PostCataloges;
use App\Repositories\LanguageRepositories;
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
    protected $postRepositories,$languageRepositories;

    public function __construct(
         PostRepositories $postRepositories,
         LanguageRepositories $languageRepositories,
         RouterRepositories $routerRepositories
         ) {
        $this->postRepositories = $postRepositories;
        $this->languageRepositories = $languageRepositories;
        parent::__construct($routerRepositories);
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
          ['pct.language_id' ,'=',$this->languageRepositories->getCurrentLanguage()->id], 
          ['status','=',$request->status ?? 1],
        ];

        $post = $this->postRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
            ['post_translate as pct' , 'pct.post_id','=','post.id'],
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
                $this->createTranslatePivotPostService($request,$post);
                $this->createRouter($request->input('meta_link'),$post,'PostController',$this->languageRepositories->getCurrentLanguage()->id);
             
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
                $this->updateRouter($request->input('meta_link'),$post,'PostController',$this->languageRepositories->getCurrentLanguage()->id);
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
                $this->languageRepositories->getCurrentLanguage()->id
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
        return ['follow','status','image','post_cateloge_id','album'];
    }
    private function requestOnlyPostCatalogeTranslate() {
        return ['language_id','name','desc','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','post.image','post.status','post.id','post.post_cateloge_id'];
    }

    private function whereRawCondition($request) {
        if($request->integer('categories') > 0 && $request->input('categories') != 'none' ) {
            return [
                [
                    'pcsp.post_cateloge_id IN (
                        SELECT post_cateloges.id  FROM post_cateloges 
                        WHERE `LEFT` >= (SELECT `LEFT` from post_cateloges as cat  where cat.id = ?)
                        AND `RIGHT` <= (SELECT `RIGHT` from post_cateloges as cat  where cat.id = ?)
                    )',
                    [$request->integer('categories'),$request->integer('categories')]
                ]
            ];
        }
    }

    private function createPostService($request) {
        $data = $request->only($this->requestOnlyPostCataloge());
        $data['album'] = json_encode($data['album']);
        $data['user_id'] = Auth::user()->id;
        $post = $this->postRepositories->create($data);  
        
        return $post;
    }

    private function createTranslatePivotPostService($request,$post) {
        $payloadTranslate = $request->only($this->requestOnlyPostCatalogeTranslate());
        $payloadTranslate['meta_link'] = Str::slug($payloadTranslate['meta_link']);
        $payloadTranslate['language_id'] = $this->languageRepositories->getCurrentLanguage()->id  ?? 1;
        $payloadTranslate['post_id'] = $post->id;
        $translate = $this->postRepositories->createTranslatePivot($post,$payloadTranslate,'languages');
        $catalogeSublist = $this->handlePostCataloge($request); 
        $post->post_cateloge_post()->sync($catalogeSublist);
    }
    
    private function updatePostService($request,$post) {
        $data = $request->only($this->requestOnlyPostCataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? $post->album;
        $data['user_id'] = Auth::user()->id;
        $check = $this->postRepositories->update($post->id,$data);
        return $check;
    }

    private function updatePostCatalogePostService($request,$post) {
        $payloadTranslate = $request->only($this->requestOnlyPostCatalogeTranslate());
        $payloadTranslate['meta_link'] = Str::slug($payloadTranslate['meta_link']);
        $payloadTranslate['language_id'] = $this->languageRepositories->getCurrentLanguage()->id  ?? 1;
        $payloadTranslate['post_id'] = $post->id;
        // tách ra khỏi bảng trung gian
        $detach = $post->languages()->detach([ $payloadTranslate['language_id'],$post->id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->postRepositories->createTranslatePivot($post,$payloadTranslate,'languages'); 
        $catalogeSublist = $this->handlePostCataloge($request); 
    
        $post->post_cateloge_post()->sync($catalogeSublist);
    }
}
