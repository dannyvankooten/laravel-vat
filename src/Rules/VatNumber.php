<?php

namespace DvK\Laravel\Vat\Rules;

use Illuminate\Contracts\Validation\Rule;
use DvK\Laravel\Vat\Facades\Validator;

class VatNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Validator::validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute must be a valid VAT number.');
    }
}