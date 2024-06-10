<?php
 namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepositoriesInterfaces;
 class SliderRepositories extends BaseRepositories implements SliderRepositoriesInterfaces  {
    
    public function __construct(Slider $model)
    {
        $this->model = $model;
    }


 }