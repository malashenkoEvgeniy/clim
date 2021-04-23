<?php

namespace App\Modules\Services\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Services\Forms\ServicesRubricsForm;
use App\Modules\Services\Models\ServicesRubric;
use App\Modules\Services\Requests\ServicesRubricsRequest;
use Seo;

/**
 * Class ServicesRubricsControllerController
 *
 * @package App\Modules\Services\Controllers\Admin
 */
class ServicesRubricsController extends AdminController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('services::seo.index-rubrics', RouteObjectValue::make('admin.services_rubrics.index'));
    }


    public function index()
    {

        // Set rubrics buttons on the top of the page
        $this->addCreateButton('admin.services_rubrics.create');

        // Set h1
        Seo::meta()->setH1('services::seo.index-rubrics');

        // Get rubrics
        $servicesRubrics = ServicesRubric::getList(0);

        // Check if rubrics exist
        if ($servicesRubrics->count() > 0) {
            // Return view with sortable rubrics list
            return view('services::admin.rubrics.index', ['servicesRubrics' => $servicesRubrics]);
        } else {
            // Return view with message
            return view('services::admin.rubrics.no-rubrics');
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
        Seo::breadcrumbs()->add('services::seo.create-rubrics');

        // Set h1
        Seo::meta()->setH1('services::seo.create-rubrics');

        // Javascript validation
        $this->initValidation((new ServicesRubricsRequest())->rules());
        // Return form view
        return view(
            'services::admin.rubrics.create', [
                'form' => ServicesRubricsForm::make(),
            ]
        );
    }

    /**
     * Create service rubric in database
     *
     * @param  ServicesRubricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(ServicesRubricsRequest $request)
    {

        $serviceRubric = (new ServicesRubric);

        // Create new page
        if ($message = $serviceRubric->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $serviceRubric->id]);
    }

    /**
     * Update element page
     *
     * @param  ServicesRubric $servicesRubric
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(ServicesRubric $servicesRubric)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($servicesRubric->current->name ?? 'services::seo.edit-rubric');
        // Set h1
        Seo::meta()->setH1('services::seo.edit-rubric');
        // Javascript validation
        $this->initValidation((new ServicesRubricsRequest)->rules());
        // Return form view
          dd($servicesRubric);
        return view(
            'services::admin.rubrics.update', [
                'form' => ServicesRubricsForm::make($servicesRubric),
            ]
        );
    }

    /**
     * Update service in database
     *
     * @param  ServicesRubricsRequest $request
     * @param  ServicesRubric $servicesRubric
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ServicesRubricsRequest $request, ServicesRubric $servicesRubric)
    {
        // Update existed page
        if ($message = $servicesRubric->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }

    /**
     * Totally delete service from database
     *
     * @param  ServicesRubric $servicesRubric
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy($page)
    {
        // Delete page
        ServicesRubric::destroy($page);
        // Do something
        return $this->afterDestroy();
    }

    /**
     * Delete preview in category
     *
     * @param ServicesRubric $servicesRubric
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteImage(ServicesRubric $servicesRubric)
    {
        $servicesRubric->deleteImagesIfExist();
        return $this->afterDeletingImage();
    }

}