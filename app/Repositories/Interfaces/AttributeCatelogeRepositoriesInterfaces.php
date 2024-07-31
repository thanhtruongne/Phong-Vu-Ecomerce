<?php
namespace App\Repositories\Interfaces;

interface AttributeCatelogeRepositoriesInterfaces {

    public function getAttributeCatelogeById($id);

    public function AllCateloge(array $select = ['*']);

}