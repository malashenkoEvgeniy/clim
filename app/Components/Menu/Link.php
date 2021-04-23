<?php

namespace App\Components\Menu;

use App\Core\ObjectValues\RouteObjectValue;
use App\Exceptions\WrongParametersException;
use Auth, CustomRoles;

/**
 * One of the links in menu
 *
 * @package App\Components\Menu
 */
class Link
{
    
    /**
     * Element name
     *
     * @var string
     */
    public $name;
    
    /**
     * Svg icon class
     *
     * @var null|string
     */
    public $icon;
    
    /**
     * Route name
     *
     * @var RouteObjectValue
     */
    private $route;
    
    /**
     * Group current position
     *
     * @var int
     */
    public $position = 0;
    
    /**
     * Routes list to check parent element as active
     *
     * @var RouteObjectValue[]
     */
    private $additionalRoutesForActiveDetect = [];
    
    /**
     * Scope for roles (module.action)
     * This parameter sets permissions to view element in the menu
     *
     * @var string
     */
    private $permissionScope;
    
    /**
     * Cached result for canBeShowed() method
     *
     * @var boolean
     */
    private $canBeShowed;
    
    /**
     * @var int
     */
    private $counter = 0;
    
    /**
     * @var string
     */
    private $counterColor;
    
    /**
     * Element constructor.
     *
     * @param  string $name
     * @param  null|string|array $icon
     * @param  RouteObjectValue $route
     * @param  RouteObjectValue[] $additionalRoutesForActiveDetect
     * @throws WrongParametersException
     */
    public function __construct(string $name, RouteObjectValue $route, string $icon = null, array $additionalRoutesForActiveDetect = [])
    {
        $this->name = $name;
        $this->icon = $icon;
        if (is_array($additionalRoutesForActiveDetect)) {
            $this->additionalRoutesForActiveDetect(...$additionalRoutesForActiveDetect);
        }
        $this->route = $route;
    }
    
    /**
     * @param int $counter
     * @param string|null $color
     * @return self
     */
    public function addCounter(int $counter, string $color = null): self
    {
        $this->counter = $counter;
        $this->counterColor = $color;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCounter(): ?int
    {
        return $this->counter;
    }
    
    /**
     * @return string
     */
    public function getCounterColor(): ?string
    {
        return $this->counterColor;
    }
    
    /**
     * @return bool
     */
    public function hasCounter(): bool
    {
        return (int)$this->counter > 0;
    }
    
    /**
     * Returns URL for element
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->route->getUrl();
    }
    
    /**
     * Add additional routes to set element of the menu as active
     *
     * @param  RouteObjectValue[] ...$routes
     * @return $this
     * @throws WrongParametersException
     */
    public function additionalRoutesForActiveDetect(...$routes)
    {
        foreach ($routes as $route) {
            if ($route instanceof RouteObjectValue) {
                $this->additionalRoutesForActiveDetect[] = $route;
            } else {
                throw new WrongParametersException('Wrong type of route! You must give us RouteObjectValue');
            }
        }
        
        return $this;
    }
    
    /**
     * Is current element active
     *
     * @return bool
     */
    public function isActive()
    {
        if ($this->route->isCurrent()) {
            return true;
        }
        foreach ($this->additionalRoutesForActiveDetect as $routeObjectValue) {
            if ($routeObjectValue->isCurrent()) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Set group position
     *
     * @param  int $position
     * @return $this
     */
    public function setPosition(int $position)
    {
        $this->position = $position;
        
        return $this;
    }
    
    /**
     * Set permissions
     *
     * @param  string $scope
     * @return $this
     */
    public function setPermissionScope(string $scope)
    {
        $this->permissionScope = $scope;
        
        return $this;
    }
    
    /**
     * Checks if link could be showed in the menu
     *
     * @return bool
     */
    public function canBeShowed()
    {
        // Check if user is guest
        if (Auth::guest()) {
            return false;
        }
        // Check in cache
        if ($this->canBeShowed !== null) {
            return $this->canBeShowed;
        }
        if ($this->permissionScope) {
            // Generate module and action from existed data
            list($module, $action) = explode('.', $this->permissionScope);
            if (!$action) {
                $action = 'index';
            }
        } else {
            // Generate module and action from current menu route
            $module = $this->route->getModuleName();
            // Suppose that we need index page by default
            $action = 'index';
        }
        // Store to cache the result and return it back
        return $this->canBeShowed = CustomRoles::can($module, $action);
    }
    
    /**
     * Method force sets canBeShowed parameter
     *
     * @param  bool $value
     * @return $this
     */
    public function setCanBeShowed(bool $value)
    {
        $this->canBeShowed = $value;
        
        return $this;
    }
    
}
