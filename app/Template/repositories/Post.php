
namespace App\Repositories;

use App\Models\{module_class};
use App\Repositories\Interfaces\{module_class}RepositoriesInterfaces;

 class {module_class}Repositories extends BaseRepositories implements {module_class}RepositoriesInterfaces  {
    
    public function __construct({module_class} $model)
    {
        $this->model = $model;
    }

    public function get{module_class}ById($id , $language  = 1) {
        return $this->model->select([
                            '{module}.id',
                            '{module}.image',
                            '{module}.status',
                            '{module}.follow',
                            '{module}.album',
                            '{module}.{module}_cateloge_id',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('{module}_translate as pct','pct.{module}_id','=','{module}.id')
                            ->where('pct.language_id','=',$language)
                            ->with([
                                '{module}_cataloge'
                            ])
                            ->find($id);
    }
 }