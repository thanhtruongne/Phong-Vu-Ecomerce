<?php
namespace App\Services;

use App\Repositories\RouterRepositories;
use App\Repositories\SystemRepositories;
use App\Services\Interfaces\SystemServiceInterfaces;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class SystemService extends BaseService implements SystemServiceInterfaces
{
    protected $systemRepositories;

    public function __construct(SystemRepositories $systemRepositories) {
        $this->systemRepositories = $systemRepositories;
        parent::__construct();
    }
    public function create($request,$language_id) {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token'])['config'];
            $this->createSystemCongfig($data , $language_id);
           
          
            DB::commit();
            return true;
        } catch (Exception $e) {
            // DB::rollBack();
            echo new Exception($e->getMessage()); die();
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

    private function createSystemCongfig(array $data = [] , int $language_id = 0) {
        $payload = [];
        foreach($data as $key => $val) {
            $payload = [
                'keyword' => $key,
                'content' => $val
            ];
                 
            $this->systemRepositories->updateOrInsert(
                [
                    // 'languages_id' => $this->languageRepositories->getCurrentLanguage()->id,
                    'keyword' => $key,
                    'languages_id' => $language_id
                ],
                $payload,
            );
        }

    }

}
