<?php

namespace App\Modules\SeoLinks\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoLinks\Filters\SeoLinksFilter;
use App\Modules\SeoLinks\Forms\AdminSeoLinksForm;
use App\Modules\SeoLinks\Models\SeoLink;
use App\Modules\SeoLinks\Requests\AdminSeoLinksRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class SeoLinksController
 *
 * @package App\Modules\SeoLinks\Controllers\Admin
 */
class SeoLinksController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('seo_links::seo.index', RouteObjectValue::make('admin.seo_links.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new seoLinks button
        $this->addCreateButton('admin.seo_links.create');
    }
    
    /**
     * SeoLinks sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('seo_links::seo.index');
        // Get seoLinks
        $seoLinks = SeoLink::getList();
        // Return view list
        return view('seo_links::admin.index', [
            'seoLinks' => $seoLinks,
            'filter' => SeoLinksFilter::showFilter(),
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
        Seo::breadcrumbs()->add('seo_links::seo.create');
        // Set h1
        Seo::meta()->setH1('seo_links::seo.create');
        // Javascript validation
        $this->initValidation((new AdminSeoLinksRequest())->rules());
        // Return form view
        return view('seo_links::admin.create', [
            'form' => AdminSeoLinksForm::make(),
        ]);
    }
    
    /**
     * Create page in database
     *
     * @param  AdminSeoLinksRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminSeoLinksRequest $request)
    {
        $seoLink = (new SeoLink);
        // Create new seoLinks
        if ($message = $seoLink->createRow($request)) {
            return $this->afterFail($message);
        }
        return $this->afterStore(['id' => $seoLink->id]);
    }
    
    /**
     * Update element page
     *
     * @param  SeoLink $seoLink
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SeoLink $seoLink)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($seoLink->name ?? 'seo_links::seo.edit');
        // Set h1
        Seo::meta()->setH1('seo_links::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminSeoLinksRequest)->rules());
        // Return form view
        return view(
            'seo_links::admin.update', [
                'form' => AdminSeoLinksForm::make($seoLink),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  AdminSeoLinksRequest $request
     * @param  SeoLink $seoLink
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminSeoLinksRequest $request, SeoLink $seoLink)
    {
        if ($message = $seoLink->updateRow($request)) {
            return $this->afterFail($message);
        }
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  SeoLink $seoLink
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(SeoLink $seoLink)
    {
        // Delete seoLinks
        $seoLink->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
}
