<?php

namespace App\Services;

use App\Models\PostCataloges;
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
    protected $menuRepositories;

    public function __construct(
         MenuRepositories $menuRepositories,
         ) {
        $this->menuRepositories = $menuRepositories;
        parent::__construct();
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $condition['status'] = +$request->status ?? 1;
        $record = $request->input('record') ?: 6;
        $menu = $this->menuRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
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
                    'name' => $val,
                    'canonical' => $payload['menu']['canonical'][$key]
                ];
                 $this->menuRepositories->create($data);
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

    public function saveChildren($request) {
        DB::beginTransaction();
        try {
            $data = $request->only(['menu_id','menu','menu_cateloge_id']);          
            $menuFound = $this->menuRepositories->findByid(+$data['menu_id']);
            foreach($data['menu']['name'] as $key => $val) {
                $payload = [
                    'menu_cateloge_id' =>  +$data['menu_cateloge_id'],
                    'user_id' => Auth::id(),
                    'name' => $val,
                    'canonical' => $data['menu']['canonical'][$key]
                ];
                $menuInsert = $this->menuRepositories->create($payload);
                $this->menuRepositories->createMenuChildrenByNode(+$data['menu_id'],$menuInsert);   
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
    (array $json = [] ,$parent_id = null  ,int $menu_cateloge_id = 0) 
    {     
        if(count($json)) {
            // $this->menuRepositories->setUpNullAllParentNode();
            foreach($json as $key => $val) {
               $update = [
                  'parent' => $parent_id ?? null,
                  'position' => count($json) - $key
               ];
               $this->menuRepositories->UpdateMenuChildrenByNode($val['id'],$update);
               if(!empty($val['children']) && count($val['children'])) {
                  $this->SaveTheNestedTableListDynamic($val['children'],$val['id'],$menu_cateloge_id);
               }
            }
        }

    }
    

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','mca.keyword','mca.name as menu_cateloge_name','menu.image','menu.status','menu.id','menu.menu_cateloge_id'];
    }

}
