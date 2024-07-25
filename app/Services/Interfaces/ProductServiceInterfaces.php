<?php
namespace App\Services\Interfaces;

interface ProductServiceInterfaces {
    public function paginate($request,$productCateloge,string $variant = '',string $promotion = '');

    public function create($request);

    public function destroy($id);

    public function update(int $id ,$request);

    public function restore(int $id);

    public function deleteForce(int $id);

    public function CombineArrayProductHavePromotionByWhereIn(array $id = [] , $products,string $subject = 'product');

    public function getAttribute($product); 

    public function ComplieCartService($carts);
}