<?php
 namespace App\Repositories;
 use App\Repositories\Interfaces\BaseRepositoriesInterfaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

 class BaseRepositories implements BaseRepositoriesInterfaces {
    protected $model;
    
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $relation = []) {
        return $this->model->with($relation)->get();
    }
    
    public function paganation
    (
        array $column = ['*'],
        array $condition = [] , 
        array $join = [],
        int $page = 12, 
        array $groupBy = ['id'],
        array $extend  = [] ,
        array $order = ['id' => 'desc'],
        //sử dụng whereRaw để truy vấn trong IN filer
        array $whereRaw = []
     ) {
        $query = $this->model->select($column)
        ->search($condition['search'] ?? null)
        ->member($condition['member'] ?? null)
        ->status($condition['status'] ?? null)
        ->wheregroup($condition['where'] ?? [])
        ->groupbyorder($groupBy ?? [])
        ->extend($extend  ?? null)
        ->joinquery($join ?? [])
        ->rawquery($whereRaw ?? null)
        ->orderbyinput($order ?? [])
        ->paginate($page);
         
        return $query;



        // ->where(function($query) use ($condition){
        //     if(isset($condition['member']) && !empty($condition['member'])) {
        //         $query->where('role','=',$condition['member']);
        //     }
        //     if(isset($condition['status']) && $condition['status'] != 'all') {
        //         $query->where('status','=',$condition['status']);
        //     }  
        //     if(isset($condition['where']) && $condition['where'] != 'all') {
        //         foreach($condition['where'] as $item) {
        //             $query->where($item[0],$item[1],$item[2]);
        //         }
        //     }  
        //     if(isset($condition['search']) && !empty($condition['search'])) {
        //         $query->where($condition['search'][0],'LIKE','%'.$condition['search'][1].'%');
        //     }
        //     if(isset($condition['search']) &&  !empty($condition['member']) && !empty($condition['search'])) {
        //         $columns = ['name', 'email', 'address','phone'];
        //         foreach($columns as $column) {
        //             $query->orWhere([[$column,'LIKE','%'.$condition['search'].'%'],['role','=',$condition['member']]]);
        //         }
        //     }                  
        //     return $query;
        // });
        // if(!empty($groupBy) && isset($groupBy)) {
        //     $query->groupBy($groupBy);
        // }
        // if(isset($whereRaw) && !empty($whereRaw)) {
        //    foreach($whereRaw as $key =>  $raw) {
        //       $query->whereRaw($raw[0],$raw[1]);
        //    }
        // }
        // if(isset($extend) && !empty($extend)){
        //     foreach($extend as $relations) {
        //         $query->withCount($relations);
        //     }
        // }
        // if(!empty($join) && is_array($join))  {
        //     foreach($join as $key => $val) {
        //         $query->join($val[0],$val[1],$val[2],$val[3]);
        //     }
        // } 

        // if(!empty($order) && is_array($order)) {
        //     foreach($order as $key => $ordered) {
        //        $query->orderBy($key,$ordered);
        //     }
        // }
        // return $query->paginate($page);
    }


    // hàm find dựa theo id và relation;
    public function findByid(int $modeId, array $column = ['*'], array $relation = []) {
        return $this->model->select($column)->with($relation)->find($modeId);
    }

    

    public function findCondition(
        array $condition = [],
        array $params = [],
        array $relation = [],
        string $type = 'first',
        array $withCount = []
        ) {
        $query = $this->model->newQuery();
        $query->with($relation);
        foreach($condition as $val) {
            $query->where($val[0],$val[1],$val[2]);
        }
        if(isset($params['whereIn'])) {
           $query->whereIn($params['whereIn'],$params['whereValues']);
        }
        if($type == 'first') return $query->first();
        else return $query->get();
    }

    

    public function findByModelWhereHas(
        array $select = [],
        array $condition = [],
        string $TableRelation = '' ,
        string $relationTranslate = '',
        string $relation = '',
        string $export = 'single',
        bool $type = true)  {
        $query = $this->model->select($select)->with($relationTranslate);
        $query->whereHas($relation , function($query) use($condition , $type ,$TableRelation) {
             if($type == true) {
                foreach($condition as $key => $val){
                    $query->where($TableRelation.'.'.$val[0],$val[1],$val[2]);
                }
             }
             else {
                foreach($condition as $key => $val){
                    $query->where($TableRelation.$key,$val);
                }
            }
        });
        if($export == 'single') return $query->first();
        else return $query->get();
    }

    public function deleteByCondition(array $condition = []) {
        $query = $this->model->newQuery();
        foreach($condition as $val) {
            $query->where($val[0],$val[1],$val[2]);
        }
        return $query->forceDelete();
    }

    public function findOnlyTrashedById(int $modeId, array $column = ['*'], array $relation = []) {
        return $this->model->withTrashed()->select($column)->with($relation)->findOrFail($modeId);
    }

    public function create(array $data) {
        $model = $this->model->create($data);   
        return $model->fresh();
       
    }

    public function updateOrInsert(array $condition = [] , array $payload = []) {
        return $this->model->updateOrInsert($condition, $payload);
    }

    public function createByInsert(array $data = []) {
        return $this->model->insert($data);
    }

    //language
    public function createTranslatePivot($model , array $data = [],string $relation = '') {
        return $model->{$relation}()->attach($model->id,$data);
    }

    public function update(int $id,array $data) {
        $model = $this->findByid($id);  
        return $model->update($data);
    }

    public function UpdateByWhereIn(array $id = [],string $column, array $payload = []) {
        return $this->model->whereIn($column,$id)->update($payload);
    }

    public function UpdateWhere(array $condition = [], array $payload = []) {
        $query = $this->model->newQuery();
        foreach($condition as $key => $val) {
            $query->where($val[0],$val[1],$val[2]);
        }
        $query->update($payload);
    }
 
    public function deleteSoft(int $id) {
        $model = $this->findByid($id);
        return  $model->delete();
        
    }

    public function trashed() {
        return $this->model->onlyTrashed()->paginate(12);
    }
    public function deleteForce(int $id) {
        $data = $this->findOnlyTrashedById($id);
        return $data->forceDelete();
    }

    public function restore(int $id) {
        $user = $this->findOnlyTrashedById($id);
        return $user->restore();
    }


    //nested set
    public function createCategoriesByNode(array $data = [] , $parent) {
        if($data['categories_id'] && $data['categories_id'] != 'none') {
            $node = $this->model->find($data['categories_id']);
            $node->appendNode($parent);
        }
    }

    public function UpdateCategoriesByNode(int $id,array $data = []) {
        // dd($data);
        $node = $this->model->find($id);
        $node->name = $data['name'];
        $node->parent = $data['categories_id'];
        $node->save();
    }

    public function getAllCategories() {
        return $this->model->withDepth()->reversed()->with('ancestors')->get()->toFlatTree();
    }

    public function CheckNodeChildrenDestroy(int $id) {
        $check = $this->model->findOrFail($id);
        if(!$check) return false;
        if($check->RIGHT - $check->LEFT !== 1 ) {
            return false; 
        }
        
        return true;
    }


    public function recursiveCategory(string $params = '' , string $table = '') {
        $table = $table.'_cateloge';
        // sử dụng mysql để đệ quy câu truy vấn giúp tối ưu phần truy vấn trong server
        $query = "
            WITH RECURSIVE category_some AS (
                    SELECT id, parent, deleted_at from $table 
                    WHERE id IN ($params) AND deleted_at IS NULL
                UNION ALL
                    SELECT custom.id,custom.parent,custom.deleted_at FROM $table as custom 
                    JOIN category_some as cs ON custom.parent = cs.id
            )
            SELECT id  FROM category_some WHERE deleted_at IS NULL";
        $object = DB::select($query);
        return $object;
    }

    public function findObjectCategoryID(array $id = [] , string $model = '') {
        return $this->model->where('status',1)
        ->join($model.'_cateloge_'.$model.' as pctp' ,'pctp.'.$model.'_id' , '=',$model.'.id')
        ->whereIn('pctp.'.$model.'_cateloge_id',$id)
        ->orderBy('order','desc')
        ->get();
    }

 }