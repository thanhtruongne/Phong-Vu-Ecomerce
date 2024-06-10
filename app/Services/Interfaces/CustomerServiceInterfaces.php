<?php 

namespace App\Services\Interfaces;

interface CustomerServiceInterfaces {
    public function paginate($request);

    public function create($data);

    public function update(int $id,$data);

    public function deleteSoft(int $id);

    public function trashed();

    public function deleteForce(int $id);

    public function changeStatus(array $data) ;

    public function ChangeStatusAll(array $data);

    public function restoreUser(int $id);
}