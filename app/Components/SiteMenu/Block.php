<?php

namespace App\Components\SiteMenu;

use App\Core\ObjectValues\LinkObjectValue;
use Illuminate\Support\Collection;

/**
 * Class Element
 * Element of the menu with elements inside
 *
 * @package App\Components\Menu
 */
class Block
{

    /**
     * Element name
     *
     * @var string
     */
    public $name;

    /**
     * Element alias
     *
     * @var string
     */
    public $alias;

    /**
     * Svg icon class
     *
     * @var null|string
     */
    public $icon;

    /**
     * Group current position
     *
     * @var int
     */
    public $position;

    /**
     * Submenu for current element
     *
     * @var Link[]|Block[]|Collection
     */
    private $elements;

    /**
     * Cached result for canBeShowed() method
     *
     * @var boolean
     */
    private $canBeShowed;

    /**
     * Element constructor.
     *
     * @param string $alias
     * @param string $name
     * @param string $icon
     * @param int $position
     */
    public function __construct(string $alias, ?string $name = null, ?string $icon = null, int $position = 0)
    {
        $this->elements = new Collection();
        $this->alias = $alias;
        $this->name = $name ?? $alias;
        $this->icon = $icon;
        $this->position = $position;
    }

    /**
     * @return bool
     */
    public function hasCounter(): bool
    {
        foreach ($this->elements as $element) {
            if ($element->hasCounter()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        $counter = 0;
        $this->elements->each(function ($element) use (&$counter) {
            if ($element instanceof Link) {
                $counter += $element->getCounter();
            } elseif ($element instanceof Block) {
                $counter += $element->getCounter();
            }
        });
        return $counter;
    }

    /**
     * Is current element active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->hasKids() && $this->hasActiveKid();
    }

    /**
     * Check children for activity
     *
     * @return bool
     */
    public function hasActiveKid(): bool
    {
        foreach ($this->getKids() AS $element) {
            if ($element->isActive()) {
                return true;
            }
        }
        return false;
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
     * @return Link[]|Block[]
     */
    public function getKids(): array
    {
        $elements = [];
        foreach ($this->elements as $element) {
            if ($element->canBeShowed()) {
                $elements[] = $element;
            }
        }
        usort($elements, function ($current, $next) {
            return $current->position <=> $next->position;
        });
        return $elements;
    }

    /**
     * Get all childish elements
     *
     * @return Link[]|Block[]|Collection
     */
    public function getAllKids()
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
     * Add block to submenu
     *
     * @param  string $alias
     * @param  string|null $name
     * @return Block
     */
    final public function block(string $alias, ?string $name = null): Block
    {
        $block = new Block($alias, $name);
        $this->elements->push($block);
        return $block;
    }

    /**
     * Set icon class
     *
     * @param  string $icon
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
     * Checks if block could be showed in the menu
     *
     * @return bool
     */
    public function canBeShowed(): bool
    {
        return $this->canBeShowed !== false && $this->hasKids();
    }

    /**
     * Method force sets canBeShowed parameter
     *
     * @param  bool $value
     * @return $this
     */
    public function setCanBeShowed(bool $value): self
    {
        $this->canBeShowed = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBlock()
    {
        return true;
    }

}
