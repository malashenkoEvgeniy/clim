<?php

namespace App\Components\SiteMenu;

use App\Core\ObjectValues\LinkObjectValue;
use App\Core\ObjectValues\RouteObjectValue;
use App\Exceptions\WrongParametersException;
use Illuminate\Support\Collection;

/**
 * Class Element
 *
 * @package App\Components\Menu
 */
class Group
{

    /**
     * Default menu group
     */
    const DEFAULT_GROUP_TYPE = 'default';

    /**
     * Element name
     *
     * @var string
     */
    private $alias;

    /**
     * Group current position
     *
     * @var int
     */
    public $position;

    /**
     * Icon
     *
     * @var string
     */
    public $icon;

    /**
     * Submenu for current element
     *
     * @var Link[]|Collection
     */
    private $elements;

    /**
     * Element constructor.
     *
     * @param string $alias
     * @param int $position
     * @param string|null $icon
     */
    public function __construct(string $alias, int $position = 0, ?string $icon = null)
    {
        $this->elements = new Collection();
        $this->alias = $alias;
        $this->position = $position;
        $this->icon = $icon;
    }

    /**
     * Get name
     *
     * @return null|string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Do element has submenu?
     *
     * @return bool
     */
    public function hasKids(): bool
    {
        return count($this->getKids()) > 0;
    }

    /**
     * Get submenu for current element
     *
     * @return Link[]
     */
    public function getKids(): array
    {
        $elements = [];
        foreach ($this->elements as $element) {
            $elements[] = $element;
        }
        usort($elements, function ($current, $next) {
            return $current->position <=> $next->position;
        });
        return $elements;
    }

    /**
     * Get all childish elements
     *
     * @return Link[]|Collection
     */
    public function getAllKids(): Collection
    {
        return $this->elements;
    }

    /**
     * Add element to submenu
     *
     * @param  string $name $icon
     * @param  LinkObjectValue $url
     * @param  string|null $icon
     * @param  string|null $description
     * @return Link
     */
    final public function link(string $name, LinkObjectValue $url, ?string $icon = null, ?string $description = null): Link
    {
        $link = new Link($name, $url, $icon, $description);
        $this->elements->push($link);
        return $link;
    }

    /**
     * Add one link to the menu
     *
     * @param  Link $link
     * @return Link
     */
    final public function add(Link $link): Link
    {
        $this->elements->push($link);

        return $link;
    }

    /**
     * Add block to submenu
     *
     * @param  string $alias
     * @param  string $name
     * @param  null|string $icon
     * @return Block
     */
    final public function block(string $alias, ?string $name = null, ?string $icon = null): Block
    {
        $block = $this->getBlockByAlias($alias);
        if (!$block) {
            $block = new Block($alias, $name, $icon);
            $this->elements->push($block);
        } else {
            if ($icon) {
                $block->setIcon($icon);
            }
            if ((!$block->name || $block->name === $block->alias) && $name) {
                $block->setName($name);
            }
        }
        return $block;
    }

    /**
     * Get block by alias
     *
     * @param  string $alias
     * @return null|Block
     */
    private function getBlockByAlias(string $alias): ?Block
    {
        foreach ($this->getAllKids() as $element) {
            if ($element instanceof Block && $element->alias === $alias) {
                return $element;
            }
        }
        return null;
    }

    /**
     * Set group position
     *
     * @param  int $position
     * @return $this
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBlock()
    {
        return false;
    }

}
