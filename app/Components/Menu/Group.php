<?php

namespace App\Components\Menu;

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
     * Will not be displayed
     */
    const INVISIBLE_GROUP_TYPE = 'invisible';
    
    /**
     * Default menu group
     */
    const DEFAULT_GROUP_TYPE = 'default';
    
    /**
     * Element name
     *
     * @var string
     */
    private $name;
    
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
     * @param string $name
     * @param int $position
     */
    public function __construct(string $name, int $position = 0)
    {
        $this->elements = new Collection();
        $this->name = $name;
        $this->position = $position;
    }
    
    /**
     * Do we need to show this element?
     *
     * @return bool
     */
    public function show(): bool
    {
        return $this->name !== static::INVISIBLE_GROUP_TYPE;
    }
    
    /**
     * Get name
     *
     * @return null|string
     */
    public function getName(): string
    {
        if ($this->name === static::DEFAULT_GROUP_TYPE) {
            return __('admin.menu.default');
        }
        return (string)__($this->name);
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
    public function getAllKids(): Collection
    {
        return $this->elements;
    }
    
    /**
     * Add element to submenu
     *
     * @param  string $name $icon
     * @param  RouteObjectValue $route
     * @param  string|null $icon
     * @param  RouteObjectValue[] $additionalRoutesForActiveDetect
     * @return Link
     * @throws WrongParametersException
     */
    final public function link(string $name, RouteObjectValue $route, ?string $icon = null, array $additionalRoutesForActiveDetect = []): Link
    {
        $link = new Link($name, $route, $icon, $additionalRoutesForActiveDetect);
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
     * Checks if group could be showed in the menu
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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
}
