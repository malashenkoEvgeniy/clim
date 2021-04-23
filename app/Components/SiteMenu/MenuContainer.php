<?php

namespace App\Components\SiteMenu;

use App\Components\Menu\Block;
use App\Core\ObjectValues\LinkObjectValue;
use Illuminate\Support\Collection;

/**
 * Class MenuContainer
 * Any menu of the site storage
 *
 * @package App\Components\SiteMenu
 */
class MenuContainer
{

    /**
     * @var Group[]|Collection
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
     * @return Group
     */
    public function get(string $type = 'default'): Group
    {
        if ($this->exists($type) === false) {
            $this->instances->put($type, new Group($type));
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

    /**
     * @param Group|Link|Block $instance
     * @param array $array
     */
    protected function createFromArrayRecursive ($instance, array $array): void
    {
        foreach ($array as $item) {
            if ($item['alias'] ?? null) {
                $link = $instance->block(
                    $item['alias'],
                    $item['name'],
                    $item['icon'] ?? null
                );
            } else {
                $link = $instance->link(
                    $item['name'],
                    LinkObjectValue::make($item['url']),
                    $item['icon'] ?? null,
                    $item['description'] ?? null
                );
            }

            if (is_array($item['kids'] ?? null)) {
                self::createFromArrayRecursive($link, $item['kids']);
            }
        }
    }

    /**
     * @param string $type
     * @param array $array
     * @return Group
     * @see https://wiki.wezom.agency/examples/custom-site-menu#custom-site-menu
     */
    public function createFromArray (string $type, array $array): Group
    {
        $group = self::get($type);
        self::createFromArrayRecursive($group, $array);
        return $group;
    }
}
