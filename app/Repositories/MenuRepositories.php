<?php
 namespace App\Repositories;

use App\Models\Menu;
use App\Repositories\Interfaces\MenuRepositoriesInterfaces;
 class MenuRepositories extends BaseRepositories implements MenuRepositoriesInterfaces  {
    
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function createMenuChildrenByNode(int $id = 0 , $parent) { 
        $node = $this->model->find($id);
        return $node->appendNode($parent);
    }

    public function UpdateMenuChildrenByNode(int $id , array $data = []) { 
        $node = $this->model->find($id);
    
        $node->position = $data['position'];
        $node->parent = $data['parent'];
        return $node->save();
    }

    // public function setUpNullAllParentNode() {
    //     $node = $this->model->all();
    //     foreach($node as $item) {
    //         $item->parent = null;
    //         $item->save();
    //     }
    // }


 }