
namespace App\Services;

use App\Models\{module_class}Cataloge;
use App\Repositories\RouterRepositories;
use App\Repositories\LanguageRepositories;
use App\Repositories\{module_class}Repositories;
use App\Services\Interfaces\{module_class}ServiceInterfaces;
use App\Trait\UploadImage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class {module_class}Service extends BaseService implements {module_class}ServiceInterfaces
{
    protected ${module}Repositories,$languageRepositories;

    public function __construct(
        {module_class}Repositories ${module}Repositories, 
        LanguageRepositories $languageRepositories,
        RouterRepositories $routerRepositories,
        ) {
        $this->{module}Repositories = ${module}Repositories;
        $this->languageRepositories = $languageRepositories;
        parent::__construct($routerRepositories);
    }
    public function paginate($request) 
    {
        $condition = [];
        $condition['search'] = $request->search ?? '';
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
          ['pct.language_id' ,'=',$this->languageRepositories->getCurrentLanguage()->id], 
          ['status','=',$request->status ?? 1],
        ];

        ${module} = $this->{module}Repositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
            ['{module}_translate as pct' , 'pct.{module}_id','=','{module}.id'],
            ['{module}_cataloge_{module} as pcsp','{module}.id','=','pcsp.{module}_id'],
           
        ],
        $record,
        $this->getPaginateIndex(),
        [],[],$this->whereRawCondition($request) ?? []
        );
        // dd($post);
       return ${module};
    }


    public function create($request) {
        DB::beginTransaction();
        try {
            ${module} = $this->create{module_class}Service($request);
            if(${module}->id > 0) $this->createTranslatePivot{module_class}Service($request,${module});
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
            ${module} = $this->{module}Repositories->findByid($id); 
            $check = $this->update{module_class}Service($request,${module});
            if($check == true) $this->update{module}Service($request,${module});
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
            $this->{module}Repositories->update($request['id'], $status );  
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
          $this->{module}Repositories->UpdateByWhereIn($data['id'],'id',$status) ;

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
            $this->{module}Repositories->deleteSoft($id);  
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
            $this->{module}Repositories->restore($id);  
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
            $this->{module}Repositories->deleteForce($id);  
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    
    private function handle{module_class}Cataloge($request) {
        return array_unique(array_merge($request->categories_sublist,[$request->{module}_cateloge_id]));
    }

    private function requestOnly{module_class}Cataloge() {
        return ['follow','status','image','{module}_cateloge_id','album'];
    }
    private function requestOnly{module_class}CatalogeTranslate() {
        return ['language_id','name','desc','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.{module}_id','pcp.{module}_cateloge_id'];
        return ['pct.name','{module}.image','{module}.status','{module}.id','{module}.{module}_cateloge_id'];
    }

    private function whereRawCondition($request) {
        if($request->integer('categories') > 0 && $request->input('categories') != 'none' ) {
            return [
                [
                    'pcsp.{module}_cateloge_id IN (
                        SELECT pc.id  FROM categories inner join  {module}_cataloge as pc on pc.categories_id = categories.id 
                        WHERE `LEFT` >= (SELECT `LEFT` from categories as cat  where cat.id = ?)
                        AND `RIGHT` <= (SELECT `RIGHT` from categories as cat  where cat.id = ?)
                    )',
                    [$request->integer('categories'),$request->integer('categories')]
                ]
            ];
        }
    }

    private function create{module_class}Service($request) {
        $data = $request->only($this->requestOnly{module_class}Cataloge());
        $data['album'] = json_encode($data['album']);
        $data['user_id'] = Auth::user()->id;
        ${module} = $this->{module}Repositories->create($data);  
        return ${module};
    }

    private function createTranslatePivot{module_class}Service($request,${module}) {
        $payloadTranslate = $request->only($this->requestOnly{module_class}CatalogeTranslate());
        $payloadTranslate['language_id'] = 1;
        $payloadTranslate['{module}_id'] = ${module}->id;
        $translate = $this->{module}Repositories->createTranslatePivot(${module},$payloadTranslate,'languages');
        $catalogeSublist = $this->handle{module_class}Cataloge($request); 
        ${module}->{module}_cataloge_{module}()->sync($catalogeSublist);
    }
    
    private function update{module_class}Service($request,${module}) {
        $data = $request->only($this->requestOnly{module_class}Cataloge()); 
        $data['album'] = json_encode($request->input('album')) ?? ${module}->album;
        $data['user_id'] = Auth::user()->id;
        $check = $this->{module}Repositories->update(${module}->id,$data);
        return $check;
    }

    private function update{module_class}Cataloge{module_class}Service($request,${module}) {
        $payloadTranslate = $request->only($this->requestOnly{module_class}CatalogeTranslate());
        $payloadTranslate['language_id'] = 1;
        $payloadTranslate['{module}_id'] = ${module}->id;
        // tách ra khỏi bảng trung gian
        $detach = ${module}->languages()->detach([ $payloadTranslate['language_id'],${module}->id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->{module}Repositories->createTranslatePivot(${module},$payloadTranslate,'languages'); 
        $catalogeSublist = $this->handle{module_class}Cataloge($request); 
        ${module}->{module}_cataloge_{module}()->sync($catalogeSublist);
    }
}
