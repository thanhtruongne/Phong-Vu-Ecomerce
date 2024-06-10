<?php

namespace App\Services;
use App\Repositories\CustomerRepositories;
use App\Services\Interfaces\CustomerServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use Faker\Core\Number;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class CustomerService implements CustomerServiceInterfaces
{
    use UploadImage;
    public $customerRepositoreis;
    

    public function __construct(CustomerRepositories $customerRepositoreis) {
        $this->customerRepositoreis  =  $customerRepositoreis;
    }

    public function paginate($request) {
        $condition = [];
        $condition['search'] = addslashes($request->input('search'));
        $condition['where'] = [
            ['status', '=', $request->status ?? 1]
          ];
        $record = $request->input('record') ?: 12;
        $customer =  $this->customerRepositoreis->paganation(
            ['*']
            ,$condition,
            [],
            $record,[],[],[],[]
        );
        return $customer;
    }

    public function create($request) {
        DB::beginTransaction();
    try {
        $data = $request->except(['_token','password_confirmation']);
        $data['birthday'] = Carbon::createFromFormat('d/m/Y', $data['birthday'])->format('Y-m-d');
        $data['thumb'] = $this->UploadSingleImage($data['thumb'],'uploads'); 
        $data['customer_cateloge_id'] = +$data['customer_cateloge_id'];
        $customer = $this->customerRepositoreis->create($data);
       
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
              $user = $this->customerRepositoreis->findByid($id);
              if(isset($data['thumb'])) {
                $data['thumb'] = $this->UploadUpdateSingleImage($data['thumb'],$user->thumb,'uploads');
              }
              $test = $this->customerRepositoreis->update($id,$data);
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
            $this->customerRepositoreis->deleteSoft($id);     
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }

    public function trashed() {
        return $this->customerRepositoreis->trashed();
    }

    public function deleteForce(int $id) {
       
        DB::beginTransaction();
        try {
            $this->customerRepositoreis->deleteForce($id);
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
            $this->customerRepositoreis->update($data['id'], $status );
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
          $this->customerRepositoreis->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->customerRepositoreis->restore($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // echo new Exception($e->getMessage());
            return false;
        }
    }
}
