<?php

namespace App\Modules\Consultations\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Consultations\Filters\ConsultationFilter;
use App\Modules\Consultations\Forms\AdminConsultationsForm;
use App\Modules\Consultations\Models\Consultation;
use App\Modules\Consultations\Requests\AdminConsultationsRequest;
use Seo;

/**
 * Class consultationController
 *
 * @package App\Modules\consultation\Controllers\Admin
 */
class ConsultationController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('consultations::seo.index', RouteObjectValue::make('admin.consultations.index'));
    }

    /**
     * Consultation sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('consultations::seo.index');
        // Get consultation
        $consultations = Consultation::getList();
        // Return view list
        return view('consultations::admin.index', [
            'consultations' => $consultations,
            'filter' => ConsultationFilter::showFilter()
        ]);
    }
    
    /**
     * Update element page
     *
     * @param  Consultation $consultation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Consultation $consultation)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($consultation->name ?? 'consultations::seo.edit');
        // Set h1
        Seo::meta()->setH1('consultations::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminConsultationsRequest())->rules());
        // Return form view
        return view('consultations::admin.update', [
            'form' => AdminConsultationsForm::make($consultation),
        ]);
    }
    
    /**
     * Update page in database
     *
     * @param  AdminConsultationsRequest $request
     * @param  Consultation $consultation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminConsultationsRequest $request, Consultation $consultation)
    {
        // Fill new data
        $consultation->fill($request->all());
        // Update existed page
        $consultation->save();
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Consultation $consultation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Consultation $consultation)
    {
        // Delete consultation
        $consultation->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
}
