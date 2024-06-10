<?php

namespace App\Services;

use App\Repositories\BaseRepositories;
use App\Repositories\LanguageRepositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\LanguageServicesInterfaces;
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
class LanguageService extends BaseService implements LanguageServicesInterfaces
{
    protected $LanguageRepositories;

    public function __construct(
        LanguageRepositories $LanguageRepositories,
        RouterRepositories $routerRepositories
        ) {
        $this->LanguageRepositories = $LanguageRepositories;
        parent::__construct($routerRepositories);   
    }
    public function paginate($request) 
    {
       $condition = [];
       $condition['status'] = $request->status;
       $condition['search'] = $request->search;
       $record = $request->input('record') ?: 6;
       $languages = $this->LanguageRepositories->paganation(
        ['*'],
        $condition,
        //sử dụng mảng 4 để load join vào table
        [],
        $record,[],[],[],[]
        
        );
       return $languages;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            $data['user_id'] = Auth::user()->id;
            $this->LanguageRepositories->create($data);   
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
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

    public function changeStatus($request) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $request['status'] 
            ];
            $this->LanguageRepositories->update($request['id'], $status );  
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
          $this->LanguageRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            // return false;
        }
    }

    public function SwitchLanguage( int $id) {
        $language = $this->LanguageRepositories->findByid($id);
        if($language) {
           $languageUpdate = $this->LanguageRepositories->update($id,['current' => 1]);
           $updateLanguageNoyCurrent = $this->LanguageRepositories->UpdateWhere([[ 'id','!=',$id ]],['current' => 0]);
        }
        
    }

    public function transltateDynamicLanguages($request,array $option = []) {
        DB::beginTransaction();
        try {
            $payload = [
                'name' => $request->input('translate_name'),
                'content' => $request->input('translate_content'),
                'desc' => $request->input('translate_name'),
                'meta_title' => $request->input('translate_meta_title'),
                'meta_keyword' => $request->input('translate_meta_keyword'),
                'meta_desc' => $request->input('translate_meta_desc'),
                'meta_link' => $request->input('translate_meta_link'),
                'languages_id' => +$option['languages_id'],
                $this->createStringPost($option['model']) => +$option['detach_id']
            ];
            $repositoriesInstance = '\App\Repositories\\'.ucfirst($option['model']).'Repositories';
            if(class_exists($repositoriesInstance)) {
                $intanceController = app($repositoriesInstance);
            }
            $find = $intanceController->findById($option['detach_id']);
            $find->languages()->detach([$find->id,$option['languages_id']]);
            $intanceController->createTranslatePivot($find,$payload,'languages');
            
            //xóa force phaần router sao đó create dynamic lại5
            $this->deleteRouter($find ,ucfirst($option['model']).'Controller' , $option['languages_id']);
           
            $this->createRouter(
                $request->input('translate_meta_link'),
                $find,
                ucfirst($option['model']).'Controller',
                $option['languages_id']
            );
           
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            // return false;
        }
    }

    private function createStringPost($model) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/','_$0',$model)).'_id';   
    }
}
