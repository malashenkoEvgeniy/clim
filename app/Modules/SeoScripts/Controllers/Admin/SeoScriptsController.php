<?php

namespace App\Modules\SeoScripts\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoScripts\Forms\AdminSeoScriptsForm;
use App\Modules\SeoScripts\Models\SeoScript;
use App\Modules\SeoScripts\Requests\AdminSeoScriptsRequest;
use Seo;

/**
 * Class SeoScriptsController
 *
 * @package App\Modules\SeoScripts\Controllers\Admin
 */
class SeoScriptsController extends AdminController
{

    public function __construct()
    {
        Seo::breadcrumbs()->add('seo_scripts::seo.index', RouteObjectValue::make('admin.seo_scripts.index'));
    }

    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new seoScript button
        $this->addCreateButton('admin.seo_scripts.create');
    }

    /**
     * SeoScripts sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('seo_scripts::seo.index');
        // Get seo_scripts
        $seoScripts = SeoScript::getList();
        // Return view list
        return view('seo_scripts::admin.index', ['seoScripts' => $seoScripts]);
    }

    /**
     * Create new seoScripts page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('seo_scripts::seo.create');
        // Set h1
        Seo::meta()->setH1('seo_scripts::seo.create');
        // Javascript validation
        $this->initValidation((new AdminSeoScriptsRequest)->rules());
        // Return form view
        return view(
            'seo_scripts::admin.create', [
                'form' => AdminSeoScriptsForm::make(),
            ]
        );
    }

    /**
     * Create seoScripts in database
     *
     * @param  AdminSeoScriptsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminSeoScriptsRequest $request)
    {
        $seoScript = new SeoScript();
        // Fill new data
        $seoScript->fill($request->all());
        // Create new page
        $seoScript->save();
        // Do something
        return $this->afterStore(['id' => $seoScript->id]);
    }

    /**
     * Update element page
     *
     * @param SeoScript $seoScript
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SeoScript $seoScript)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($seoScript->name ?? 'seo_scripts::seo.edit');
        // Set h1
        Seo::meta()->setH1('seo_scripts::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminSeoScriptsRequest())->rules());
        // Return form view
        return view('seo_scripts::admin.update', [
            'form' => AdminSeoScriptsForm::make($seoScript)
        ]);
    }

    /**
     * Update page in database
     *
     * @param SeoScript $seoScript
     * @param AdminSeoScriptsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminSeoScriptsRequest $request, SeoScript $seoScript)
    {
        // Fill new data
        $seoScript->fill($request->all());
        // Create new page
        $seoScript->save();
        // Do something
        return $this->afterUpdate(['id' => $seoScript->id]);
    }

    /**
     * Totally delete page from database
     *
     * @param SeoScript $seoScript
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(SeoScript $seoScript)
    {
        // Delete seo_scripts
        $seoScript->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
}
