<?php 

namespace App\Services\Interfaces;

interface CustomerCatelogeServiceInterfaces {
    public function paginate($request);

    public function create($request);

    public function update(int $id ,$request);
}