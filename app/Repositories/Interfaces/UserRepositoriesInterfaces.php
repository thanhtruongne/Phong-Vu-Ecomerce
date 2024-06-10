<?php 

namespace App\Repositories\Interfaces;

interface UserRepositoriesInterfaces {

    public function findByid(int $modeId, array $column = ['*'], array $relation = []);

    public function update(int $id, array $data);

    public function trashed();

    public function deleteForce(int $id);

    
    
}