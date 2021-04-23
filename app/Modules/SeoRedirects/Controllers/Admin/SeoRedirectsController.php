<?php

namespace App\Modules\SeoRedirects\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoRedirects\Filters\SeoRedirectsFilter;
use App\Modules\SeoRedirects\Forms\AdminSeoRedirectsForm;
use App\Modules\SeoRedirects\Models\SeoRedirect;
use App\Modules\SeoRedirects\Requests\AdminSeoRedirectsRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class SeoRedirectsController
 *
 * @package App\Modules\SeoRedirects\Controllers\Admin
 */
class SeoRedirectsController extends AdminController
{

    public function __construct()
    {
        Seo::breadcrumbs()->add('seo_redirects::seo.index', RouteObjectValue::make('admin.seo_redirects.index'));
    }

    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new seoRedirects button
        $this->addCreateButton('admin.seo_redirects.create');
    }

    /**
     * SeoRedirects sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('seo_redirects::seo.index');
        // Get seoRedirects
        $seoRedirects = SeoRedirect::getList();
        // Return view list
        return view('seo_redirects::admin.index', [
            'seoRedirects' => $seoRedirects,
            'filter' => SeoRedirectsFilter::showFilter(),
        ]);
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
        Seo::breadcrumbs()->add('seo_redirects::seo.create');
        // Set h1
        Seo::meta()->setH1('seo_redirects::seo.create');
        // Javascript validation
        $this->initValidation((new AdminSeoRedirectsRequest())->rules());
        // Return form view
        return view('seo_redirects::admin.create', [
            'form' => AdminSeoRedirectsForm::make(),
        ]);
    }

    /**
     * Create page in database
     *
     * @param  AdminSeoRedirectsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminSeoRedirectsRequest $request)
    {
        $seoRedirect = new SeoRedirect();
        // Fill new data
        $seoRedirect->fill($request->all());
        // Create new page
        $seoRedirect->save();
        // Do something
        return $this->afterStore(['id' => $seoRedirect->id]);
    }

    /**
     * Update element page
     *
     * @param  SeoRedirect $seoRedirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SeoRedirect $seoRedirect)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($seoRedirect->name ?? 'seo_redirects::seo.edit');
        // Set h1
        Seo::meta()->setH1('seo_redirects::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminSeoRedirectsRequest)->rules());
        // Return form view
        return view('seo_redirects::admin.update', [
            'form' => AdminSeoRedirectsForm::make($seoRedirect),
        ]);
    }

    /**
     * Update page in database
     *
     * @param AdminSeoRedirectsRequest $request
     * @param SeoRedirect $seoRedirect
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminSeoRedirectsRequest $request, SeoRedirect $seoRedirect)
    {
        // Fill new data
        $seoRedirect->fill($request->all());
        // Create new page
        $seoRedirect->save();
        // Do something
        return $this->afterUpdate(['id' => $seoRedirect->id]);
    }

    /**
     * Totally delete page from database
     *
     * @param  SeoRedirect $seoRedirect
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(SeoRedirect $seoRedirect)
    {
        // Delete seoRedirects
        $seoRedirect->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
}
