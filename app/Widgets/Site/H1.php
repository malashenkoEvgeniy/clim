<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use Seo;

/**
 * Class H1
 *
 * @package App\Widgets\Site
 */
class H1 implements AbstractWidget
{
    /**
     * @var bool
     */
    protected $textCenter;
    
    /**
     * @var string
     */
    protected $h1;
    
    /**
     * H1 constructor.
     *
     * @param string|null $h1
     * @param bool $textCenter
     */
    public function __construct(bool $textCenter = false, ?string $h1 = null)
    {
        $this->textCenter = $textCenter;
        $this->h1 = $h1;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!Seo::site()->getH1()) {
            return null;
        }
        return view('site-custom.h1', [
            'h1' => $this->h1 ?? Seo::site()->getH1(),
            'textCenter' => $this->textCenter,
        ]);
    }
    
}
