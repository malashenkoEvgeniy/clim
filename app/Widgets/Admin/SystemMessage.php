<?php

namespace App\Widgets\Admin;

use App\Components\Widget\AbstractWidget;
use App\Helpers\Alert;

/**
 * Class SystemMessage
 * Message block we will show to user
 *
 * @package App\Widgets\Admin
 */
class SystemMessage implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $message = Alert::get();
        if (!$message || !is_array($message) || !array_get($message, 'text')) {
            return null;
        }
        $text = array_get($message, 'text');
        return view(
            'admin.widgets.system-message', [
                'type' => array_get($message, 'type', Alert::TYPE_INFO),
                'title' => __(array_get($message, 'title')),
                'text' => $text ? __($text) : $text,
                'icon' => array_get($message, 'icon'),
            ]
        );
    }
}
