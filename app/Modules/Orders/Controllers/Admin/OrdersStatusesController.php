<?php

namespace App\Modules\Orders\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Orders\Forms\OrderStatusForm;
use App\Modules\Orders\Models\OrderStatus;
use App\Modules\Orders\Requests\OrderStatusRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class OrderStatusesController
 *
 * @package App\Modules\Orders\Controllers\Admin
 */
class OrdersStatusesController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add(
            'orders::seo.statuses.index',
            RouteObjectValue::make('admin.orders-statuses.index')
        );
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        $this->addCreateButton('admin.orders-statuses.create');
    }
    
    /**
     * Pages sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('orders::seo.statuses.index');
        $statuses = OrderStatus::getList();
        return view('orders::admin.statuses.index', ['statuses' => $statuses]);
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
        Seo::breadcrumbs()->add('orders::seo.statuses.create');
        // Set h1
        Seo::meta()->setH1('orders::seo.statuses.create');
        // Javascript validation
        $this->initValidation((new OrderStatusRequest())->rules());
        // Return form view
        return view('orders::admin.statuses.create', [
            'form' => OrderStatusForm::make(),
        ]);
    }
    
    /**
     * Store to database
     *
     * @param  OrderStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(OrderStatusRequest $request)
    {
        $status = (new OrderStatus());
        if ($message = $status->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $status->id]);
    }
    
    /**
     * Update element page
     *
     * @param  OrderStatus $status
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(OrderStatus $status)
    {
        Seo::breadcrumbs()->add($status->current->name ?? 'orders::seo.statuses.edit');
        Seo::meta()->setH1('orders::seo.statuses.edit');
        $this->initValidation((new OrderStatusRequest)->rules());
        return view('orders::admin.statuses.update', [
            'form' => OrderStatusForm::make($status),
        ]);
    }
    
    /**
     * Update element in database
     *
     * @param  OrderStatusRequest $request
     * @param  OrderStatus $status
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(OrderStatusRequest $request, OrderStatus $status)
    {
        if ($message = $status->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete element from database
     *
     * @param  OrderStatus $status
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(OrderStatus $status)
    {
        if ($status->editable) {
            $status->deleteRow();
        }
        return $this->afterDestroy();
    }
}
