<?php 

namespace App\Services\Interfaces;

interface SliderServiceInterfaces {
    public function paginate($request);

    public function create($request);

    public function destroy($id);

    public function update(int $id ,$request);
}