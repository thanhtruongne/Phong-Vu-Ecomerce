<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomValidateOrderGHTK implements ValidationRule
{
    protected $pick_money,$total,$shipcost;

    public function __construct($pick_money,$total,$shipcost) {
        $this->pick_money = $pick_money;
        $this->total = $total;
        $this->shipcost = $shipcost;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == 0 &&  $this->pick_money > ( $this->total +  $this->shipcost))  $fail('Tiền COD có lớn hơn số tiền trên đơn !!!');
        
        if($value == 0 &&  $this->pick_money < ( $this->total +  $this->shipcost))  $fail('Tiền COD có nhỏ hơn số tiền trên đơn !!!');
    }
}
