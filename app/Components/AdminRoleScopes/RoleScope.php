<?php

namespace App\Components\AdminRoleScopes;

use App\Core\Modules\Administrators\Models\RoleRule;

/**
 * Class RoleScope
 *
 * @package App\Components\AdminRoleScopes
 */
class RoleScope
{
    /**
     * Text label
     *
     * @var string
     */
    public $name;
    
    /**
     * Show index element in list?
     *
     * @var bool
     */
    public $index = false;
    
    /**
     * Show view element in list?
     *
     * @var bool
     */
    public $view = false;
    
    /**
     * Show update element in list?
     *
     * @var bool
     */
    public $update = false;
    
    /**
     * Show store element in list?
     *
     * @var bool
     */
    public $store = false;
    
    /**
     * Show delete element in list?
     *
     * @var bool
     */
    public $delete = false;
    
    /**
     * Associative array with controllers actions as key and permission property as value
     *
     * @var array
     */
    public $policies = [
        'index' => RoleRule::INDEX,
        'deleted' => RoleRule::INDEX,
        'show' => RoleRule::VIEW,
        'edit' => RoleRule::UPDATE,
        'update' => RoleRule::UPDATE,
        'create' => RoleRule::STORE,
        'store' => RoleRule::STORE,
        'destroy' => RoleRule::DELETE,
        'restore' => RoleRule::STORE,
        'active' => RoleRule::UPDATE,
        'sortable' => RoleRule::UPDATE,
    ];
    
    /**
     * RoleScope constructor.
     *
     * @param string $name
     * @param array $rules
     */
    public function __construct(array $rules = [], string $name)
    {
        foreach ($rules AS $scope => $access) {
            if (property_exists($this, $scope)) {
                $this->{$scope} = (boolean)$access;
            }
        }
        $this->name = $name;
    }
    
    /**
     * Turn on some scopes
     *
     * @param array ...$scopes
     */
    public function turnOn(...$scopes)
    {
        foreach ($scopes as $scope) {
            if (property_exists($this, $scope)) {
                $this->{$scope} = true;
            }
        }
    }
    
    /**
     * Turn off some scopes
     *
     * @param array ...$scopes
     */
    public function turnOff(...$scopes)
    {
        foreach ($scopes as $scope) {
            if (property_exists($this, $scope)) {
                $this->{$scope} = false;
            }
        }
    }
    
    /**
     * Enable all scopes
     *
     * @return $this
     */
    public function enableAll()
    {
        $this->turnOn(
            RoleRule::INDEX,
            RoleRule::VIEW,
            RoleRule::STORE,
            RoleRule::UPDATE,
            RoleRule::DELETE
        );
        
        return $this;
    }
    
    /**
     * Disable all scopes
     *
     * @return $this
     */
    public function disableAll()
    {
        $this->turnOff(
            RoleRule::INDEX,
            RoleRule::VIEW,
            RoleRule::STORE,
            RoleRule::UPDATE,
            RoleRule::DELETE
        );
        
        return $this;
    }
    
    /**
     * Turn on only scopes in the list
     *
     * @param mixed ...$scopes
     * @return self
     */
    public function only(...$scopes): self
    {
        $this->disableAll();
        
        foreach ($scopes as $scope) {
            if (property_exists($this, $scope)) {
                $this->{$scope} = true;
            }
        }
        
        return $this;
    }
    
    /**
     * Turn on all except scopes in the list
     *
     * @param mixed ...$scopes
     * @return self
     */
    public function except(...$scopes): self
    {
        $this->enableAll();
        
        foreach ($scopes as $scope) {
            if (property_exists($this, $scope)) {
                $this->{$scope} = false;
            }
        }
    
        return $this;
    }
    
    /**
     * Returns all needed for work values as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            RoleRule::INDEX => $this->index,
            RoleRule::VIEW => $this->view,
            RoleRule::STORE => $this->store,
            RoleRule::UPDATE => $this->update,
            RoleRule::DELETE => $this->delete,
        ];
    }
    
    /**
     * Add custom link
     *
     * @param  string $action
     * @param  string $property
     * @return $this
     */
    public function addCustomPolicy(string $action, string $property)
    {
        $this->policies[$action] = $property;
        
        return $this;
    }
    
    /**
     * Get rule name by action
     *
     * @param  string $action
     * @param  mixed $default
     * @return mixed
     */
    public function getRuleName(string $action, $default = null)
    {
        return array_get($this->policies, $action, $default);
    }
    
}
