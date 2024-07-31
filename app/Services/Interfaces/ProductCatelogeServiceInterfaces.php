<?php
namespace App\Services\Interfaces;

interface ProductCatelogeServiceInterfaces {
    public function paginate($request);
    public function create($request);
    public function destroy($id);
    public function update(int $id ,$request);
    public function OverrideAttribute($product);
    public function filterList(array $attribute = []);
}