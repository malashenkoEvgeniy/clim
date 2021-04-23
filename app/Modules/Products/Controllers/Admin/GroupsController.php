<?php

namespace App\Modules\Products\Controllers\Admin;

use App\Core\AdminController;
use App\Core\Modules\Images\Models\Image;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Features\Models\Feature;
use App\Modules\Features\Models\FeatureValue;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroupCategory;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use App\Modules\Products\Models\ProductGroupLabel;
use App\Modules\Products\Models\ProductGroupTranslates;
use App\Modules\Products\Models\ProductTranslates;
use App\Modules\Products\Models\ProductWholesale;
use App\Modules\Products\Requests\FeatureUpdateForFrontendRequest;
use App\Modules\Products\Requests\FeatureUpdateRequest;
use App\Modules\Products\Filters\ProductGroupAdminFilter;
use App\Modules\Products\Forms\GroupForm;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Requests\GroupFrontendRequest;
use App\Modules\Products\Requests\GroupRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Seo;

/**
 * Class ProductsController
 *
 * @package App\Modules\Products\Controllers\Admin
 */
class GroupsController extends AdminController
{
    /**
     * Add basic breadcrumbs
     */
    private function addBaseBreadcrumbs()
    {
        Seo::breadcrumbs()->add(
            'products::seo.groups.index',
            RouteObjectValue::make('admin.groups.index')
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
        $this->addCreateButton('admin.groups.create');
        Seo::meta()->setH1('products::seo.groups.index');
        return view('products::admin.groups.index', [
            'groups' => ProductGroup::getList(),
            'filter' => ProductGroupAdminFilter::showFilter(),
        ]);
    }
    
    /**
     * Create product page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        $this->addBaseBreadcrumbs();
        Seo::breadcrumbs()->add('products::seo.groups.create');
        Seo::meta()->setH1('products::seo.groups.create');
        $this->jsValidation(new GroupFrontendRequest);
        return view('products::admin.groups.create', [
            'form' => GroupForm::make(),
        ]);
    }
    
    /**
     * Store new product
     *
     * @param GroupRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public function store(GroupRequest $request)
    {
        $group = ProductGroup::store($request);
        return $this->afterStore([$group->id]);
    }
    
    /**
     * Update category page
     *
     * @param ProductGroup $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(ProductGroup $group)
    {
        $this->addBaseBreadcrumbs();
        Seo::breadcrumbs()->add($group->current->name ?? 'products::seo.groups.edit');
        Seo::meta()->setH1('products::seo.groups.edit');
        $this->jsValidation(new GroupFrontendRequest);
        return view('products::admin.groups.update', [
            'form' => GroupForm::make($group),
            'group' => $group,
        ]);
    }
    
    /**
     * Update information for current category
     *
     * @param GroupRequest $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public function update(GroupRequest $request, ProductGroup $group)
    {
        $group->edit($request);
        return $this->afterUpdate();
    }
    
    /**
     * Delete all data for category including images
     *
     * @param ProductGroup $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(ProductGroup $group)
    {
        $group->products->each(function (Product $product) {
            $product->deleteRow();
        });
        $group->deleteRow();
        return $this->afterDestroy();
    }
    
    /**
     * Action to change active status of a model
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function active($id)
    {
        $group = ProductGroup::findOrFail($id);
        $group->toggleActiveStatus();
        return response()->json(['success' => true]);
    }
    
    /**
     * @param ProductGroup $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeFeature(ProductGroup $group)
    {
        $this->addBaseBreadcrumbs();
        Seo::breadcrumbs()->add('products::seo.groups.change-feature');
        Seo::meta()->setH1('products::seo.groups.change-feature');
        
        $features = [];
        $featuresObjects = Feature::with('current')->where('id', '!=', $group->feature_id)->get();
        $featuresObjects->each(function (Feature $feature) use (&$features) {
            $features[$feature->id] = $feature->current->name;
        });
    
        $values = [];
        if ($featuresObjects->isNotEmpty() && $featuresObjects->first()->values) {
            $featuresObjects->first()->values->each(function (FeatureValue $value) use (&$values) {
                $values[$value->id] = $value->current->name;
            });
        }
        
        $this->jsValidation(new FeatureUpdateForFrontendRequest);
        
        return view('products::admin.feature.update', [
            'group' => $group,
            'features' => $features,
            'values' => $values,
        ]);
    }
    
    /**
     * @param FeatureUpdateRequest $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function changeFeatureConfirmation(FeatureUpdateRequest $request, ProductGroup $group)
    {
        $featureId = $request->input('feature_id');
        $group->update(['feature_id' => $featureId]);
        ProductGroupFeatureValue::whereGroupId($group->id)->where('feature_id', $featureId)->delete();
        $group->products->each(function (Product $product) use ($request, $featureId, $group) {
            $valueId = $request->input('value.' . $product->id);
            ProductGroupFeatureValue::create([
                'product_id' => $product->id,
                'group_id' => $group->id,
                'feature_id' => $featureId,
                'value_id' => $valueId,
            ]);
            $product->update([
                'value_id' => $valueId,
            ]);
        });
        return $this->customRedirect(
            'admin.groups.edit',
            [$group->id],
            trans('products::admin.feature-changed-successfully')
        );
    }

    /**
     * @param ProductGroup $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cloneGroup(ProductGroup $group)
    {
        $newGroup = $group->replicate();
        $newGroup->active = 0;
        $newGroup->available = 0;
        $newGroup->save();

        $group->data->each(function (ProductGroupTranslates $translates) use ($newGroup) {
            $newTranslate = $translates->replicate();
            $newTranslate->row_id = $newGroup->id;
            $newTranslate->save();
        });

        $group->images->each(function (Image $image) use ($newGroup){
            if ($image->isImageExists()) {
                if (file_exists(storage_path('app/public/products/' . $image->name))) {
                   $newGroup->uploadImageFromResource(new UploadedFile(storage_path('app/public/products/' . $image->name), $image->name));
                }
            }
        });

        foreach ($group->getOtherCategoriesIdsAttribute() as $category) {
            $productGroupCategory = new ProductGroupCategory;
            $productGroupCategory->category_id = $category;
            $productGroupCategory->group_id = $newGroup->id;
            $productGroupCategory->save();
        }

        foreach ($group->labels as $label) {
            $newGroupLabel = new ProductGroupLabel();
            $newGroupLabel->group_id = $newGroup->id;
            $newGroupLabel->label_id = $label->id;
        }


        $group->products->each(function(Product $product) use ($newGroup){

            $newProduct = $product->replicate();
            $newProduct->group_id = $newGroup->id;
            $newProduct->is_main = 0;
            $newProduct->save();

            $product->feature_values->each(function (ProductGroupFeatureValue $value) use ($newProduct, $newGroup){
                $newValue = $value->replicate();
                $newValue->product_id = $newProduct->id;
                $newValue->group_id = $newGroup->id;
                $newValue->save();
            });

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

        });

        return $this->customRedirect(
            'admin.groups.edit',
            [$newGroup->id],
            trans('products::admin.group-cloned-successfully')
        );
    }
}
