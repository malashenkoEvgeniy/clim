<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;

class LoginForm implements AbstractWidget
{
    
    private $idModifier;
    private $popup;
    private $checkout;
    
    public function __construct(bool $popup = false, bool $checkout = false)
    {
        $this->popup = $popup;
        $this->checkout = $checkout;
        $this->idModifier = $this->popup ? 'popup' : '';
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $validData = self::getValidationData();
        $formId = uniqid('form-login');
        
        return view("users::site.forms.login", [
            'idModifier' => $this->idModifier,
            'formId' => $formId,
            'isPopup' => $this->popup,
            'isCheckout' => $this->checkout,
            'rules' => $validData['rules'],
            'messages' => $validData['messages'],
            'attributes' => $validData['attributes'],
        ]);
    }
    
    public static function getValidationData()
    {
        $rules = [
            'password' => ['required'],
        ];
        $messages = [
            'required' => trans('users::site.validation.rules.required'),
        ];
        $attributes = [
            'email' => trans('users::site.validation.attributes.login-email'),
            'phone' => trans('users::site.validation.attributes.login-phone'),
            'password' => trans('users::site.validation.attributes.password'),
        ];
    
        $rules['email'] = ['required', 'email', 'min:8'];
        
        return [
            'rules' => $rules,
            'messages' => $messages,
            'attributes' => $attributes,
        ];
    }
    
}
