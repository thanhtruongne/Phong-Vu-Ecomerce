<?php

namespace App\Services;

use App\Repositories\PermissionsRepositories;
use App\Repositories\UserCatalogeRepositories;
use App\Services\Interfaces\PermissionsServiceInterfaces;
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
class PermissionsService implements PermissionsServiceInterfaces
{
    protected $permissionRepositories,$userCatalogeRepositories;
    public function __construct(
        PermissionsRepositories $permissionRepositories , 
        UserCatalogeRepositories $userCatalogeRepositories
    ) 
    {
        $this->permissionRepositories = $permissionRepositories;
        $this->userCatalogeRepositories = $userCatalogeRepositories;
    }
    public function paginate($request) 
    {
        $condition = [];
        $record = $request->input('record') ?: 6;
        $permissions = $this->permissionRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [],
        $record,[],[],[],[]
        
        );
       return $permissions;
    }
    

    public function create($request) {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','canonical']);
            $this->permissionRepositories->create($data);
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
            $data = $request->only(['name','canonical']);
            $this->permissionRepositories->update($id,$data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }

    public function ChangeRoles($request) {
        DB::beginTransaction();
        try {
            $permission = $request->input('permissions');
            if(!empty($permission)) {
                foreach($permission as $key => $val) {
                    $userCataloge = $this->userCatalogeRepositories->findByid($key);          
                    $userCataloge->permissions()->detach($userCataloge->id) ;
                    $userCataloge->permissions()->sync(array_map('intval',$val));
                }
            }
            
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());die();
            return false;
        }
    }


    public function destroy($id) {
        DB::beginTransaction();
        try {
          
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    private function getPaginateIndex() {
       return ['*'];
    }

    private function changePermission($request) {
        $permission = $request->input('permissions');
            foreach($permission as $key => $val) {
            $userCataloge = $this->userCatalogeRepositories->findByid($key);
            // $userCataloge->permissions()->detach([$userCataloge->id,$val]) ;
            $userCataloge->permissions()->sync(array_map('intval',$val));
        }
    }
}
