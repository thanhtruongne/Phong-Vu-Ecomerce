<?php
 namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoriesInterfaces;
use Exception;


 class UserRepositories extends BaseRepositories implements UserRepositoriesInterfaces {
  public function __construct(User $model){
    $this->model = $model;
  } 
 }