<?php

namespace App\Components\AdminRoleScopes;

use App\Core\Modules\Administrators\Models\Admin;
use App\Exceptions\WrongParametersException;
use Illuminate\Support\Collection;
use Auth;

/**
 * Class RoleScopes
 *
 * @package App\Components\AdminRoleScopes
 */
class RoleScopes
{
    
    /**
     * @var Collection|RoleScope[]
     */
    public $modules;
    
    /**
     * Here will be placed linked groups
     *
     * @var array
     */
    private $linkedGroups = [];
    
    /**
     * @param string $module
     * @param string $groupName
     */
    public function linkGroup(string $module, string $groupName): void
    {
        $this->linkedGroups[$groupName] = $module;
    }
    
    public function getLinkedGroups(): array
    {
        return $this->linkedGroups;
    }
    
    public function getLinkedModule(string $group): ?string
    {
        return array_get($this->linkedGroups, $group, $group);
    }
    
    /**
     * RoleScopes constructor.
     */
    public function __construct()
    {
        $this->modules = new Collection();
    }
    
    /**
     * Add role element
     *
     * @param  string $module
     * @param  string|null $name
     * @param  array $rules
     * @return RoleScope
     */
    public function add(string $module, $name = null, array $rules = [])
    {
        $scope = new RoleScope($rules, $name ?: $module);
        $this->modules->put($module, $scope);
        
        return $scope;
    }
    
    /**
     * Get all scopes / module scope
     *
     * @param  string|null $module
     * @return RoleScope|RoleScope[]|Collection|mixed
     */
    public function get(string $module = null)
    {
        if ($module !== null) {
            return $this->modules->get($module);
        }
        return $this->modules;
    }
    
    /**
     * Get rule name
     *
     * @param  string $moduleName
     * @param  string $action
     * @param  mixed $default
     * @return mixed
     */
    public function getRuleName(string $moduleName, string $action, $default = null)
    {
        $module = $this->get($moduleName);
        if ($module) {
            return $module->getRuleName($action, $default);
        }
        return $default;
    }
    
    /**
     * Check user permissions
     *
     * @param  string $module
     * @param  string|null $action
     * @return mixed
     * @throws WrongParametersException
     */
    public function can(string $module, string $action = null)
    {
        if ($action === null) {
            list($module, $action) = array_pad(explode('.', $module), 2, null);
        }
        $module = $this->getLinkedModule($module);
        if (!$action) {
            throw new WrongParametersException('Parameter $action is empty!');
        }
        /** @var Admin $admin */
        $admin = Auth::user();
        return $admin->hasPermissions($module, $action);
    }
    
}
