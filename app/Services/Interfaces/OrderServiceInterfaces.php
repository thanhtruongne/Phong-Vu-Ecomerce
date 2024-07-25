<?php 

namespace App\Services\Interfaces;

interface OrderServiceInterfaces {

  public function paginate($request,string $is_cancel = 'no');

  public function updateInfo($request,string $code = '');

  public function updateAfterPayment($order,$payload,string $paymentMethod = '');

  public function updateMethod($payload,string $code = '');

  public function cancel(string $code = '');

}