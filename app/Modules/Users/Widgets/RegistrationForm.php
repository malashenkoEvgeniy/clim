<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Users\Requests\Site\Registration;

class RegistrationForm implements AbstractWidget
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
        $formId = uniqid('form-registration');
        $validation = \JsValidator::make(
            (new Registration())->rules(),
            [],
            [],
            "#$formId"
        );
        return view("users::site.forms.registration", [
            'idModifier' => $this->idModifier,
            'formId' => $formId,
            'validation' => $validation,
            'isPopup' => $this->popup,
        ]);
    }
    
}
