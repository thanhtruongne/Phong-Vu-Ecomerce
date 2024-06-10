<?php 

namespace App\Repositories\Interfaces;

interface MenuRepositoriesInterfaces {

    public function createMenuChildrenByNode(int $id = 0 , $parent);
}