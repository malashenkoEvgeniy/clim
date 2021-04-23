<?php

namespace App\Core\Modules\Languages\Widgets;

use App\Components\Widget\AbstractWidget;

/**
 * Class Labels
 *
 * @package App\Modules\LabelsForProducts\Widgets
 */
class LanguageTrigger implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $languages = config('languages', []);
        if (!$languages || !is_array($languages) || count($languages) < 2) {
            return null;
        }
        return view('languages::trigger', [
            'languages' => $languages,
        ]);
    }
    
}
