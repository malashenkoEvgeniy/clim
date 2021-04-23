<?php

namespace App\Components\Seo;

use Illuminate\Foundation\Application as App;

/**
 * This is the container for Seo module
 *
 * @package App\Components\Seo
 */
class Seo
{
    /**
     * Breadcrumbs container
     *
     * @var Breadcrumbs
     */
    protected $breadcrumbs;
    
    /**
     * Meta tags for current page
     *
     * @var Meta
     */
    protected $meta;
    
    /**
     * Meta tags for site pages including templates
     *
     * @var Site
     */
    protected $site;
    
    /**
     * Seo constructor.
     */
    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs();
        $this->meta = new Meta();
    }
    
    /**
     * Get breadcrumbs container
     *
     * @return Breadcrumbs
     */
    public function breadcrumbs(): Breadcrumbs
    {
        return $this->breadcrumbs;
    }
    
    /**
     * Meta tags for current page
     *
     * @return Meta
     */
    public function meta(): Meta
    {
        return $this->meta;
    }
    
    /**
     * Get instance of current class
     *
     * @return Site
     */
    public function site(): Site
    {
        if (!$this->site || !($this->site instanceof Site)) {
            $this->site = new Site();
        }
        return $this->site;
    }
}
