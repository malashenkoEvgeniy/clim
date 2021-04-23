<?php

namespace App\Modules\ProductsAvailability\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\ProductsAvailability\Filters\ProductsAvailabilityFilter;
use App\Modules\ProductsAvailability\Forms\AdminProductsAvailabilityForm;
use App\Modules\ProductsAvailability\Models\ProductsAvailability;
use App\Modules\ProductsAvailability\Requests\AdminProductsAvailabilityRequest;
use Seo;

/**
 * Class IndexController
 *
 * @package App\Modules\ProductsAvailability\Controllers\Admin
 */
class IndexController extends AdminController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('products-availability::seo.index', RouteObjectValue::make('admin.products_availability.index'));
    }

    /**
     * Index sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('products-availability::seo.index');
        // Get $orders
        $orders = ProductsAvailability::getList();
        // Return view list
        return view('products_availability::admin.index', [
            'orders' => $orders,
            'filter' => ProductsAvailabilityFilter::showFilter()
        ]);
    }

    /**
     * Update element page
     *
     * @param  ProductsAvailability $productsAvailability
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(ProductsAvailability $productsAvailability)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($productsAvailability->name ?? 'products-availability::seo.edit');
        // Set h1
        Seo::meta()->setH1('products-availability::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminProductsAvailabilityRequest())->rules());
        // Return form view
        return view(
            'products_availability::admin.update', [
                'form' => AdminProductsAvailabilityForm::make($productsAvailability),
            ]
        );
    }

    /**
     * Update page in database
     *
     * @param  AdminProductsAvailabilityRequest $request
     * @param  ProductsAvailability $productsAvailability
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminProductsAvailabilityRequest $request, ProductsAvailability $productsAvailability)
    {
        // Fill new data
        $productsAvailability->fill($request->all());
        // Update existed page
        $productsAvailability->save();
        // Do something
        return $this->afterUpdate();
    }

    /**
     * Totally delete page from database
     *
     * @param  ProductsAvailability $productsAvailability
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(ProductsAvailability $productsAvailability)
    {
        // Delete callback
        $productsAvailability->delete();
        // Do something
        return $this->afterDestroy();
    }

    /**
     * Restore deleted productsAvailability
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function restore($id)
    {
        // Get trashed user
        $productsAvailability = ProductsAvailability::withTrashed()->find($id);
        // Restore
        $productsAvailability->restore();
        // Do something
        return $this->afterRestore();
    }
}
