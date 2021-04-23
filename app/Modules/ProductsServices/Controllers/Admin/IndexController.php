<?php

namespace App\Modules\ProductsServices\Controllers\Admin;

use App\Core\AdminController;
use App\Core\Modules\Images\Models\Image;
use App\Core\ObjectValues\RouteObjectValue;
use App\Exceptions\WrongParametersException;
use App\Modules\Pages\Forms\PagesForm;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Requests\PageRequest;
use App\Modules\ProductsServices\Filters\ProductsAdminFilter;
use App\Modules\ProductsServices\Forms\ProductServiceForm;
use App\Modules\ProductsServices\Models\Product;
use App\Modules\ProductsServices\Models\ProductService;
use App\Modules\ProductsServices\Models\ProductTranslates;
use App\Modules\ProductsServices\Models\ProductWholesale;
use App\Modules\ProductsServices\Requests\ProductServiceRequest;
use Illuminate\Support\Str;
use Seo;

/**
 * Class IndexController
 *
 * @package App\Modules\ProductsServices\Controllers\Admin
 */
class IndexController extends AdminController
{
    /**
     * Add basic breadcrumbs
     */
    private function addBaseBreadcrumbs()
    {
        Seo::breadcrumbs()->add(
            'products_services::seo.index',
            RouteObjectValue::make('admin.products-services.index')
        );
    }
    
    /**
     * Products services list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        $this->addCreateButton('admin.products-services.create');
        $this->addBaseBreadcrumbs();
        Seo::meta()->setH1('products_services::seo.index');
        return view('products_services::admin.index', [
            'services' => ProductService::getList(),
        ]);
    }
    
    /**
     * Create new element page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        $this->addBaseBreadcrumbs();
        // Breadcrumb
        Seo::breadcrumbs()->add('products_services::seo.create');
        // Set h1
        Seo::meta()->setH1('products_services::seo.create');
        // Javascript validation
        $this->jsValidation(new ProductServiceRequest);
        // Return form view
        return view('products_services::admin.create', [
            'form' => ProductServiceForm::make(),
        ]);
    }
    
    /**
     * Create page in database
     *
     * @param  ProductServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(ProductServiceRequest $request)
    {
        $service = new ProductService;
        // Create new page
        if ($message = $service->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $service->id]);
    }
    
    /**
     * Update element page
     *
     * @param  ProductService $productsService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(ProductService $productsService)
    {
        $this->addBaseBreadcrumbs();
        // Breadcrumb
        Seo::breadcrumbs()->add($productsService->current->name ?? 'products_services::seo.edit');
        // Set h1
        Seo::meta()->setH1('products_services::seo.edit');
        // Javascript validation
        $this->jsValidation(new ProductServiceRequest);
        // Return form view
        return view('products_services::admin.update', [
            'form' => ProductServiceForm::make($productsService),
        ]);
    }
    
    /**
     * Update page in database
     *
     * @param  ProductServiceRequest $request
     * @param  ProductService $productsService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ProductServiceRequest $request, ProductService $productsService)
    {
        // Update existed page
        if ($message = $productsService->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  ProductService $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(ProductService $service)
    {
        abort_if($service->system, 404);
        // Delete page
        $service->deleteRow();
        // Do something
        return $this->afterDestroy();
    }
}
