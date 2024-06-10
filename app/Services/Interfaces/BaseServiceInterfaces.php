<?php 

namespace App\Services\Interfaces;

interface BaseServiceInterfaces {
    public function formatRouterPayload($canonical , $model , $controllerName , $language_id);

    public function createRouter($canonical , $model , $controllerName , $language_id);

    public function updateRouter($canonical , $model , $controllerName , $language_id);

    public function deleteRouter($model , $controllerName , $language_id);

}