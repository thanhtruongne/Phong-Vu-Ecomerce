<?php

namespace App\Services;

use App\Repositories\SoruceRepositories;
use App\Repositories\SourceRepositories;
use App\Services\Interfaces\SourceServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class SourceService implements SourceServiceInterfaces
{
    protected $sourceRepositories;

    public function __construct(SourceRepositories $sourceRepositories) {
        $this->sourceRepositories = $sourceRepositories;
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
       $source = $this->sourceRepositories->paganation(
        ['name','desc','id','status']
        ,$condition,[],$record,[],[],[],[]);
       return $source;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','desc','keyword']);
            $this->sourceRepositories->create($data);
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
            $this->sourceRepositories->update($request['id'], $status );  
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
          $this->sourceRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            return false;
        }
    }
}
