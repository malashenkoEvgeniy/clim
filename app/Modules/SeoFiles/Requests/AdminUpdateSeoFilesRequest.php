<?php

namespace App\Modules\SeoFiles\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\SeoFiles\Models\SeoFile;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AdminSeoFilesRequest
 *
 * @package App\Modules\SeoFiles\Requests
 */
class AdminUpdateSeoFilesRequest extends FormRequest implements RequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var SeoFile $file */
        $file = $this->route('seo_file');
        return $file->exists;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => ['nullable', 'string'],
        ];
    }
    
}
