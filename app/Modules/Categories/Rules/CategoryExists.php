<?php

namespace App\Modules\Categories\Rules;

use App\Modules\Categories\Models\Category;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class CategoryExists
 *
 * @package App\Modules\Categories\Rules
 */
class CategoryExists implements Rule
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
        return Category::whereId($value)->exists();
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('categories::general.category-does-not-exist');
    }
    
}
