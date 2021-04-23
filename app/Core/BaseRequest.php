<?php

namespace App\Core;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest implements RequestInterface
{

    public function makeAttributes(array $attributes)
    {
        $rules = [];
        foreach (config('languages', []) as $slug => $language) {
            foreach ($attributes as $key => $value) {
                $rules[$slug . '.' . $key] = $value;
            }
        }
        return $rules;
    }
    
}
