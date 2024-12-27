<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
class CustomValidatePhone implements Rule
{

    public function passes($attribute, $value)
    {
        return preg_match("/(84|0[3|5|7|8|9])+([0-9]{8})\b/",$value);
    }

    public function message()
    {
        return ':attribute không hợp lệ';
    }
}
