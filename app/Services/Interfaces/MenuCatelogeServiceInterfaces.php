<?php 

namespace App\Services\Interfaces;

interface MenuCatelogeServiceInterfaces {
    public function paginate($request);

    public function create($request);
    


    public function update(int $id ,$request);

}