<?php 

namespace App\Services\Interfaces;

interface MenuServiceInterfaces {
    public function paginate($request);

    public function create($request , int $language_id = 1);

    public function saveChildren($request , $language_id);
    public function SaveTheNestedTableListDynamic(array $json = [] , int $language_id = 1 ,int $parent_id = 0 ,int $menu_cateloge_id = 0);

    public function destroy($id);

    public function update(int $id ,$request);
}