<?php 

namespace App\Repositories\Interfaces;

use Flasher\Laravel\Http\Request;

interface BaseRepositoriesInterfaces {
   public function all(array $relation = []);

   public function paganation(array $column = ['*'],array $condition = [] , array $join = [],int $page = 12,  array $groupBy = [] , array $extend = [],array $order = [], array $whereRaw = []);

   public function UpdateWhere(array $condition = [], array $payload = []);
   
   public function findByid(int $modeId,array $column=['*'],array $relation = []);

   public function findOnlyTrashedById(int $modeId, array $column = ['*'], array $relation = []);

   public function create(array $data);

   public function updateOrInsert(array $condition = [] , array $payload = []);

   public function createByInsert(array $data = []);

   public function createTranslatePivot($model , array $data = [] ,string $relation);
  
   public function update(int $id, array $data);

   public function UpdateByWhereIn(array $id = [],string $column, array $payload = []);

   public function deleteSoft(int $id);

   public function trashed();

   public function deleteForce(int $id);

   public function restore(int $id);

   public function findCondition(array $condition = [] ,array $params = [],  array $relation = [],string $type = '', array $withCount = []);

   public function findByModelWhereHas(
   array $select = [],
   array $condition = []
   ,string $TableRelation = '' ,
   string $relationTranslate = '',
   string $relation = '',string $export = 'single',bool $type = true);

   public function deleteByCondition(array $condition = []);

   public function createCategoriesByNode(array $data = [] ,  $parent);

   public function UpdateCategoriesByNode(int $id,array $data = []);

   public function getAllCategories();

   public function CheckNodeChildrenDestroy(int $id) ;


   public function recursiveCategory(string $params = '' , string $table = '');

   public function findObjectCategoryID(array $id = [] , string $model = '');

}