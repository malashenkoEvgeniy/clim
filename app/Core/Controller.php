<?php

namespace App\Core;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use JsValidator;
use Proengsoft\JsValidation\Javascript\JavascriptValidator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @param FormRequest|RequestInterface $request
     * @param string|null $selector
     */
    protected function jsValidation(FormRequest $request, string $selector = null): void
    {
        $this->initValidation($request->rules(), $selector, $request->messages(), $request->attributes());
    }
    
    /**
     * Init validation script
     *
     * @param array $rules
     * @param string|null $selector
     * @param array $customMessages
     * @param array $customAttributes
     */
    protected function initValidation(array $rules, string $selector = null, array $customMessages = [], array $customAttributes = []): void
    {
        $jsValidator = view()->shared('jsValidator', []);
        $jsValidator[] = $this->makeValidationJavaScript($rules, $selector, $customMessages, $customAttributes);
        view()->share('jsValidator', $jsValidator);
    }
    
    /**
     * Make validation javascript
     *
     * @param array $rules
     * @param string|null $selector
     * @param array $customMessages
     * @param array $customAttributes
     * @return JavascriptValidator
     */
    protected function makeValidationJavaScript(array $rules, ?string $selector = null, array $customMessages = [], array $customAttributes = []): JavascriptValidator
    {
        return JsValidator::make($rules, $customMessages, $customAttributes, $selector);
    }
}
