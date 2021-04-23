<?php

namespace App\Modules\Categories\Rules;

use App\Modules\Categories\Models\Category;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 * Checks for domain name
 *
 * @package App\Rules
 */
class AvailableToChooseCategory implements Rule
{
    
    /**
     * @var Category
     */
    private $category;
    
    /**
     * AvailableToChooseCategory constructor.
     *
     * @param Category|Model $category
     */
    public function __construct(Model $category)
    {
        $this->category = $category;
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Category::isAvailableToChoose($this->category->id, $value);
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('categories::general.validation');
    }
}
