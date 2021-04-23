<?php

namespace App\Components\Seo;

use Route;
use App\Core\ObjectValues\RouteObjectValue;

/**
 * Class Breadcrumb
 * One breadcrumbs part
 *
 * @package App\Components\Seo
 */
class Breadcrumb
{
    
    /**
     * Title
     *
     * @var string
     */
    protected $title;
    
    /**
     * Route
     *
     * @var null|RouteObjectValue
     */
    protected $route;
    
    /**
     * Icon element
     *
     * @var string
     */
    protected $icon;
    
    /**
     * Breadcrumb constructor.
     *
     * @param string $title
     * @param null|RouteObjectValue $route
     * @param null|string $icon
     */
    public function __construct(string $title, ?RouteObjectValue $route = null, ?string $icon = null)
    {
        $this->title = $title;
        $this->icon = $icon;
        if ($route) {
            $this->route = $route;
        }
    }
    
    /**
     * Url for breadcrumb
     *
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->route ? $this->route->getUrl() : null;
    }
    
    /**
     * Title
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    /**
     * Icon
     *
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }
    
    /**
     * Check if this is for active page
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->route && Route::currentRouteNamed($this->route->getRouteName());
    }
    
}
