<?php

namespace App\Modules\Callback\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Callback\Filters\CallbackFilter;
use App\Modules\Callback\Forms\AdminCallbackForm;
use App\Modules\Callback\Models\Callback;
use App\Modules\Callback\Requests\AdminCallbackRequest;
use Seo;

/**
 * Class CallbackController
 *
 * @package App\Modules\Callback\Controllers\Admin
 */
class CallbackController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('callback::seo.index', RouteObjectValue::make('admin.callback.index'));
    }

    /**
     * Callback sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('callback::seo.index');
        // Get callback
        $callback = Callback::getList();
        // Return view list
        return view('callback::admin.index', [
            'callback' => $callback,
            'filter' => CallbackFilter::showFilter()
        ]);
    }
    
    /**
     * Update element page
     *
     * @param  Callback $callback
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Callback $callback)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($callback->name ?? 'callback::seo.edit');
        // Set h1
        Seo::meta()->setH1('callback::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminCallbackRequest())->rules());
        // Return form view
        return view(
            'callback::admin.update', [
                'form' => AdminCallbackForm::make($callback),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  AdminCallbackRequest $request
     * @param  Callback $callback
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminCallbackRequest $request, Callback $callback)
    {
        // Fill new data
        $callback->fill($request->all());
        // Update existed page
        $callback->save();
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Callback $callback
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Callback $callback)
    {
        // Delete callback
        $callback->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
}
