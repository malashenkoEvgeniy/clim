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
class AdminSubscriberRequest extends FormRequest implements RequestInterface
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
        /**
         * @var Subscriber $subscriber
         */
        $subscriber = $this->route('subscriber');
        
        return [
            'active' => ['required', 'boolean'],
            'email' => [
                'required', 'email',
                Rule::unique('subscribers', 'email')->ignore($subscriber ? $subscriber->id : null),
            ],
        ];
    }
    
}
