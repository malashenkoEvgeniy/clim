<?php

namespace App\Components\Seo;

use Illuminate\Support\Collection;
use App\Core\ObjectValues\RouteObjectValue;

/**
 * Breadcrumbs
 *
 * @package App\Components\Seo
 */
class Breadcrumbs
{
    
    /**
     * @var Collection|Breadcrumb[]
     */
    protected $elements;
    
    /**
     * Breadcrumbs constructor.
     */
    public function __construct()
    {
        $this->elements = new Collection();
        // Main page breadcrumb
        if (config('app.place') === 'site') {} else {
            $this->add('Dashboard', RouteObjectValue::make('admin.dashboard'), 'fa fa-dashboard');
        }
    }
    
    /**
     * Add part of the breadcrumbs
     *
     * @param string $title
     * @param RouteObjectValue|null $route
     * @param null|string $icon
     */
    public function add(string $title, RouteObjectValue $route = null, $icon = null)
    {
        $this->elements->push(new Breadcrumb($title, $route, $icon));
    }
    
    /**
     * Add parts of breadcrumbs
     *
     * @param mixed ...$breadcrumbs
     */
    public function addMany(...$breadcrumbs)
    {
        foreach ($breadcrumbs as $breadcrumb) {
            abort_unless($breadcrumb instanceof Breadcrumb, 400, 'Wrong parameters!');
            $this->elements->push($breadcrumb);
        }
    }
    
    /**
     * Count of the elements in breadcrumbs
     *
     * @return int
     */
    public function count(): int
    {
        return $this->elements->count();
    }
    
    /**
     * Do we need to show breadcrumbs to user
     *
     * @return bool
     */
    public function needsToBeDisplayed(): bool
    {
        return $this->count() > 1;
    }
    
    /**
     * Get elements of the breadcrumbs
     *
     * @return Breadcrumb[]|Collection
     */
    public function elements()
    {
        return $this->elements;
    }
    
}
