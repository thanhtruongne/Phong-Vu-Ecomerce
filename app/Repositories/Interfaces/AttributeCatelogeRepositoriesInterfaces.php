<?php
namespace App\Repositories\Interfaces;

interface AttributeCatelogeRepositoriesInterfaces {

    public function getAttributeCatelogeById($id , $language  = 1);

    public function AllCateloge(int $language_id = 1);
}