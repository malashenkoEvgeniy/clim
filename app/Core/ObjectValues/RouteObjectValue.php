<?php

namespace App\Core\ObjectValues;

use App\Exceptions\WrongParametersException;
use Route;

/**
 * Class Route
 *
 * @package App\Core\ObjectValues
 * @method  static RouteObjectValue make(string $name, array $parameters = [])
 */
class RouteObjectValue extends ObjectValue
{
    
    /**
     * Route name
     *
     * @var string
     */
    protected $name;
    
    /**
     * Route parameters
     *
     * @var array
     */
    protected $parameters = [];
    
    /**
     * Route constructor.
     *
     * @param  string $name
     * @param  array $parameters
     * @throws WrongParametersException
     */
    public function __construct(string $name, array $parameters = [])
    {
        if (Route::has($name) === false) {
            throw new WrongParametersException("There is no route named '{$name}'!");
        }
        $this->name = $name;
        $this->parameters = $parameters;
    }
    
    /**
     * Add more parameters
     *
     * @param  string $key
     * @param  string|null|int $value
     * @return RouteObjectValue
     */
    public function addParameter(string $key, $value): self
    {
        $this->parameters[$key] = $value;
        
        return $this;
    }
    
    /**
     * Returns route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->name;
    }
    
    /**
     * Returns route parameters
     *
     * @return array
     */
    public function getRouteParameters(): array
    {
        return $this->parameters;
    }
    
    /**
     * Make url by route parameters
     *
     * @return string
     */
    public function getUrl(): string
    {
        return route($this->name, $this->parameters);
    }
    
    /**
     * Returns true if route object is the same as current route
     *
     * @return bool
     */
    public function isCurrent(): bool
    {
        foreach ($this->parameters as $parameterKey => $parameterValue) {
            if (Route::getCurrentRoute()->hasParameter($parameterKey) === false) {
                return false;
            }
            if ($parameterValue != Route::getCurrentRoute()->parameter($parameterKey)) {
                return false;
            }
        }
        if (Route::currentRouteNamed($this->getRouteName()) === false) {
            return false;
        }
        return true;
    }
    
    /**
     * Get module name from the route name
     *
     * @return string
     */
    public function getModuleName(): string
    {
        list(, $module,) = explode('.', $this->getRouteName());
        return (string)str_replace('-', '_', $module);
    }
    
}
