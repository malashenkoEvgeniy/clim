<?php

namespace App\Modules\Features\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Core\AdminController;
use App\Modules\Features\Models\Feature;
use App\Modules\Features\Forms\FeatureForm;
use App\Modules\Features\Models\FeatureTranslates;
use App\Modules\Features\Models\FeatureValue;
use App\Modules\Features\Requests\FeatureDestroyForFrontendRequest;
use App\Modules\Features\Requests\FeatureDestroyRequest;
use App\Modules\Features\Requests\FeatureRequest;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Seo;

class IndexController extends AdminController
{
    
    /**
     * Class IndexController
     *
     * @package App\Modules\Features\Controllers\Admin
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add('features::seo.index', RouteObjectValue::make('admin.features.index'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->addCreateButton('admin.features.create');
        Seo::meta()->setH1('features::seo.index');
        return view('features::admin.index', [
            'features' => Feature::getList(),
        ]);
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        Seo::breadcrumbs()->add('features::seo.create');
        Seo::meta()->setH1('features::seo.create');
        $this->initValidation((new FeatureRequest())->rules());
        return view('features::admin.create', [
            'form' => FeatureForm::make(),
        ]);
    }
    
    /**
     * @param FeatureRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(FeatureRequest $request)
    {
        $feature = (new Feature());
        $feature->active = true;
        if ($message = $feature->createRow($request)) {
            return $this->afterFail($message);
        }
        return $this->afterStore(['id' => $feature->id]);
    }
    
    /**
     * @param Feature $feature
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Feature $feature)
    {
        Seo::breadcrumbs()->add($feature->current->name ?? 'features::seo.edit');
        Seo::meta()->setH1('features::seo.edit');
        $this->initValidation((new FeatureRequest())->rules());
        return view('features::admin.update', [
            'feature' => $feature,
            'form' => FeatureForm::make($feature),
        ]);
    }
    
    /**
     * @param FeatureRequest $request
     * @param Feature $feature
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(FeatureRequest $request, Feature $feature)
    {
        $parameters = [];
        $feature->data->each(function (FeatureTranslates $translate) use (&$parameters) {
            $parameters[$translate->language] = $translate->slug;
        });
        
        if ($message = $feature->updateRow($request)) {
            return $this->afterFail($message);
        }
    
        return $this->afterUpdate();
    }
    
    /**
     * @param Feature $feature
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Feature $feature)
    {
        $countOfProductsWithThisFeature = ProductGroup::whereFeatureId($feature->id)->count();
        if ($countOfProductsWithThisFeature === 0) {
            $feature->deleteRow();
            return $this->afterDestroy();
        }
    
        Seo::breadcrumbs()->add('features::seo.destroy');
        Seo::meta()->setH1('features::seo.destroy');
        
        $usedValues = new Collection();
        Product::select(\DB::raw('DISTINCT value_id'))
            ->with('value', 'value.current')
            ->whereHas('value', function (Builder $builder) use ($feature) {
                $builder->where('feature_id', $feature->id);
            })
            ->get()
            ->each(function (Product $product) use ($usedValues) {
                $usedValues->push($product->value);
            });
        
        $features = [];
        $featuresObjects = Feature::with('current')->where('id', '!=', $feature->id)->get();
        $featuresObjects->each(function (Feature $feature) use (&$features) {
            $features[$feature->id] = $feature->current->name;
        });
        
        $values = [];
        if ($featuresObjects->isNotEmpty() && $featuresObjects->first()->values) {
            $featuresObjects->first()->values->each(function (FeatureValue $value) use (&$values) {
                $values[$value->id] = $value->current->name;
            });
        }
        
        $this->jsValidation(new FeatureDestroyForFrontendRequest);
        
        return view('features::admin.delete', [
            'feature' => $feature,
            'usedValues' => $usedValues,
            'countOfProductsWithThisFeature' => $countOfProductsWithThisFeature,
            'features' => $features,
            'values' => $values,
        ]);
    }
    
    /**
     * @param FeatureDestroyRequest $request
     * @param Feature $feature
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroyConfirmation(FeatureDestroyRequest $request, Feature $feature)
    {
        ProductGroup::where('feature_id', $feature->id)->update([
            'feature_id' => $request->input('feature_id'),
        ]);
        foreach ($request->input('value', []) as $oldValueId => $valueId) {
            Product::where('value_id', $oldValueId)->update([
                'value_id' => $valueId,
            ]);
            ProductGroupFeatureValue::where('value_id', $oldValueId)->update([
                'feature_id' => $request->input('feature_id'),
                'value_id' => $valueId,
            ]);
        }
        $feature->deleteRow();
        return $this->customRedirect('admin.features.index', [], trans('features::general.feature-deleted-successfully'));
    }
    
}
