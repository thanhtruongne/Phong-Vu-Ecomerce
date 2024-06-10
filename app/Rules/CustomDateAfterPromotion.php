<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomDateAfterPromotion implements ValidationRule
{
    protected $startDate;
    public function __construct($startDate) {
          $this->startDate = $startDate;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       
        $beginDate = Carbon::createFromFormat('d/m/Y H:i',$this->startDate);
        $endDate = Carbon::createFromFormat('d/m/Y H:i',$value);
        if( $endDate->greaterThan($beginDate) !== true) {
            $fail('Ngày kết thúc phải lớn hơn ngày bắt đầu');
        }
    }
}
