<?php

namespace App\Modules\FastOrders\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\FastOrders\Filters\FastOrdersFilter;
use App\Modules\FastOrders\Forms\AdminFastOrdersForm;
use App\Modules\FastOrders\Models\FastOrder;
use App\Modules\FastOrders\Requests\AdminFastOrdersRequest;
use Seo;

/**
 * Class FastOrdersController
 *
 * @package App\Modules\FastOrders\Controllers\Admin
 */
class FastOrdersController extends AdminController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('fast_orders::seo.index', RouteObjectValue::make('admin.fast_orders.index'));
    }

    /**
     * FastOrders sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('fast_orders::seo.index');
        // Get fastOrders
        $fastOrders = FastOrder::getList();
        // Return view list
        return view('fast_orders::admin.index', [
            'fastOrders' => $fastOrders,
            'filter' => FastOrdersFilter::showFilter()
        ]);
    }
    
    /**
     * Update element page
     *
     * @param  FastOrder $fastOrder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(FastOrder $fastOrder)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($fastOrder->name ?? 'fast_orders::seo.edit');
        // Set h1
        Seo::meta()->setH1('fast_orders::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminFastOrdersRequest())->rules());
        // Return form view
        return view(
            'fast_orders::admin.update', [
                'form' => AdminFastOrdersForm::make($fastOrder),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  AdminFastOrdersRequest $request
     * @param  FastOrder $fastOrder
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminFastOrdersRequest $request, FastOrder $fastOrder)
    {
        // Fill new data
        $fastOrder->fill($request->all());
        // Update existed page
        $fastOrder->save();
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  FastOrder $fastOrder
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(FastOrder $fastOrder)
    {
        // Delete callback
        $fastOrder->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
}
