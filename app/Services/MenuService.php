<?php

namespace App\Services;

use App\Models\PostCataloges;
use App\Repositories\LanguageRepositories;
use App\Repositories\MenuRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\MenuServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class MenuService extends BaseService implements MenuServiceInterfaces
{
    protected $menuRepositories,$languageRepositories;

    public function __construct(
         MenuRepositories $menuRepositories,
         LanguageRepositories $languageRepositories,
         RouterRepositories $routerRepositories
         ) {
        $this->menuRepositories = $menuRepositories;
        $this->languageRepositories = $languageRepositories;
        parent::__construct($routerRepositories);
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $condition['status'] = +$request->status ?? 1;
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
          ['pct.language_id' ,'=',$this->languageRepositories->getCurrentLanguage()->id], 
        ];
        $menu = $this->menuRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
            ['menu_translate as pct' , 'pct.menu_id','=','menu.id'],
            ['menu_cateloge as mca','mca.id','=','menu.menu_cateloge_id']
           
        ],
        $record,[],[],[],[]
        );
        // dd($menu);
       return $menu;
    }


    public function create($request , int $language_id = 1) {
        DB::beginTransaction();
        try {
            $payload = $request->only(['menu_cateloge_id','type','menu','image']);
            foreach($payload['menu']['name'] as $key => $val) {
                $data = [
                    'menu_cateloge_id' =>  $payload['menu_cateloge_id'],
                    'image' => $payload['menu']['image'][$key],
                    'type' => $payload['type'],
                    'position' =>  $payload['menu']['position'][$key],
                    'user_id' => Auth::id()
                ];
                $menuInsert = $this->menuRepositories->create($data);
                if($menuInsert->id > 0) {
                    $payloadTranslate = [
                        'menu_id' => $menuInsert->id,
                        'language_id' => $language_id,
                        'name' => $val,
                        'canonical' => $payload['menu']['canonical'][$key]
                    ];
                    $menuInsert->languages()->detach([ $payloadTranslate['language_id'],$menuInsert->id]);
                    // // tạo bảng mới trug gian ghi đè 
                    $translate = $this->menuRepositories->createTranslatePivot($menuInsert,$payloadTranslate,'languages'); 
                }
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
            $this->menuRepositories->update($request['id'], $status );  
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
          $this->menuRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->menuRepositories->deleteSoft($id);  
           
;            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function saveChildren($request , $language_id) {
        DB::beginTransaction();
        try {
            $data = $request->only(['menu_id','menu','menu_cateloge_id']);          
            $menuFound = $this->menuRepositories->findByid(+$data['menu_id']);
            foreach($data['menu']['name'] as $key => $val) {
                $payload = [
                    'menu_cateloge_id' =>  +$data['menu_cateloge_id'],
                    'user_id' => Auth::id() 
                ];
                $menuInsert = $this->menuRepositories->create($payload);
                // dd($payload ,$menuFound, $menuInsert);
                $this->menuRepositories->createMenuChildrenByNode(+$data['menu_id'],$menuInsert);
                if($menuInsert->id > 0) {
                    $payloadTranslate = [
                        'menu_id' => $menuInsert->id,
                        'language_id' => $language_id,
                        'name' => $val,
                        'canonical' => $data['menu']['canonical'][$key]
                    ];
                    $menuInsert->languages()->detach([ $payloadTranslate['language_id'],$menuInsert->id]);
                    // // tạo bảng mới trug gian ghi đè 
                    $translate = $this->menuRepositories->createTranslatePivot($menuInsert,$payloadTranslate,'languages'); 
                }
            }
           
;           DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }

    public function SaveTheNestedTableListDynamic
    (array $json = [] , int $language_id = 1 , int $parent_id = 0 ,int $menu_cateloge_id = 0) 
    {     
       
        if(count($json)) {
            // $this->menuRepositories->setUpNullAllParentNode();
            foreach($json as $key => $val) {
               $update = [
                  'parent' => $parent_id ?? 0,
                  'position' => count($json) - $key
               ];
               $this->menuRepositories->UpdateMenuChildrenByNode($val['id'],$update);
               if(!empty($val['children']) && count($val['children'])) {
                  $this->SaveTheNestedTableListDynamic($val['children'],$language_id,$val['id'],$menu_cateloge_id);
               }
            }
        }

    }
    

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','mca.keyword','mca.name as menu_cateloge_name','menu.image','menu.status','menu.id','menu.menu_cateloge_id'];
    }

}
