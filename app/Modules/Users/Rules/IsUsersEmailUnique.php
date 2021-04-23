<?php

namespace App\Modules\Users\Rules;

use App\Modules\Users\Models\User;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class IsUsersEmailUnique
 *
 * @package App\Modules\Users\Rules
 */
class IsUsersEmailUnique implements Rule
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
        return User::whereEmail($value)->active()->count() === 0;
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique', [
            'attribute' => trans('validation.attributes.email'),
        ]);
    }
}
