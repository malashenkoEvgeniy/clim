<?php

namespace App\Modules\Brands\Controllers\Admin;

use App\Modules\Brands\Filters\BrandsFilter;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Brands\Forms\BrandForm;
use App\Modules\Brands\Models\Brand;
use App\Modules\Brands\Models\BrandTranslates;
use App\Modules\Brands\Requests\BrandRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class IndexController
 *
 * @package App\Modules\Brands\Controllers\Admin
 */
class IndexController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('brands::seo.index', RouteObjectValue::make('admin.brands.index'));
    }
    
    /**
     * Brands list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        $this->addCreateButton('admin.brands.create');
        Seo::meta()->setH1('brands::seo.index');
        $brands = Brand::getList();
        return view('brands::admin.index', [
            'brands' => $brands,
            'filter' => BrandsFilter::showFilter(),
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
        Seo::breadcrumbs()->add('brands::seo.create');
        Seo::meta()->setH1('brands::seo.create');
        $this->initValidation((new BrandRequest())->rules());
        return view('brands::admin.create', [
            'form' => BrandForm::make(),
        ]);
    }
    
    /**
     * Create page in database
     *
     * @param  BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(BrandRequest $request)
    {
        $brand = (new Brand);
        if ($message = $brand->createRow($request)) {
            return $this->afterFail($message);
        }
        return $this->afterStore(['id' => $brand->id]);
    }
    
    /**
     * Update element page
     *
     * @param  Brand $brand
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Brand $brand)
    {
        Seo::breadcrumbs()->add($brand->current->name ?? 'brands::seo.edit');
        Seo::meta()->setH1('brands::seo.edit');
        $this->initValidation((new BrandRequest)->rules());
        return view('brands::admin.update', [
            'form' => BrandForm::make($brand),
        ]);
    }
    
    /**
     * Update page in database
     *
     * @param  BrandRequest $request
     * @param  Brand $brand
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $brands = [];
        $brand->data->each(function (BrandTranslates $translate) use (&$brands) {
            $brands[$translate->language] = $translate->slug;
        });
        
        // Update existed article
        if ($message = $brand->updateRow($request)) {
            return $this->afterFail($message);
        }
        
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Brand $brand
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Brand $brand)
    {
        $brandId = $brand->id;
        $brands = [];
        $brand->data->each(function (BrandTranslates $translate) use (&$brands) {
            $brands[$translate->language] = $translate->slug;
        });
        $brand->deleteRow();
        return $this->afterDestroy();
    }
    
}
