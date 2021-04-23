<?php

namespace App\Core\Modules\Settings\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LogoRequest
 *
 * @package App\Core\Modules\Settings\Requests
 */
class LogoRequest extends FormRequest implements RequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $logoExists = false;
        $pathToFile = 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        if (is_file(storage_path($pathToFile))) {
            $logoExists = true;
        }
    
        $mobileLogoExists = false;
        $pathToFile = 'app/public/' . config('app.logo-mobile.path') . '/' . config('app.logo-mobile.filename');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        if (is_file(storage_path($pathToFile))) {
            $mobileLogoExists = true;
        }
        return [
            'use_image' => ['required', 'boolean'],
            'name' => ['required_if:use_image,0', 'nullable', 'string', 'min:1', 'max:15'],
            'logo' => $logoExists ? ['nullable'] : ['required_if:use_image,1', 'nullable', 'image'],
            
            'use_image_mobile' => ['required', 'boolean'],
            'name_mobile' => ['required_if:use_image_mobile,0', 'nullable', 'string', 'size:1'],
            'logo_mobile' => $mobileLogoExists ? ['nullable'] : ['required_if:use_image_mobile,1', 'nullable', 'image'],
        ];
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        return [
            'required_if' => trans('settings::logo.required_if'),
        ];
    }
    
}
