<?php

namespace App\Modules\News\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\News\Forms\NewsForm;
use App\Modules\News\Models\News;
use App\Modules\News\Requests\NewsRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class NewsController
 *
 * @package App\Modules\News\Controllers\Admin
 */
class NewsController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('news::seo.index', RouteObjectValue::make('admin.news.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new news button
        $this->addCreateButton('admin.news.create');
    }
    
    /**
     * News sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('news::seo.index');
        // Get news
        $news = News::getList();
        // Return view list
        return view('news::admin.index', ['news' => $news]);
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
        Seo::breadcrumbs()->add('news::seo.create');
        // Set h1
        Seo::meta()->setH1('news::seo.create');
        // Javascript validation
        $this->initValidation((new NewsRequest())->rules());
        // Return form view
        return view(
            'news::admin.create', [
                'form' => NewsForm::make(),
            ]
        );
    }
    
    /**
     * Create page in database
     *
     * @param  NewsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(NewsRequest $request)
    {
        $news = (new News);
        // Create new news
        if ($message = $news->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $news->id]);
    }
    
    /**
     * Update element page
     *
     * @param  News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(News $news)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($news->current->name ?? 'news::seo.edit');
        // Set h1
        Seo::meta()->setH1('news::seo.edit');
        // Javascript validation
        $this->initValidation((new NewsRequest)->rules());
        // Return form view
        return view(
            'news::admin.update', [
                'form' => NewsForm::make($news),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  NewsRequest $request
     * @param  News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(NewsRequest $request, News $news)
    {
        // Update existed news
        if ($message = $news->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(News $news)
    {
        // Delete news's image
        $news->deleteAllImages();
        // Delete news
        $news->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
    /**
     * Delete image
     *
     * @param  News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteImage(News $news)
    {
        // Delete news's image
        $news->deleteImagesIfExist();
        // Do something
        return $this->afterDeletingImage();
    }
    
}
