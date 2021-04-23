<?php

namespace App\Core\Modules\SystemPages\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Core\Modules\SystemPages\Filters\SystemPagesFilter;
use App\Core\Modules\SystemPages\Forms\SystemPageForm;
use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\Modules\SystemPages\Requests\SystemPageRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class PagesController
 *
 * @package App\Modules\Pages\Controllers\Admin
 */
class SystemPagesController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('system_pages::seo.index', RouteObjectValue::make('admin.system_pages.index'));
    }

    /**
     * System pages list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('system_pages::seo.index');
        // Get pages
        $systemPages = (new SystemPage)->getList();
        // Return view with sortable pages list
        return view('system_pages::admin.index', [
            'systemPages' => $systemPages,
            'filter' => SystemPagesFilter::showFilter(),
        ]);
    }
    
    /**
     * Update element page
     *
     * @param  SystemPage $systemPage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SystemPage $systemPage)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($systemPage->dataForCurrentLanguage()->name ?? 'system_pages::seo.edit');
        // Set h1
        Seo::meta()->setH1('system_pages::seo.edit');
        // Javascript validation
        $this->initValidation((new SystemPageRequest())->rules());
        // Return form view
        return view(
            'system_pages::admin.update', [
                'form' => SystemPageForm::make($systemPage),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  SystemPageRequest $request
     * @param  SystemPage $systemPage
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(SystemPageRequest $request, SystemPage $systemPage)
    {
        // Update existed page
        if ($message = $systemPage->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
}
