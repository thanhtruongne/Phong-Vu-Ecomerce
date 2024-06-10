
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
                            '{module}_cateloge.id',
                            '{module}_cateloge.image',
                            '{module}_cateloge.status',
                            '{module}_cateloge.follow',
                            '{module}_cateloge.album',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('{module}_cateloge_translate as pct','pct.{module}_cateloge_id','=','{moudle}_cateloge.id')
                            ->where('pct.languages_id','=',$language)
                            ->with([
                                '{module}_cateloge_translate'
                            ])
                            ->find($id);
    }

 }