<?php

namespace App\Components\SiteMenu;

use App\Core\ObjectValues\LinkObjectValue;
use Auth;
use Illuminate\Support\Collection;

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
     * URL
     *
     * @var LinkObjectValue
     */
    private $url;

    /**
     * Group current position
     *
     * @var int
     */
    public $position = 0;

    /**
     * Link icon
     *
     * @var string|null
     */
    public $icon;

    /**
     * Description
     *
     * @var string|null
     */
    public $description;

    /**
     * Show only for authenticated users
     *
     * @var bool
     */
    public $onlyForAuthenticatedUsers = false;

    /**
     * Submenu for current element
     *
     * @var Link[]|Collection
     */
    private $elements;

    /**
     * Element constructor.
     *
     * @param  string $name
     * @param  LinkObjectValue $url
     * @param  null|string $icon
     * @param  null|string $description
     */
    public function __construct(string $name, LinkObjectValue $url, ?string $icon = null, ?string $description = null)
    {
        $this->elements = new Collection();
        $this->name = $name;
        $this->url = $url;
        $this->icon = $icon;
        $this->description = $description;
    }

    /**
     * Returns URL for element
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url->getUrl();
    }

    /**
     * @return LinkObjectValue
     */
    public function getLink()
    {
        return $this->url;
    }

    /**
     * Is current element active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->url->isCurrent();
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
     * Checks if link could be showed in the menu
     *
     * @return bool
     */
    public function canBeShowed()
    {
        return Auth::check() || $this->onlyForAuthenticatedUsers === false;
    }

    /**
     * Method force sets onlyForAuthenticatedUsers parameter
     *
     * @param  bool $value
     * @return $this
     */
    public function setOnlyForAuthenticatedUsers(bool $value)
    {
        $this->onlyForAuthenticatedUsers = $value;

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
