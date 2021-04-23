<?php

namespace App\Components\Menu;

use Illuminate\Support\Collection;

/**
 * Class Menu
 *
 * @package App\Components\Menu
 */
class Menu
{
    /**
     * Elements of the menu
     *
     * @var Collection|Group[]
     */
    private $elements;
    
    /**
     * Menu constructor.
     */
    public function __construct()
    {
        $this->elements = new Collection();
    }
    
    /**
     * Add group to menu
     *
     * @param  string $alias
     * @param  string|null $name
     * @param  int $position
     * @return Group
     */
    final public function group(string $alias = Group::DEFAULT_GROUP_TYPE, ?string $name = null, int $position = 0): Group
    {
        if ($this->elements->has($alias)) {
            $group = $this->elements->get($alias);
            if ($name) {
                $group->setName($name);
            }
            if ($position <> 0) {
                $group->setPosition($position);
            }
            return $group;
        }
        $group = new Group($name ?? $alias, $position);
        $this->elements->put($alias, $group);
        return $group;
    }
    
    /**
     * Returns groups list
     *
     * @return Group[]
     */
    final public function groups(): array
    {
        $elements = $this->elements->toArray();
        usort($elements, function ($current, $next) {
            return $current->position <=> $next->position;
        });
        return $elements;
    }
    
}
