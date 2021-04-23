<?php

namespace App\Modules\Consultations\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Consultations\Requests\SiteConsultationsRequest;
use Auth;

/**
 * Class Popup
 *
 * @package App\Modules\Callback\Widgets
 */
class Popup implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $formId = uniqid('consultations-popup-form');
        return view('consultations::site.popup', [
            'formId' => $formId,
            'rules' => (new SiteConsultationsRequest())->rules(),
            'name' => Auth::check() ? Auth::user()->name : null,
            'phone' => Auth::check() ? Auth::user()->phone : null,
        ]);
    }
    
}
