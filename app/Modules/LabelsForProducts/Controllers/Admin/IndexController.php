<?php

namespace App\Modules\LabelsForProducts\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\LabelsForProducts\Forms\LabelForm;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\LabelsForProducts\Requests\LabelRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class IndexController
 *
 * @package App\Modules\LabelsForProducts\Controllers\Admin
 */
class IndexController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('labels::seo.index', RouteObjectValue::make('admin.product-labels.index'));
    }
    
    /**
     * Brands list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->addCreateButton('admin.product-labels.create');
        // Set h1
        Seo::meta()->setH1('labels::seo.index');
        // Get article
        $labels = Label::getList();
        if ($labels->count() > 0) {
            return view('labels::admin.index', [
                'labels' => $labels,
            ]);
        }
        return view('labels::admin.no-pages');
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
        Seo::breadcrumbs()->add('labels::seo.create');
        // Set h1
        Seo::meta()->setH1('labels::seo.create');
        // Javascript validation
        $this->initValidation((new LabelRequest())->rules());
        // Return form view
        return view('labels::admin.create', [
            'form' => LabelForm::make(),
        ]);
    }
    
    /**
     * Create page in database
     *
     * @param  LabelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(LabelRequest $request)
    {
        $label = new Label;
        // Create new article
        if ($message = $label->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $label->id]);
    }
    
    /**
     * Update element page
     *
     * @param  Label $label
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Label $label)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($label->current->name ?? 'labels::seo.edit');
        // Set h1
        Seo::meta()->setH1('labels::seo.edit');
        // Javascript validation
        $this->initValidation((new LabelRequest)->rules());
        // Return form view
        return view('labels::admin.update', [
            'form' => LabelForm::make($label),
        ]);
    }
    
    /**
     * Update page in database
     *
     * @param  LabelRequest $request
     * @param  Label $label
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(LabelRequest $request, Label $label)
    {
        // Update existed article
        if ($message = $label->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Label $label
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Label $label)
    {
        $labelId = $label->id;
        // Delete article
        $label->deleteRow();
        // Do something
        event('labels::deleted', $labelId);
        return $this->afterDestroy();
    }
    
}
