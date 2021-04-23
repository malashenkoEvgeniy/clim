<?php

namespace App\Modules\Products\Controllers\Admin;

use App\Core\AdminController;
use App\Core\AjaxTrait;
use App\Core\Modules\Images\Models\Image;
use App\Core\ObjectValues\RouteObjectValue;
use App\Exceptions\WrongParametersException;
use App\Modules\Products\Filters\ProductsAdminFilter;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductTranslates;
use App\Modules\Products\Models\ProductWholesale;
use Illuminate\Support\Str;
use Seo;

/**
 * Class ProductsController
 *
 * @package App\Modules\Products\Controllers\Admin
 */
class ProductsController extends AdminController
{
    use AjaxTrait;
    
    /**
     * Add basic breadcrumbs
     */
    private function addBaseBreadcrumbs()
    {
        Seo::breadcrumbs()->add(
            'products::seo.products.index',
            RouteObjectValue::make('admin.products.index')
        );
    }
    
    /**
     * Products list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        $this->addBaseBreadcrumbs();
        Seo::meta()->setH1('products::seo.products.index');
        return view('products::admin.product.index', [
            'products' => Product::getList(),
            'filter' => ProductsAdminFilter::showFilter(),
        ]);
    }
    
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create()
    {
        return $this->successJsonAnswer([
            'form' => view('products::admin.product.create', [
                'index' => (int)request()->query('index', 0),
            ])->render(),
        ]);
    }
    
    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function edit(Product $product)
    {
        return $this->successJsonAnswer([
            'form' => view('products::admin.product.update', [
                'product' => $product,
                'collapse' => false,
                'index' => (int)request()->query('index', 0),
            ])->render(),
        ]);
    }
    
    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws WrongParametersException
     */
    public function destroy(Product $product)
    {
        if ($product->is_main) {
            if (request()->expectsJson()) {
                throw new WrongParametersException(trans('admin.you-can-not-delete-main-modification'));
            }
            return $this->afterFail(trans('admin.you-can-not-delete-main-modification'));
        }
        if ($product->group && $product->group->products->count() <= 1) {
            if (request()->expectsJson()) {
                throw new WrongParametersException(trans('admin.you-can-not-delete-only-modification'));
            }
            return $this->afterFail(trans('admin.you-can-not-delete-only-modification'));
        }
        $product->deleteRow();
        if (request()->expectsJson()) {
            return $this->successJsonAnswer();
        }
        return $this->afterDestroy();
    }
    
    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAsMain(Product $product)
    {
        if ($product->is_main === false) {
            $product->setAsMain();
        }
        return $this->successJsonAnswer();
    }
    
    /**
     * @param Image $image
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteImage(Image $image)
    {
        $imageId = $image->id;
        $image->deleteImage();
        $image->delete();
        return $this->successJsonAnswer([
            'delete' => '.file-attach[data-id="' . $imageId . '"]',
        ]);
    }
    
    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function cloneProduct(Product $product)
    {
        $newProduct = $product->replicate();
        $newProduct->is_main = false;
        $newProduct->save();
        
        $product->data->each(function (ProductTranslates $translate) use ($newProduct) {
            $newTranslate = $translate->replicate();
            $newTranslate->row_id = $newProduct->id;
            $newTranslate->slug = Str::substr($newTranslate->slug . '-' . random_int(1000000, 9999999), 0, 190);
            $newTranslate->save();
        });
    
        $product->wholesale->each(function (ProductWholesale $wholesale) use ($newProduct) {
            $newWholesale = $wholesale->replicate();
            $newWholesale->product_id = $newProduct->id;
            $newWholesale->save();
        });
        
        return $this->successJsonAnswer([
            'form' => view('products::admin.product.update', [
                'product' => $newProduct->fresh(),
                'collapse' => false,
                'index' => (int)request()->query('index', 0),
            ])->render(),
        ]);
    }
}
