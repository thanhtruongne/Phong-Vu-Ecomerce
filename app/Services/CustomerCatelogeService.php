<?php

namespace App\Services;

use App\Repositories\CustomerCatelogeRepositories;
use App\Services\Interfaces\CustomerCatelogeServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class CustomerCatelogeService implements CustomerCatelogeServiceInterfaces
{
    use UploadImage;
    public $customerCatelogeRepositoreis;
    

    public function __construct(CustomerCatelogeRepositories $customerCatelogeRepositoreis) {
        $this->customerCatelogeRepositoreis  =  $customerCatelogeRepositoreis;
    }

    public function paginate($request) {
     
        $condition = [];
        $condition['search'] = addslashes($request->input('search'));
        $record = $request->input('record') ?? 12;
        $customerCateloge =  $this->customerCatelogeRepositoreis->paganation(
            ['*']
            ,$condition,
            [],
            $record,[],[],[],[]
        );
        return $customerCateloge;
    }

    public function create($request) {
        DB::beginTransaction();
    try {
        $data = $request->except(['_token']);
        $this->customerCatelogeRepositoreis->create($data);
      
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
              $user = $this->customerCatelogeRepositoreis->findByid($id);
              if(isset($data['thumb'])) {
                $data['thumb'] = $this->UploadUpdateSingleImage($data['thumb'],$user->thumb,'uploads');
              }
              $test = $this->customerCatelogeRepositoreis->update($id,$data);
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
            $this->customerCatelogeRepositoreis->deleteSoft($id);     
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    public function trashed() {
        return $this->customerCatelogeRepositoreis->trashed();
    }

    public function deleteForce(int $id) {
       
        DB::beginTransaction();
        try {
            $this->customerCatelogeRepositoreis->deleteForce($id);
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
            $this->customerCatelogeRepositoreis->update($data['id'], $status );
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
          $this->customerCatelogeRepositoreis->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->customerCatelogeRepositoreis->restore($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }
}
