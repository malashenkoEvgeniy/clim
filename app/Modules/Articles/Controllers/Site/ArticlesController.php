<?php

namespace App\Modules\Articles\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Articles\Models\Article;

/**
 * Class ArticlesController
 *
 * @package App\Modules\Articles\Controllers\Site
 */
class ArticlesController extends SiteController
{
    /**
     * @var SystemPage
     */
    static $page;
    
    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        /** @var SystemPage $page */
        static::$page = SystemPage::getByCurrent('slug', 'articles');
        abort_unless(static::$page && static::$page->exists, 404);
    }
    
    /**
     * Articles list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::getArticlesForClientSide();
        $this->pageNumber();
        $this->canonical(route('site.articles'));
        $this->meta(static::$page->current, static::$page->current->content);
        $this->breadcrumb(static::$page->current->name, 'site.articles');
        $this->setOtherLanguagesLinks(static::$page);
        return view('articles::site.index', [
            'articles' => $articles,
            'page' => static::$page,
        ]);
    }
    
    /**
     * Show articles page
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        /** @var Article $article */
        $article = Article::getByCurrent('slug', $slug);
        abort_unless($article && $article->exists && $article->active, 404);
        $this->meta($article->current);
        $this->metaTemplate(Article::SEO_TEMPLATE_ALIAS, [
            'name' => $article->current->name,
        ]);
        $this->breadcrumb(static::$page->current->name, 'site.articles');
        $this->breadcrumb($article->current->name, 'site.articles-inner', [$article->current->slug]);
        $this->setOtherLanguagesLinks($article);
        $this->canonical(route('site.articles-inner', [$article->current->slug]));
        return view('articles::site.show', [
            'article' => $article,
        ]);
    }
}
