<?php

namespace App\Services;

use App\Models\Routers;
use App\Repositories\RouterRepositories;
use App\Services\Interfaces\BaseServiceInterfaces;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class BaseService implements BaseServiceInterfaces
{
    protected $routerRepositories;

   public function __construct($routerRepo) {
       
       $this->routerRepositories = $routerRepo;
   }
 
    public function formatRouterPayload($canonical , $model , $controllerName , $language_id) {
        $router =  [
            'canonical' => Str::slug($canonical),
            'module_id' => $model->id,
            'controller' => 'app\Http\Controllers\FrontEnd\\'.$controllerName,
            'languages_id' => $language_id
        ];
        return $router;
    }

    public function createRouter($canonical , $model , $controllerName , $language_id) {
        $router = $this->formatRouterPayload($canonical , $model , $controllerName , $language_id);
        return $this->routerRepositories->create($router);
    }

    public function updateRouter($canonical , $model , $controllerName , $language_id) {
        $payload = $this->formatRouterPayload($canonical , $model , $controllerName , $language_id);
        $condition = [
           [ 'module_id', '=' , $model->id],
           [ 'languages_id', '=' , $language_id ],
           [ 'controller', '=' , 'app\Http\Controllers\FrontEnd\\'.$controllerName],
        ];  
        $find = $this->routerRepositories->findCondition($condition);
        $response = $this->routerRepositories->update( $find->id , $payload );
        return $response;
    }

    public function deleteRouter($model , $controllerName , $language_id) {
        $condition = [
           [ 'module_id', '=' , $model->id],
           [ 'languages_id', '=' , $language_id ],
           [ 'controller', '=' , 'app\Http\Controllers\FrontEnd\\'.$controllerName],
        ];  
        return $this->routerRepositories->deleteByCondition($condition);   
    }
     
}
