<?php

namespace App\Modules\Articles\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Articles\Forms\ArticleForm;
use App\Modules\Articles\Models\Article;
use App\Modules\Articles\Requests\ArticleRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class ArticlesController
 *
 * @package App\Modules\Articles\Controllers\Admin
 */
class ArticlesController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('articles::seo.index', RouteObjectValue::make('admin.articles.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new article button
        $this->addCreateButton('admin.articles.create');
    }
    
    /**
     * Articles sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('articles::seo.index');
        // Get article
        $articles = Article::getList();
        // Return view list
        return view('articles::admin.index', ['articles' => $articles]);
    }
    
    /**
     * Create new element page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('articles::seo.create');
        // Set h1
        Seo::meta()->setH1('articles::seo.create');
        // Javascript validation
        $this->initValidation((new ArticleRequest())->rules());
        // Return form view
        return view(
            'articles::admin.create', [
                'form' => ArticleForm::make(),
            ]
        );
    }
    
    /**
     * Create page in database
     *
     * @param  ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(ArticleRequest $request)
    {
        $article = (new Article);
        // Create new article
        if ($message = $article->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $article->id]);
    }
    
    /**
     * Update element page
     *
     * @param  Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Article $article)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($article->current->name ?? 'articles::seo.edit');
        // Set h1
        Seo::meta()->setH1('articles::seo.edit');
        // Javascript validation
        $this->initValidation((new ArticleRequest)->rules());
        // Return form view
        return view(
            'articles::admin.update', [
                'form' => ArticleForm::make($article),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  ArticleRequest $request
     * @param  Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ArticleRequest $request, Article $article)
    {
        // Update existed article
        if ($message = $article->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Article $article)
    {
        // Delete article's image
        $article->deleteAllImages();
        // Delete article
        $article->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
}
