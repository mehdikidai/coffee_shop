<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MustBeLessThan implements ValidationRule
{


    private $input ;


    public function __construct($input){
         $this->input = $input;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $stock = request()->input($this->input);

        if (!is_numeric($stock) || !is_numeric($value)) {
            $fail("The provided values are invalid.");
            return;
        }

        if ($value >= $stock) {
            $fail("The threshold must be less than the stock quantity.");
        }
    }
}
