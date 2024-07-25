<?php 

namespace App\Services\Interfaces;

interface BaseServiceInterfaces {
    public function formatRouterPayload($canonical , $model , $controllerName);

    public function createRouter($canonical , $model , $controllerName);

    public function updateRouter($canonical , $model , $controllerName);

    public function deleteRouter($model , $controllerName);

}