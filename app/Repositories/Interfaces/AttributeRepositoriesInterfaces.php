<?php
namespace App\Repositories\Interfaces;

interface AttributeRepositoriesInterfaces {

    public function getAttributeById($id , $language  = 1);

    public function searchAttribute(string $keyword = '', string $option = '');

    public function findAttributeByIdArray(array $data = []);

    public function getAttributeByWhereIn(array $id = []);

    public function findAttributeProductVariantID(array $data = [] , $productCatelogeID);
}