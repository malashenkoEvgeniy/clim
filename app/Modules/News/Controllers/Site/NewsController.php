<?php

namespace App\Modules\News\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\News\Models\News;

/**
 * Class NewsController
 *
 * @package App\Modules\News\Controllers\Site
 */
class NewsController extends SiteController
{
    
    /**
     * @var SystemPage
     */
    static $page;
    
    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        /** @var SystemPage $page */
        static::$page = SystemPage::getByCurrent('slug', 'news');
        abort_unless(static::$page && static::$page->exists, 404);
    }
    
    /**
     * News list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $news = News::getNewsForClientSide();
        $this->pageNumber();
        $this->meta(static::$page->current, static::$page->current->content);
        $this->canonical(route('site.news'));
        $this->breadcrumb(static::$page->current->name, 'site.news');
        $this->setOtherLanguagesLinks(static::$page);
        return view('news::site.index', [
            'news' => $news,
            'page' => static::$page,
        ]);
    }
    
    /**
     * Show news page
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        /** @var News $news */
        $news = News::getByCurrent('slug', $slug);
        abort_unless($news && $news->exists && $news->active, 404);
        $this->meta($news->current);
        $this->metaTemplate(News::SEO_TEMPLATE_ALIAS, [
            'name' => $news->current->name,
            'published_at' => $news->formatted_published_at,
        ]);
        $this->breadcrumb(static::$page->current->name, 'site.news');
        $this->breadcrumb($news->current->name, 'site.news-inner', [$news->current->slug]);
        $this->setOtherLanguagesLinks($news);
        $this->canonical(route('site.news-inner', [$news->current->slug]));
        return view('news::site.show', [
            'news' => $news,
        ]);
    }
    
}
