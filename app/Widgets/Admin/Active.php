<?php

namespace App\Widgets\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use Route;
use App\Components\Widget\AbstractWidget;
use Illuminate\Database\Eloquent\Model;

class Active implements AbstractWidget
{
    
    /**
     * Current object model
     *
     * @var Model
     */
    private $object;
    
    /**
     * URL to send request
     *
     * @var string
     */
    private $url;
    
    /**
     * Scope for roles system
     *
     * @var string
     */
    private $permissionScope;
    
    /**
     * Status constructor.
     *
     * @param Model $object
     * @param string|RouteObjectValue|null $route
     * @param string|null $permissionScope
     */
    public function __construct(Model $object, $route = null, $permissionScope = null)
    {
        $routeName = null;
        $this->object = $object;
        // Generate url
        if ($route !== null) {
            if ($route instanceof RouteObjectValue) {
                $route->addParameter('class', get_class($object));
                $this->url = $route->getUrl();
                $routeName = $route->getRouteName();
            } else {
                $this->url = route($route, ['id' => $object->id, 'class' => get_class($object)]);
                $routeName = $route;
            }
        } else {
            $currentRoute = Route::currentRouteName();
            $currentRouteElements = explode('.', $currentRoute);
            array_pop($currentRouteElements);
            $currentRouteElements[] = 'active';
            $routeName = implode('.', $currentRouteElements);
            $this->url = route($routeName, ['id' => $object->id, 'class' => get_class($object)]);
        }
        // Permissions to element
        if ($permissionScope) {
            $this->permissionScope = $permissionScope;
        } else {
            list(, $module, $action) = explode('.', $routeName);
            $this->permissionScope = $module . '.' . $action;
        }
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('admin.widgets.active', [
            'active' => $this->object->active,
            'url' => $this->url,
            'hasPermission' => \CustomRoles::can($this->permissionScope),
        ]);
    }
}
