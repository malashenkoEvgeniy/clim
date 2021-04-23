<?php

namespace App\Widgets\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use Route;
use App\Components\Widget\AbstractWidget;

/**
 * Class HeaderButton
 * Useful for buttons like 'Create'
 *
 * @package App\Widgets\Admin
 */
class HeaderButton implements AbstractWidget
{
    /**
     * Route name
     *
     * @var RouteObjectValue
     */
    private $route;
    
    /**
     * Classes on button
     *
     * @var array
     */
    private $classes = ['btn', 'btn-flat'];
    
    /**
     * Text
     *
     * @var string
     */
    private $title;
    
    /**
     * HeaderButton constructor.
     *
     * @param RouteObjectValue $route
     * @param string $title
     * @param array|string|null $classes
     */
    public function __construct(RouteObjectValue $route, string $title, $classes = null)
    {
        $this->route = $route;
        $this->title = $title;
        if (is_string($classes)) {
            $this->classes[] = $classes;
        } elseif (is_array($classes)) {
            $this->classes = array_merge($this->classes, $classes);
        }
    }
    
    /**
     * Render template
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view(
            'admin.widgets.content-header-button', [
                'classes' => implode(' ', $this->classes),
                'title' => $this->title,
                'url' => $this->route->getUrl(),
                'active' => $this->route->isCurrent(),
            ]
        );
    }
    
}
