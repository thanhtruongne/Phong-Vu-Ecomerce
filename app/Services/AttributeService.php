<?php
namespace App\Services;

use App\Models\AttributeCataloge;
use App\Repositories\RouterRepositories;
use App\Repositories\LanguageRepositories;
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
    protected $attributeRepositories,$languageRepositories;

    public function __construct(
        AttributeRepositories $attributeRepositories, 
        LanguageRepositories $languageRepositories,
        RouterRepositories $routerRepositories,
        ) {
        $this->attributeRepositories = $attributeRepositories;
        $this->languageRepositories = $languageRepositories;
        parent::__construct($routerRepositories);
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
          ['pct.languages_id' ,'=',$this->languageRepositories->getCurrentLanguage()->id], 
          ['status','=',$request->status ?? 1],
        ];

        $attribute = $this->attributeRepositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
            ['attribute_translate as pct' , 'pct.attribute_id','=','attribute.id'],
            ['attribute_cateloge_attribute as pcsp','attribute.id','=','pcsp.attribute_id'],
           
        ],
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
                $this->createTranslatePivotAttributeService($request,$attribute);
                $this->createRouter(
                    $request->input('meta_link'),
                    $attribute,
                    'AttributeController',
                    $this->languageRepositories->getCurrentLanguage()->id
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
                $this->updateAttributeCatalogeAttributeService($request,$attribute);
                $this->updateRouter(
                    $request->input('meta_link'),
                    $attribute,
                    'AttributeController',
                    $this->languageRepositories->getCurrentLanguage()->id
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

    public function restore(int $id) {
        DB::beginTransaction();
        try {
            $this->attributeRepositories->restore($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function deleteForce(int $id) {
        DB::beginTransaction();
        try {
            $this->attributeRepositories->deleteForce($id);  
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
        return ['follow','status','image','attribute_cateloge_id'];
    }
    private function requestOnlyAttributeCatalogeTranslate() {
        return ['languages_id','name','desc','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.attribute_id','pcp.attribute_cateloge_id'];
        return ['pct.name','attribute.image','attribute.status','attribute.id','attribute.attribute_cateloge_id'];
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
        $data['user_id'] = Auth::user()->id;
        $attribute = $this->attributeRepositories->create($data);  
        return $attribute;
    }

    private function createTranslatePivotAttributeService($request,$attribute) {
        $payloadTranslate = $request->only($this->requestOnlyAttributeCatalogeTranslate());
        $payloadTranslate['languages_id'] =  $this->languageRepositories->getCurrentLanguage()->id;
        $payloadTranslate['attribute_id'] = $attribute->id;
        $translate = $this->attributeRepositories->createTranslatePivot($attribute,$payloadTranslate,'languages');
        $catalogeSublist = $this->handleAttributeCataloge($request); 
        $attribute->attribute_cateloge_attribute()->sync($catalogeSublist);
    }
    
    private function updateAttributeService($request,$attribute) {
        $data = $request->only($this->requestOnlyAttributeCataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? $attribute->album;
        $data['user_id'] = Auth::user()->id;
        $check = $this->attributeRepositories->update($attribute->id,$data);
        return $check;
    }

    private function updateAttributeCatalogeAttributeService($request,$attribute) {
        $payloadTranslate = $request->only($this->requestOnlyAttributeCatalogeTranslate());
        $payloadTranslate['languages_id'] =  $this->languageRepositories->getCurrentLanguage()->id;
        $payloadTranslate['attribute_id'] = $attribute->id;
        // tách ra khỏi bảng trung gian
        $detach = $attribute->languages()->detach([ $payloadTranslate['languages_id'],$attribute->id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->attributeRepositories->createTranslatePivot($attribute,$payloadTranslate,'languages'); 
        $catalogeSublist = $this->handleAttributeCataloge($request); 
        $attribute->attribute_cateloge_attribute()->sync($catalogeSublist);
    }
}
