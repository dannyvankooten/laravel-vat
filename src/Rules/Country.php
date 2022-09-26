<?php

namespace DvK\Laravel\Vat\Rules;

use Illuminate\Contracts\Validation\Rule;
use DvK\Laravel\Vat\Facades\Countries;

class Country implements Rule
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
        $countries = new Countries();
        return isset($countries[$value]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute must be a valid country.');
    }
}
