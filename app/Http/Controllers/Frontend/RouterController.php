<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\RouterRepositories;
use Illuminate\Http\Request;

class RouterController extends BaseController
{  
     protected $routerRepositories;
    // protected $language;
    public function __construct(RouterRepositories $routerRepositories)
   {
     $this->routerRepositories = $routerRepositories;
     parent::__construct();
   }
   

   // Tạo Router Dynmaic By Router trong database render đến các trang thông qua controller và model
   public function index(string $canonical = '',Request $request) {
        $router = $this->routerRepositories->findCondition([
            ['canonical','=',$canonical],
        ],[],[],'first',[]);
        if(!is_null($router) && !empty($router)) {
            $suffixIndex = 'index';

            return app($router->controller)->{$suffixIndex}($router->module_id, $request , null);         
        }
   }


   public function detail(string $canonical = '',string $slug = '',Request $request) {
    $router = $this->routerRepositories->findCondition([
        ['canonical','=',$canonical],
    ],[],[],'first',[]);

    if(!is_null($router) && !empty($router)) {
        $suffixIndex = 'index'; 
        return app($router->controller)->{$suffixIndex}($router->module_id, $request ,$slug);         
    }
}

}
