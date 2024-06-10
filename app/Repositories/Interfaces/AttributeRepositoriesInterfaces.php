<?php
namespace App\Repositories\Interfaces;

interface AttributeRepositoriesInterfaces {

    public function getAttributeById($id , $language  = 1);

    public function searchAttribute(string $keyword = '', string $option = '' , int $languageID);

    public function findAttributeByIdArray(array $data = [] , int $language_id = 1);
}