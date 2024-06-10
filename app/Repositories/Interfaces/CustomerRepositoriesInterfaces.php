<?php 

namespace App\Repositories\Interfaces;

interface CustomerRepositoriesInterfaces {

    public function findByid(int $modeId, array $column = ['*'], array $relation = []);

    public function update(int $id, array $data);

    public function trashed();

    public function deleteForce(int $id);

    
    
}