<?php 
namespace App\Trait;

use Carbon\Carbon;
use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\File;

trait QueryScopes {
    public function scopeSearch($query,$search,array $data = []) {
        if(!empty($search) && $search != '' && !empty($data) && count($data) > 0) {  
           foreach($data as $field) {
            $query->orWhere($field,'LIKE','%'.$search.'%');
           }
        }
        else if(!empty($search)) {
            $query->where('name','LIKE','%'.$search.'%');
        }
        return $query;
    }

    public function scopeWhereAddress($query,$data) {
        if(!empty($data) && count($data) > 0) {  
            foreach($data as $field) {
                if(!empty($field) && $field[2] != 'none') {
                    $query->where($field[0],$field[1],$field[2]);
                }    
            }
        }
        return $query;
    }

    public function scopeWhereDate($data) {
        
    }

    public function scopeMember($query,$member) {
        if(!empty($member)) {
            $query->where('role','=',$member);
        }
        return $query;
    }
    public function scopeStatus($query,$status) {
        if(!empty($status)) {
            $query->where('status','=',$status);
        }
        return $query;
    }
    public function scopeWhereGroup($query, array $where) {
        if(!empty($where)) {
           foreach($where as $key => $val) {
               $query->where($val[0],$val[1],$val[2]);
           }
        }
        return $query;
    }

    public function scopeCustomOrder($query,array $data = []) {
        if(!empty($data) && $data != 'none') {
            foreach($data as $key => $val) {
                if(!empty($val) && $val[2] != 'none') {
                  
                    $query->where($val[0],$val[1],$val[2]);
                }             
            }
         }
         return $query;
    }
    

    public function scopeExtend($query,array $extend = []) {
        if(!empty($extend)) {
            foreach($extend as $relations) {
                $query->withCount($relations)
                      ->with($relations);
            }
        }
        return $query;
    }

    public function scopeRawQuery($query,$whereRaw  = []) {
        if(is_array($whereRaw) &&  !empty($whereRaw)) {
            foreach($whereRaw as $raw) {
                $query->whereRaw($raw[0],$raw[1]);
            }
        }
        return $query;
    }
    

    public function scopeJoinQuery($query,array $joins = []) {
   
        if(!empty($joins)) {
            foreach($joins as $join) {
                $query->join($join[0],$join[1],$join[2],$join[3]);
            }
        }
        return $query;
    }

    public function scopeWhereJoinQuery($query,array $field = []) {
   
        if(!empty($field) && $field[2] != 'none') {
            $query->where($field[0],$field[1],$field[2]);
        }
        return $query;
    }

    public function scopeWhereDateTime($query,string $data = '') {
   
        if(!empty($data) && $data != '') {
           $extract = explode('-',$data);
           $startDate = Carbon::parse($extract[0]);
           $endDate = Carbon::parse($extract[1]);
           $query->where([['created_at','>=',$startDate],['created_at','<=',$endDate]]);
        }
        return $query;
    }
       public function scopeGroupByOrder($query, $groupBy) {
        if(!empty($groupBy)) {
            $query->groupBy($groupBy);
        }
        return $query;
    }

    public function scopeOrderByInput($query,array $orderBy = []) {
        if(!empty($orderBy)) {
            foreach($orderBy as $key => $order) {
                $query->orderBy($key,$order);
            }
        }
        return $query;
    }
 

}