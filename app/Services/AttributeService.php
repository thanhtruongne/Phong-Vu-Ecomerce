<?php
namespace App\Services;

use App\Models\AttributeCataloge;
use App\Repositories\RouterRepositories;
use App\Repositories\AttributeRepositories;
use App\Services\Interfaces\AttributeServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AttributeService extends BaseService implements AttributeServiceInterfaces
{
    protected $attributeRepositories;

    public function __construct(
        AttributeRepositories $attributeRepositories, 
        ) {
        $this->attributeRepositories = $attributeRepositories;
        parent::__construct();
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 6;
        if($request->has('status')){
            $condition['where'] = [
                ['status','=',$request->status],
              ];
        }
      

        $attribute = $this->attributeRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [],
        $record,
        $this->getPaginateIndex(),
        [],[],$this->whereRawCondition($request) ?? []
        );
        // dd($post);
       return $attribute;
    }


    public function create($request) {
        DB::beginTransaction();
        try {
            $attribute = $this->createAttributeService($request);
            if($attribute->id > 0)  {
                // $this->createTranslatePivotAttributeService($request,$attribute);
                $this->createRouter(
                    $request->input('canonical'),
                    $attribute,
                    'AttributeController',
                );
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            // DB::rollBack();
            echo new Exception($e->getMessage()); die();
            // return false;
        }
    }

    public function update(int $id ,$request) {
        DB::beginTransaction();
        try {
            $attribute = $this->attributeRepositories->findByid($id); 
            $check = $this->updateAttributeService($request,$attribute);
            if($check == true) {
                $attribute->attribute_cateloge_attribute()->detach();
                $this->updateAttributeCatalogeAttributeService($request,$attribute);
                $this->updateRouter(
                    $request->input('canonical'),
                    $attribute,
                    'AttributeController',
                );
            }
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
            $this->attributeRepositories->update($request['id'], $status );  
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
          $this->attributeRepositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->attributeRepositories->deleteSoft($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    
    private function handleAttributeCataloge($request) {
        return array_unique(array_merge($request->categories_sublist,[$request->attribute_cateloge_id]));
    }

    private function requestOnlyAttributeCataloge() {
        return ['follow','status','image','attribute_cateloge_id','name','desc','content','meta_title','meta_desc','meta_keyword','canonical'];
    }
    private function requestOnlyAttributeCatalogeTranslate() {
        return [];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.attribute_id','pcp.attribute_cateloge_id'];
        return ['name','image','status','id','attribute_cateloge_id'];
    }

    private function whereRawCondition($request) {
        if($request->integer('categories') > 0 && $request->input('categories') != 'none' ) {
            return [
                [
                    'attribute_cateloge_id IN (
                        SELECT id  FROM attribute_cateloge 
                        WHERE `LEFT` >= (SELECT `LEFT` from attribute_cateloge as cat  where cat.id = ?)
                        AND `RIGHT` <= (SELECT `RIGHT` from attribute_cateloge as cat  where cat.id = ?)
                    )',
                    [$request->integer('categories'),$request->integer('categories')]
                ]
            ];
        }
    }

    private function createAttributeService($request) {
        $data = $request->only($this->requestOnlyAttributeCataloge());
        $data['album'] = json_encode($request->input('album')) ?? ' ';

        $attribute = $this->attributeRepositories->create($data); 
        $this->updateAttributeCatalogeAttributeService($request,$attribute);
        return $attribute;
    }

    
    private function updateAttributeService($request,$attribute) {
        $data = $request->only($this->requestOnlyAttributeCataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? $attribute->album;
        $check = $this->attributeRepositories->update($attribute->id,$data);
        return $check;
    }

    private function updateAttributeCatalogeAttributeService($request,$attribute) {   
        $catalogeSublist = $this->handleAttributeCataloge($request); 
        $attribute->attribute_cateloge_attribute()->sync($catalogeSublist);
    }
}
