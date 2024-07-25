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
    public $routerRepositories;

   public function __construct() {
       $this->routerRepositories = resolve(RouterRepositories::class);
   }
 
    public function formatRouterPayload($canonical , $model , $controllerName) {
        $router =  [
            'canonical' => Str::slug($canonical),
            'module_id' => $model->id,
            'controller' => 'App\Http\Controllers\FrontEnd\\'.$controllerName,
        ];
        return $router;
    }

    public function createRouter($canonical , $model , $controllerName) {
        $router = $this->formatRouterPayload($canonical , $model , $controllerName);
        return $this->routerRepositories->create($router);
    }

    public function updateRouter($canonical , $model , $controllerName ) {
        $payload = $this->formatRouterPayload($canonical , $model , $controllerName);
        $condition = [
           [ 'module_id', '=' , $model->id],
           [ 'controller', '=' ,'App\Http\Controllers\FrontEnd\\'.$controllerName],
        ];  
        $find = $this->routerRepositories->findCondition($condition);
        $response = $this->routerRepositories->update( $find->id , $payload );
        return $response;
    }

    public function deleteRouter($model , $controllerName) {
        $condition = [
           [ 'module_id', '=' , $model->id],
           [ 'controller', '=' , 'App\Http\Controllers\FrontEnd\\'.$controllerName],
        ];  
        return $this->routerRepositories->deleteByCondition($condition);   
    }
     
}
