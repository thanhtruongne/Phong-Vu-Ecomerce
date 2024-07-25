<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\BaseRepositories;
use App\Repositories\UserCatalogeRepositories;
use App\Repositories\UserRepositoreis;
use App\Services\Interfaces\UserCatalogeServiceInteface;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserCatalogeService implements UserCatalogeServiceInteface
{
    protected $userCatalogeRepositories;

    public function __construct(UserCatalogeRepositories $userCatalogeRepositories) {
        $this->userCatalogeRepositories = $userCatalogeRepositories;
    }
    public function paginate($request) 
    {
       $condition = [];
       $condition['search'] = $request->search;
       $record = $request->input('record') ?: 6;
       $condition['where'] = 
       [
            ['status', '=', $request->status ?? 1]
            
       ];
       $userCataloge = $this->userCatalogeRepositories->paganation(
        ['name','desc','id','status']
        ,$condition,[],$record,[],['users'],[],[]);
       return $userCataloge;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            $data['status'] = 1;
            // $this->userCatalogeRepositories->createRoles($data['name']);
            $this->userCatalogeRepositories->create($data);   
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            return false;
        }
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            $userCataloge = $this->userCatalogeRepositories->findByid($id);
            // $this->userCatalogeRepositories->updateRoles($userCataloge->name,$data['name']);
            $this->userCatalogeRepositories->update($id,$data);   
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
            $this->userCatalogeRepositories->update($request['id'], $status );  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            return false;
        }
    }

    public function ChangeStatusAll(array $data) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $data['value']
            ];
          $this->userCatalogeRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            return false;
        }
    }
}
