<?php

namespace App\Modules\Brands\Rules;

use App\Modules\Brands\Models\Brand;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class Domain
 * Checks for domain name
 *
 * @package App\Rules
 */
class IsBrand implements Rule
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
        return Brand::whereId($value)->exists();
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('brands::general.validation');
    }
}
