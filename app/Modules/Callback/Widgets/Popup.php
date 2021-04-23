<?php

namespace App\Modules\Callback\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Callback\Requests\SiteCallbackRequest;
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
        $formId = uniqid('callback-popup-form');
        return view('callback::site.popup', [
            'formId' => $formId,
            'rules' => (new SiteCallbackRequest())->rules(),
            'name' => Auth::check() ? Auth::user()->name : null,
            'phone' => Auth::check() ? Auth::user()->phone : null,
            'additions' => [
                (object)[
                    'text_content' => config('db.basic.phone_number_1'),
                    'href' => '+' . preg_replace("/[^,.0-9]/", '', config('db.basic.phone_number_1')),
                    'description' => null
                ],
                (object)[
                    'text_content' => config('db.basic.phone_number_2'),
                    'href' => '+' . preg_replace("/[^,.0-9]/", '', config('db.basic.phone_number_2')),
                    'description' => null
                ],
                (object)[
                    'text_content' => config('db.basic.phone_number_3'),
                    'href' => '+' . preg_replace("/[^,.0-9]/", '', config('db.basic.phone_number_3')),
                    'description' => null
                ]
            ]
        ]);
    }

}
