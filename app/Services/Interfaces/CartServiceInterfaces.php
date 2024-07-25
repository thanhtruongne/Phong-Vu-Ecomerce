<?php 

namespace App\Services\Interfaces;

interface CartServiceInterfaces {
   public function add($data);

   public function removeItem(string $rowId);

   public function updateQty($request);

   public function clearAllCart();

   public function createOrder($request);
}