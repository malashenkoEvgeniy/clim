<?php

namespace App\Modules\SlideshowSimple\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\SlideshowSimple\Images\SliderImage;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SliderRequest
 *
 * @package App\Modules\Slideshow\Requests
 */
class SliderSimpleRequest extends FormRequest implements RequestInterface
{
    use ValidationRulesTrait;
    
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
        $simpleRules = ['active' => ['required', 'boolean']];
        if (!$this->route() || !$this->route()->parameter('slideshow_simple')) {
            $simpleRules[SliderImage::getField()] = ['required', 'image', 'max:' . config('image.max-size')];
        }
        return $this->generateRules($simpleRules, [
            'name' => ['required', 'max:191'],
        ]);
    }
    
}
