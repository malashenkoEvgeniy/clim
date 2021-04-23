<?php

namespace App\Modules\Subscribe\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Subscribe\Models\Subscriber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminSubscriberMailsRequest extends FormRequest implements RequestInterface
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
        
        return [
            'subject' => ['required', 'min:3'],
            'text' => ['required', 'min:3'],
        ];
    }
    
}