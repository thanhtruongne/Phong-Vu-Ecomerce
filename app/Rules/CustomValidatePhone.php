<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomValidatePhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if(!preg_match("/(84|0[3|5|7|8|9])+([0-9]{8})\b/",$value)) {
            $fail('Số điện thoại không hợp lệ !');
        } 
    }
}
