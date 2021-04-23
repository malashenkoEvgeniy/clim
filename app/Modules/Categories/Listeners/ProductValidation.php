<?php

namespace App\Modules\Categories\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Modules\Categories\Rules\CategoryExists;
use Validator;

/**
 * Class SyncCategories
 *
 * @package App\Modules\Categories\Listeners
 */
class ProductValidation implements ListenerInterface
{
    
    /**
     * @return string|array
     */
    public static function listens()
    {
        return [
            'products::store-validation',
            'products::update-validation',
        ];
    }
    
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle()
    {
        Validator::make(request()->only('main-category'), [
            'main-category' => ['required', 'integer', new CategoryExists()],
        ], [], [
            'main-category' => trans('categories::general.attributes.main-category'),
        ])->validate();
    }

}