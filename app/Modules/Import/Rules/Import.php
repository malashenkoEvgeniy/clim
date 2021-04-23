<?php

namespace App\Modules\Import\Rules;

use App\Components\Parsers\PromUa\Parser;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class Extension
 *
 * @package App\Modules\Import\Rules
 */
class Import implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function passes($attribute, $value)
    {
        return count(Parser::validate(request()->file('import'))) === 0;
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('import::admin.validation.import');
    }
}
