<?php

namespace App\Modules\Sitemap\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Sitemap\Models\Sitemap;

/**
 * Class SitemapController
 *
 * @package App\Modules\Sitemap\Controllers\Site
 */
class SitemapController extends SiteController
{

    /**
     * @var SystemPage
     */
    static $page;

    /**
     * SitemapController constructor.
     */
    public function __construct()
    {
        /** @var SystemPage $page */
        static::$page = SystemPage::getByCurrent('slug', 'sitemap');
        abort_unless(static::$page && static::$page->exists, 404);
    }

    /**
     * Sitemap list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setOtherLanguagesLinks(static::$page);
        $this->canonical(route('site.sitemap'));
        return view('sitemap::site.index', [
            'tree' => (new Sitemap)->getSitemap(),
        ]);
    }


    /**
     * Sitemap xml output
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexXml()
    {
        return response()->view('sitemap::site.xml', [
            'links' => (new Sitemap)->getSitemapXml(),
        ])->header('Content-Type', 'text/xml');
    }


    /**
     * Images Sitemap xml output
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function imagesXml()
    {
        return response()->view('sitemap::site.images-xml', [
            'links' => (new Sitemap)->getImagesSitemapXml(),
        ])->header('Content-Type', 'text/xml');
    }
}
