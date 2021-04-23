<?php

namespace App\Core\ObjectValues;

use URL, Lang, Route;

/**
 * Class Link
 *
 * @package App\Core\ObjectValues
 * @method  static LinkObjectValue make(string $url)
 */
class LinkObjectValue extends ObjectValue
{

    const INTERNAL = 'internal';

    const EXTERNAL = 'external';

    /**
     * URL
     *
     * @var string
     */
    protected $url;

    /**
     * Use rel="nofollow" attribute
     *
     * @var bool
     */
    public $noFollow = false;

    /**
     * Place link into <noindex></noindex> tag
     *
     * @var bool
     */
    public $noIndex = false;

    /**
     * Link to the page inside the site
     *
     * @var bool
     */
    protected $inner = true;

    /**
     * Link constructor.
     *
     * @param string $url
     * @param string $inner
     */
    public function __construct(string $url, string $inner = 'internal')
    {
        $this->url = Route::has($url) ? route($url) : ltrim($url, '/');
        $this->inner = $inner === static::INTERNAL;
    }

    /**
     * Make url by route parameters
     *
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->inner) {
            if (config('app.default-language') === Lang::getLocale()) {
                return url($this->url);
            }
            return url(Lang::getLocale() . '/' . $this->url);
        }
        return $this->url;
    }

    /**
     * Returns true if route object is the same as current route
     *
     * @return bool
     */
    public function isCurrent(): bool
    {
        $currentUrl = URL::current();
        $urlParts = explode(array_get($_SERVER, 'HTTP_HOST'), $currentUrl);
        $currentUrl = array_pop($urlParts);
        $currentUrl = ltrim($currentUrl, '/');
        $currentUrl = str_replace('/' . Lang::getLocale(), '', '/' . $currentUrl);

        $objectUrl = $this->url;
        $urlParts = explode(array_get($_SERVER, 'HTTP_HOST'), $objectUrl);
        $objectUrl = array_pop($urlParts);
        $objectUrl = ltrim($objectUrl, '/');
        $objectUrl = str_replace('/' . Lang::getLocale(), '', '/' . $objectUrl);

        return ($currentUrl === $objectUrl) || (strpos($currentUrl, $objectUrl) !== false);
    }

    /**
     * @return string
     */
    public function noFollow()
    {
        return $this->noFollow ? ' rel="nofollow"' : '';
    }

}
