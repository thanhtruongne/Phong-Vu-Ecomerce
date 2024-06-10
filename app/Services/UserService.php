<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\BaseRepositories;
// use App\Repositories\Interfaces\UserRepositoriesInterfaces as UserRepositories;
use App\Repositories\UserRepositories;
use App\Services\Interfaces\UserServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterfaces
{
    use UploadImage;
    public $userRepositoreis;
    

    public function __construct(UserRepositories $userReopsitories) {
        $this->userRepositoreis  =  $userReopsitories;
    }

    public function paginate($request) {
        $condition = [];
        $condition['search'] = addslashes($request->input('search'));
        $condition['member'] = $request->input('member');
        $condition['where'] = [
            ['status', '=', $request->status ?? 1]
          ];
        $record = $request->input('record') ?: 12;
        $user =  $this->userRepositoreis->paganation(
            ['name','email','phone','status','address','id','user_cataloges_id']
            ,$condition,
            [],
            $record,[],[],[],[]
        );
        return $user;
    }

    public function create($request) {
        DB::beginTransaction();
    try {
        $sum = $request->except(['_token','password_confirmation']);
        $sum['password'] = Hash::make($sum['password']);
        $sum['birthday'] = Carbon::createFromFormat('d/m/Y', $sum['birthday'])->format('Y-m-d');
        $sum['thumb'] = $this->UploadSingleImage($sum['thumb'],'uploads'); 
        $sum['status'] = 1;
        $newuser = $this->userRepositoreis->create($sum);
        DB::commit();
        return true;
    } catch (Exception $e) {
        DB::rollBack();
        echo new Exception($e->getMessage());die();
        return false;
    }
    }

    public function update(int $id,$request) {
        DB::beginTransaction();
        try {
              $data = $request->except(['_token']);
              $user = $this->userRepositoreis->findByid($id);
              if(isset($data['thumb'])) {
                $data['thumb'] = $this->UploadUpdateSingleImage($data['thumb'],$user->thumb,'uploads');
              }
              $test = $this->userRepositoreis->update($id,$data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    public function deleteSoft(int $id) {
        DB::beginTransaction();
        try {
            $this->userRepositoreis->deleteSoft($id);     
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    public function trashed() {
        return $this->userRepositoreis->trashed();
    }

    public function deleteForce(int $id) {
       
        DB::beginTransaction();
        try {
            $this->userRepositoreis->deleteForce($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
        
    }

    public function changeStatus(array $data) {
        DB::beginTransaction();
        try {
            $status = [
                'status' => $data['status'] 
            ];
            $this->userRepositoreis->update($data['id'], $status );
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
          $this->userRepositoreis->UpdateByWhereIn($data['id'],'id',$status) ;

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            // return false;
        }
    }

    public function restoreUser(int $id) {
        DB::beginTransaction();
        try {
            $this->userRepositoreis->restore($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }
}
