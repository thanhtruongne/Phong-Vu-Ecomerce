<?php 

namespace App\Services\Interfaces;

interface MenuServiceInterfaces {
    public function paginate($request);

    public function create($request);

    public function saveChildren($request);
    public function SaveTheNestedTableListDynamic(array $json = [] , $parent_id = null ,int $menu_cateloge_id = 0);

    public function destroy($id);

    public function update(int $id ,$request);
}