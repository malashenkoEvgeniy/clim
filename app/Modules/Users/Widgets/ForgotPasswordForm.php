<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;

class ForgotPasswordForm implements AbstractWidget
{
    
    private $idModifier;
    private $popup;
    
    public function __construct(bool $popup = false)
    {
        $this->popup = $popup;
        $this->idModifier = $this->popup ? 'popup' : '';
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $formId = uniqid('form-forgot-password');
        $validation = \JsValidator::make([
            'email' => 'required|string|email',
        ], [], [], "#$formId");
        return view('users::site.forms.forgot-password', [
            'idModifier' => $this->idModifier,
            'formId' => $formId,
            'isPopup' => $this->popup,
            'validation' => $validation,
        ]);
    }
    
}
