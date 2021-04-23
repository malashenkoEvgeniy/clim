<?php

namespace App\Modules\SeoTemplates\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoTemplates\Forms\AdminSeoTemplatesForm;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use App\Modules\SeoTemplates\Requests\AdminSeoTemplatesRequest;
use Seo;

/**
 * Class SeoTemplatesController
 *
 * @package App\Modules\SeoTemplates\Controllers\Admin
 */
class SeoTemplatesController extends AdminController
{

    public function __construct()
    {
        Seo::breadcrumbs()->add('seo_templates::seo.index', RouteObjectValue::make('admin.seo_templates.index'));
    }

    /**
     * SeoTemplates sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('seo_templates::seo.index');
        // Get seo_templates
        $seoTemplates = SeoTemplate::getList();
        // Return view list
        return view('seo_templates::admin.index', ['seoTemplates' => $seoTemplates]);
    }

    /**
     * Update element page
     *
     * @param SeoTemplate $seoTemplate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SeoTemplate $seoTemplate)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($seoTemplate->name ?? 'seo_templates::seo.edit');
        // Set h1
        Seo::meta()->setH1('seo_templates::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminSeoTemplatesRequest())->rules());
        // Return form view
        return view('seo_templates::admin.update', [
            'form' => AdminSeoTemplatesForm::make($seoTemplate)
        ]);
    }

    /**
     * Update page in database
     *
     * @param AdminSeoTemplatesRequest $request
     * @param SeoTemplate $seoTemplate
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminSeoTemplatesRequest $request, SeoTemplate $seoTemplate)
    {
        // Update existed news
        if ($message = $seoTemplate->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }

    /**
     * Totally delete page from database
     *
     * @param SeoTemplate $seoTemplate
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(SeoTemplate $seoTemplate)
    {
        // Delete seo_templates
        $seoTemplate->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
}
