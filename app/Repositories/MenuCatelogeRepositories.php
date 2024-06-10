<?php
namespace App\Repositories;

use App\Models\MenuCateloge;
use App\Repositories\Interfaces\MenuCatelogeRepositoriesInterfaces;

 class MenuCatelogeRepositories extends BaseRepositories implements MenuCatelogeRepositoriesInterfaces  {
    
    public function __construct(MenuCateloge $model)
    {
        $this->model = $model;
    }

  
 }