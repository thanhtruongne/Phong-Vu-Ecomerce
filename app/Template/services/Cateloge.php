
namespace App\Services;

use App\Repositories\{module_class}Repositories;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\{module_class}ServiceInterfaces;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class {module_class}Service extends BaseService implements {module_class}ServiceInterfaces
{
    protected ${module}Repositories;

    public function __construct(
        {module_class}Repositories ${module}Repositories , 
        RouterRepositories $routerRepositories,
        ) {
        $this->{module}Repositories = ${module}Repositories;
        parent::__construct($routerRepositories);
    }
    public function paginate($request) 
    {
        $condition = [];
        $record = $request->input('record') ?: 6;
        $condition['where'] = [
            ['status' ,'=', $request->status ?? 1]
        ];
        ${module} = $this->{module}Repositories->paganation(
        $this->getPaginateIndex(),
        $condition,
        //sử dụng mảng 4 để load join vào table
        [
           [ '{module_pivot}_cateloge_translate as pct' , 'pct.{module_pivot}_cateloge_id','=','{module_pivot}.id']
        ],
        $record,[],[],[],[]
        
        );
       return ${module};
    }
    

    public function create($request) {
        DB::beginTransaction();
        try {
            ${module} = $this->create{module_class}Index($request);
            //đồng thời tạo phân quyền role cho nhóm người dùng mới
           
            if(${module}->id > 0) {
                $this->createTranslate{module_class}Pivot($request,${module}); 
            }      
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
            ${module} = $this->{module_class}Repositories->findByid($id); 
            $check = $this->update{module_class}($request,${module});
            if($check == true) $this->updateTranslate{module_class}Pivot($id,${module},$request);         
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo new Exception($e->getMessage());
            return false;
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

    private function requestOnly{module_class}() {
        return ['follow','status','image','album'];
    }

    private function create{module_class}Index($request) {
        $data = $request->only($this->requestOnly{module_class}());
        //tạo nested set
        $category =  $this->categoriesrReposiroties->createCategoriesByNode($request->only($this->createCategoriesNode()));
        $data['album'] = !empty($request->input('album') ? json_encode($request->input('album')) : '') ;
        $data['user_id'] = Auth::user()->id;
        $data['categories_id'] = $category->id;
        ${module} = $this->{module}Repositories->create($data);
        return ${module};
    }
    

    private function createTranslate{module_class}Pivot($request,${module}) {
        $payloadTranslate = $request->only($this->requestOnly{module_class}Translate());
        $payloadTranslate['meta_link'] = Str::slug($payloadTranslate['meta_link']);
        $payloadTranslate['languages_id'] = 1;
        $payloadTranslate['{module_pivot}_cateloge_id'] = ${module}->id;
        $this->{module}Repositories->createTranslatePivot(${module},$payloadTranslate,'languages'); 
    }

    private function update{module_class}($request,${module}) {
        $data = $request->only($this->requestOnly{module_class}());
        $data['user_id'] = Auth::user()->id;
        $data['album'] = json_encode($request->input('album')) ?? ${module}->album;
        $check = $this->{module}Repositories->update(${module}->id,$data);
        return $check;
    }

    private function updateTranslate{module_class}Pivot($id,${module},$request) {
        $payloadTranslate = $request->only($this->requestOnly{module_class}Translate());
        $payloadTranslate['languages_id'] = 1;
        $payloadTranslate['{module_pivot}_cateloge_id'] = $id;
        // tách ra khỏi bảng trung gian
        $detach = ${module}->languages()->detach([ $payloadTranslate['languages_id'],$id]);
        // tạo bảng mới trug gian ghi đè 
        $translate = $this->{module}Repositories->createTranslatePivot(${module},$payloadTranslate,'languages'); 
    }

    private function createCategoriesNode() {
        return ['categories_id','name'];
    }
    private function requestOnly{module_class}Translate() {
        return ['name','desc','content','meta_title','meta_desc','meta_keyword','meta_link'];
    }

    private function getPaginateIndex() {
        // return ['status','image','pct.name','id','pcp.post_id','pcp.post_catelogues_id'];
        return ['pct.name','{module_pivot}_cateloge.image','{module_pivot}_cateloge.status','{module_pivot}_cateloge.id'];
    }
}
