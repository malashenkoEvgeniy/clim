<?php

namespace App\Modules\Import\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class Extension
 *
 * @package App\Modules\Import\Rules
 */
class Extension implements Rule
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
        return in_array(request()->file('import')->getClientOriginalExtension(), ['xls', 'xlsx']);
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('import::admin.validation.extension');
    }
}
