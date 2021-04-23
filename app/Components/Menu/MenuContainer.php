<?php

namespace App\Components\Menu;

use Illuminate\Support\Collection;

/**
 * Class MenuContainer
 * Any menu of the site storage
 *
 * @package App\Components\Menu
 */
class MenuContainer
{
    
    /**
     * @var Menu[]|Collection
     */
    private $instances;
    
    /**
     * MenuContainer constructor.
     */
    public function __construct()
    {
        $this->instances = new Collection();
    }
    
    /**
     * Get current object
     *
     * @return $this
     */
    public function instance(): self
    {
        return $this;
    }
    
    /**
     * Returns newly created or existed exemplar of the site Menu
     *
     * @param  string $type
     * @return Menu
     */
    public function get(string $type = 'default'): Menu
    {
        if ($this->exists($type) === false) {
            $this->instances->put($type, new Menu());
        }
        return $this->instances->get($type);
    }
    
    /**
     * This method checks if Menu exists in the storage
     *
     * @param  string $type
     * @return bool
     */
    public function exists(string $type = 'default'): bool
    {
        return $this->instances->has($type);
    }
    
}
