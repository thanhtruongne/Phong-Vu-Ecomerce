<?php
 namespace App\Repositories;

use App\Models\Widget;
use App\Repositories\Interfaces\WidgetRepositoriesInterfaces;
 class WidgetRepositories extends BaseRepositories implements WidgetRepositoriesInterfaces  {
    
    public function __construct(Widget $model)
    {
        $this->model = $model;
    }

    public function getWidgetByKeyWord(array $whereIn = [] , string $whereColumn = 'keyword') {
        return $this->model->where('status','=',1)
        ->whereIn($whereColumn,$whereIn)
        ->orderByRaw("FIELD(".$whereColumn.",'".implode("','",$whereIn)."')")
        ->get();
    }
 }