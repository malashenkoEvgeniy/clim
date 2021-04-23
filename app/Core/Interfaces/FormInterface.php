<?php

namespace App\Core\Interfaces;

use CustomForm\Builder\Form;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface FormInterface
 *
 * @package App\Core\Interfaces
 */
interface FormInterface
{
    
    /**
     * Build form
     *
     * @param  Model|null $model
     * @return Form
     */
    public static function make(?Model $model = null): Form;
    
}
