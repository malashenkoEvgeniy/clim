<?php

namespace App\Rules;

use Auth, Hash;
use Illuminate\Contracts\Validation\Rule;

class CurrentPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, Auth::user()->password);
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.current_password');
    }
}
