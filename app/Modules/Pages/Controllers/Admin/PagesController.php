<?php

namespace App\Modules\Pages\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Pages\Forms\PagesForm;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Requests\PageRequest;
use Seo;
use App\Core\AdminController;
use Illuminate\Http\Request;

/**
 * Class PagesController
 *
 * @package App\Modules\Pages\Controllers\Admin
 */
class PagesController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('pages::seo.index', RouteObjectValue::make('admin.pages.index'));
    }
    
    /**
     * Pages sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->addCreateButton('admin.pages.create');
        // Set h1
        Seo::meta()->setH1('pages::seo.index');
        // Get pages
        $pages = Page::getList(0);
        // Check if pages exist
        if ($pages->count() > 0) {
            // Return view with sortable pages list
            return view('pages::admin.index', ['pages' => $pages]);
        } else {
            // Return view with message
            return view('pages::admin.no-pages');
        }
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
        Seo::breadcrumbs()->add('pages::seo.create');
        // Set h1
        Seo::meta()->setH1('pages::seo.create');
        // Javascript validation
        $this->initValidation((new PageRequest())->rules());
        // Return form view
        return view(
            'pages::admin.create', [
                'form' => PagesForm::make(),
            ]
        );
    }
    
    /**
     * Create page in database
     *
     * @param  PageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(PageRequest $request)
    {
        $page = (new Page);
        // Create new page
        if ($message = $page->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $page->id]);
    }
    
    /**
     * Update element page
     *
     * @param  Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Page $page)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($page->current->name ?? 'pages::seo.edit');
        // Set h1
        Seo::meta()->setH1('pages::seo.edit');
        // Javascript validation
        $this->initValidation((new PageRequest)->rules());
        // Return form view
        return view(
            'pages::admin.update', [
                'form' => PagesForm::make($page),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  PageRequest $request
     * @param  Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(PageRequest $request, Page $page)
    {
        // Update existed page
        if ($message = $page->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Page $page)
    {
        // Put kids of currently deleting page to his parent
        $page->setOtherParentIdForKids();
        // Delete page
        $page->deleteRow();
        // Do something
        return $this->afterDestroy();
    }
    
}
