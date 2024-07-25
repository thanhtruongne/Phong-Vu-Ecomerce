<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
class CustomValidateEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $validator = new EmailValidator();
        // $multipleValidations = new MultipleValidationWithAnd([
        //     new RFCValidation(),
        //     new DNSCheckValidation()
        // ]);
        // //ietf.org has MX records signaling a server with email capabilities
        // dd($validator->isValid($value, $multipleValidations)); //true
        if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$value)) {
            $fail('Email không hợp lệ !');
        }
    }
}
