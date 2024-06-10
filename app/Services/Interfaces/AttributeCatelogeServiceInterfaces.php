<?php
namespace App\Services\Interfaces;

interface AttributeCatelogeServiceInterfaces {
    public function paginate($request);

    public function create($request);

    public function destroy($id);

    public function update(int $id ,$request);

    public function restore(int $id);

    public function deleteForce(int $id);
}