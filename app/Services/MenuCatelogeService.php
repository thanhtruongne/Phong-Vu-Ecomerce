<?php

namespace App\Services;

use App\Repositories\BaseRepositories;
use App\Repositories\LanguageRepositories;
use App\Repositories\MenuCatelogeRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\MenuCatelogeServiceInterfaces ;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class MenuCatelogeService extends BaseService implements MenuCatelogeServiceInterfaces
{
    protected $LanguageRepositories , $menuRepositories;

    public function __construct(
        LanguageRepositories $LanguageRepositories,
        RouterRepositories $routerRepositories,
        MenuCatelogeRepositories $menuRepositories
        ) {
        $this->LanguageRepositories = $LanguageRepositories;
        $this->menuRepositories = $menuRepositories;
        parent::__construct($routerRepositories);   
    }
    public function paginate($request) 
    {
       $condition = [];
       $condition['status'] = $request->status;
       $condition['search'] = $request->search;
       $condition['where'] = [
            ['menu_cateloge.status','=',1]
       ];
       $record = $request->input('record') ?? 6;
       $menuCateloge = $this->menuRepositories->paganation(
        $this->PaginateService(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [],
        $record,[],[],[],[]  
        );
       return $menuCateloge;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','keyword']);
            $data['user_id'] = Auth::id();
            $menuCateloge =  $this->menuRepositories->create($data);
            DB::commit();
            return [
                'id' => $menuCateloge->id,
                'name' => $menuCateloge->name,
                'keyword' => $menuCateloge->keyword,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }
    private function PaginateService() {
        return ['menu_cateloge.name','menu_cateloge.keyword','menu_cateloge.status','menu_cateloge.id'];
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            $this->LanguageRepositories->update($id,$data);   
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    private function createStringPost($model) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/','_$0',$model)).'_id';   
    }
}
