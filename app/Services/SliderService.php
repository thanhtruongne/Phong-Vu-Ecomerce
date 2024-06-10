<?php

namespace App\Services;

use App\Repositories\LanguageRepositories;
use App\Repositories\RouterRepositories;
use App\Repositories\SliderRepositories;
use App\Services\Interfaces\SliderServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class SliderService extends BaseService implements SliderServiceInterfaces
{
    protected $sliderRepositories,$languageRepositories;

    public function __construct(
         SliderRepositories $sliderRepositories,
         LanguageRepositories $languageRepositories,
         RouterRepositories $routerRepositories
         ) {
        $this->sliderRepositories = $sliderRepositories;
        $this->languageRepositories = $languageRepositories;
        parent::__construct($routerRepositories);
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $condition['status'] = +$request->status ?? 1;
        $record = $request->input('record') ?: 6;
        $slider = $this->sliderRepositories->paganation(
        ['*'],
        $condition,[],$record,[],[],[],[]
        );
        // dd($slider);
       return $slider;
    }


    public function create($request , string $language_id = 'vn' ) {
        DB::beginTransaction();
        try {
            $payload = $request->only(['name','keyword','setting','short_code']);
            $payload['setting'] = json_encode($payload['setting']);
            $payload['item'] = json_encode($this->FormatJsonSlide($request   , $language_id));
            $this->sliderRepositories->create($payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage()); die();
            return false;
        }
    }

    private function FormatJsonSlide($request , $language) {
        $slides = $request->input('slide');
        $data = [];
        // dd($slides['thumbnail']);
        foreach($slides['thumbnail'] as $key => $val) {
            $data[] = [  
                'language' => $language,
                'thumbnail' => $val ?? '',
                'desc' => $slides['desc'][$key] ?? '',
                'canonical' => $slides['canonical'][$key] ?? '',
                'window' => $slides['window'][$key] ?? 'off',
                'directional' => $slides['directional'][$key] ?? 'dots',
                'name' => $slides['name'][$key] ?? '',
                'alt' => $slides['alt'][$key] ?? '',
                'random_class' => $slides['random_class'][$key] ?? '',
            ];
        }
        return $data;
    }



    public function update(int $id ,$request , string $language_id = 'vn')  {
        DB::beginTransaction();
        try {
            $payload = $request->only(['name','keyword','setting','short_code']);
            $payload['setting'] = json_encode($payload['setting']);
            $payload['item'] = json_encode($this->FormatJsonSlide($request   , $language_id));
            $this->sliderRepositories->update($id,$payload);
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
            $this->sliderRepositories->update($request['id'], $status );  
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
          $this->sliderRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->sliderRepositories->deleteSoft($id);  
           
;            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    } 

}
