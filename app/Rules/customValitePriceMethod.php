<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class customValitePriceMethod implements ValidationRule
{
    protected $method;

    public function __construct($method){
        $this->method = $method;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {     
        if($this->method == 'momo' && +$value > 3000000){
            $fail('Số tiền vượt hạn mức thanh toán của Momo');
        }
        if($this->method == 'cod' && +$value >= 5000000) {
            $fail('Số tiền vượt hạn mức thanh toán COD của cửa hàng !!!');
        }

    }
}
