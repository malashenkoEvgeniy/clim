<?php

namespace App\Modules\Services\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Services\Forms\ServiceForm;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Models\ServicesRubric;
use App\Modules\Services\Requests\ServiceRequest;
use Seo;

/**
 * Class ServicesControllerController
 *
 * @package App\Modules\Services\Controllers\Admin
 */
class ServicesController extends AdminController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('services::seo.index', RouteObjectValue::make('admin.services.index'));
    }

    public function index()
    {
        // Set rubrics buttons on the top of the page
        $this->addCreateButton('admin.services.create');

        // Set h1
        Seo::meta()->setH1('services::seo.index');

        // Get rubrics

        $services = Service::getList(0);
//        dd($services);

        // Check if rubrics exist
        if ($services->count() > 0) {
            // Return view with sortable rubrics list
            return view('services::admin.services.index', ['services' => $services]);
        } else {
            // Return view with message
            return view('services::admin.services.no-services');
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
        Seo::breadcrumbs()->add('services::seo.create');

        // Set h1
        Seo::meta()->setH1('services::seo.create');

        // Javascript validation
        $this->initValidation((new ServiceRequest())->rules());
        $categories = ServicesRubric::with('translations')->get();

        // Return form view
        return view(
            'services::admin.services.create', [
                'form' => ServiceForm::make(),
                'categories'=>$categories
            ]
        );
    }

    /**
     * Create service rubric in database
     *
     * @param  ServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(ServiceRequest $request)
    {
//        dd($request);
        $service = (new Service);
        // Create new service

        if ($message = $service->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $service->id]);
    }

    /**
     * Update element service
     *
     * @param  Service $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Service $service)
    {  // dd($service);
        // Breadcrumb
        Seo::breadcrumbs()->add($service->current->name ?? 'services::seo.edit');
        // Set h1
        Seo::meta()->setH1('service::seo.edit');
        // Javascript validation
        $this->initValidation((new ServiceRequest)->rules());
        $categories = ServicesRubric::with('translations')->get();
        // Return form view

        return view(
            'services::admin.services.update', [
                'form' => ServiceForm::make($service),
                'categories'=>$categories,
                'service'=>$service
            ]
        );
    }

    /**
     * Update service in database
     *
     * @param  ServiceRequest $request
     * @param  Service $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ServiceRequest $request, Service $service)
    {
        // Update existed page
        if ($message = $service->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }

    /**
     * Totally delete service from database
     *
     * @param  Service $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy( $page)
    {

        // Delete page
       Service::destroy($page);

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
    public function deleteImage(Service $service)
    {
        $service->deleteImagesIfExist();
        return $this->afterDeletingImage();
    }
}
