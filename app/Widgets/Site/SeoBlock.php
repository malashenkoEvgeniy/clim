<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use Seo;

/**
 * Class SeoBlock
 *
 * @package App\Widgets\Site
 */
class SeoBlock implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Seo::site()->doNotNeedSeoBlock()) {
            return view('site-custom.seo-block', [
                'text' => ' ',
            ]);
        }
        return view('site-custom.seo-block', [
            'h1' => Seo::site()->getH1(),
            'text' => Seo::site()->getSeoText(),
        ]);
    }
    
}
