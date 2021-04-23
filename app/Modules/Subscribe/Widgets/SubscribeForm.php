<?php

namespace App\Modules\Subscribe\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Subscribe\Requests\SiteSubscriberRequest;
use Auth;

/**
 * Class SubscribeForm
 *
 * @package App\Modules\Subscribe\Widgets
 */
class SubscribeForm implements AbstractWidget
{
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $formId = uniqid('subscribe-form');
        $validation = \JsValidator::make(
            (new SiteSubscriberRequest())->rules(),
            [],
            [],
            "#$formId"
        );
        return view('subscribe::site.widget', [
            'formId' => $formId,
            'validation' => $validation,
            'name' => Auth::check() ? Auth::user()->name : null,
            'email' => Auth::check() ? Auth::user()->email : null,
        ]);
    }
    
}
