<?php

namespace App\Rules\Field;

use Illuminate\Contracts\Validation\Rule;

class Email implements Rule
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
        $domain = substr(strrchr($value, "@"), 1);

        return checkdnsrr($domain, 'ANY');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must use a valid domain.';
    }
}
