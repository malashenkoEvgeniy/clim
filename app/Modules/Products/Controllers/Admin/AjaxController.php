<?php

namespace App\Modules\Products\Controllers\Admin;

use App\Core\AdminController;
use App\Core\AjaxTrait;
use App\Modules\Features\Models\Feature;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use App\Modules\ProductsDictionary\Models\Dictionary;
use App\Modules\ProductsDictionary\Models\DictionaryRelation;
use CustomForm\SimpleSelect;
use Illuminate\Http\Request;
use Widget;

/**
 * Class AjaxController
 *
 * @package App\Modules\Products\Controllers\Admin
 */
class AjaxController extends AdminController
{
    use AjaxTrait;
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items = [];
        Product::search(50, (array)request()->input('ignored', []))->each(function (Product $product) use (&$items) {
            $view = view('products::admin.product.widgets.live-search-select-markup', [
                'product' => $product,
            ])->render();
            $items[] = [
                'id' => $product->id,
                'markup' => $view,
                'selection' => $view,
                'price' => $product->price_for_site,
                'name' => $product->name,
                'formatted_price' => $product->formatted_price,
            ];
        });
        return $this->successJsonAnswer([
            'items' => $items,
        ]);
    }
    
    public function groups()
    {
        $items = [];
        ProductGroup::search(50, (array)request()->input('ignored', []))->each(function (ProductGroup $group) use (&$items) {
            $view = view('products::admin.groups.widgets.live-search-select-markup', [
                'group' => $group,
            ])->render();
            $dictionaryCheck = config('db.products_dictionary.site_status', 0);
            if($dictionaryCheck){
                $options = '';
                $product = $group->relevant_product ? $group->relevant_product : $group;
                $status = config('db.products_dictionary.select_status', 0);
                if(!$status) {
                    $relations = DictionaryRelation::whereGroupId($product->id)->get();
                    foreach ($relations as $rel) {
                        $options .= '<option value="'.$rel->dictionary()->first()->id.'">'.$rel->dictionary()->first()->current->name.'</option>';
                    }
                } else{
                    $dictionaries = Dictionary::with(['current'])->get();
                    foreach ($dictionaries as $dictionary){
                        $options .= '<option value="'.$dictionary->id.'">'.$dictionary->current->name.'</option>';
                    }
                }

                $dictionarySelect = '<div class="form-group col-md-10"><select class="form-control" id="dictionary-select" name="items[new]['.$product->id.'][dictionaries][]" aria-invalid="false">' . $options . '</select></div>';

            }
            $items[] = [
                'id' => request()->input('type') === 'product' ? $group->relevant_product->id : $group->id,
                'markup' => $view,
                'selection' => $view,
                'name' => $group->relevant_product ? $group->relevant_product->name : $group->current->name,
                'price' => $group->relevant_product ? $group->relevant_product->price_for_site : 0,
                'formatted_price' => $group->relevant_product ? $group->relevant_product->formatted_price : 0,
                'dictionary_id' => isset($dictionarySelect) ? json_encode($dictionarySelect) : null
            ];
        });
        return $this->successJsonAnswer([
            'items' => $items,
        ]);
    }
    
    /**
     * @param Request $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function linkFeatureValueToGroup(Request $request, ProductGroup $group)
    {
        $method = $request->input('type', 'store');
        switch ($method) {
            case 'update':
                return $this->_updateForGroup($request, $group);
            case 'destroy':
                return $this->_destroyForGroup($request, $group);
            default:
                return $this->_storeForGroup($request, $group);
        }
    }
    
    /**
     * @param Request $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    private function _updateForGroup(Request $request, ProductGroup $group)
    {
        $featureId = $request->input('feature_id');
        $valuesIds = (array)$request->input('values_ids');
        if (!$featureId || !$valuesIds) {
            return $this->errorJsonAnswer([
                'notyMessage' => trans('products::admin.choose-feature-to-update'),
            ]);
        }
        foreach ($valuesIds as $valueId) {
            $group->products->each(function (Product $product) use ($group, $valueId, $featureId) {
                ProductGroupFeatureValue::link(
                    $group,
                    $product,
                    $featureId,
                    $valueId
                );
            });
        }
        ProductGroupFeatureValue::whereGroupId($group->id)
            ->whereFeatureId($featureId)
            ->whereNotIn('value_id', $valuesIds)
            ->get()
            ->each(function (ProductGroupFeatureValue $relation) use ($group) {
                ProductGroupFeatureValue::unlink(
                    $group,
                    $relation->product,
                    $relation->feature_id,
                    $relation->value_id
                );
            });
        return $this->successJsonAnswer([
            'notyMessage' => trans('products::admin.success-update'),
        ]);
    }
    
    /**
     * @param Request $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    private function _destroyForGroup(Request $request, ProductGroup $group)
    {
        $featureId = $request->input('feature_id');
        if (!$featureId || !($feature = Feature::find($featureId))) {
            return $this->errorJsonAnswer([
                'notyMessage' => trans('products::admin.choose-feature-to-destroy'),
            ]);
        }
        $group->products->each(function (Product $product) use ($group, $featureId) {
            ProductGroupFeatureValue::unlink(
                $group,
                $product,
                $featureId
            );
        });
        return $this->successJsonAnswer();
    }
    
    /**
     * @param Request $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\JsonResponse
     */
    private function _storeForGroup(Request $request, ProductGroup $group)
    {
        $featureId = $request->input('feature_id');
        $valuesIds = (array)$request->input('value_id');
        if (!$featureId || !$valuesIds || !$request->input('value_id')) {
            return $this->errorJsonAnswer([
                'notyMessage' => trans('products::admin.choose-your-features'),
            ]);
        }
        $feature = Feature::find($featureId);
        if ($feature) {
            if ($feature->type === Feature::TYPE_MULTIPLE) {
                foreach ($valuesIds as $valueId) {
                    $group->products->each(function (Product $product) use ($group, $valueId, $featureId) {
                        ProductGroupFeatureValue::link(
                            $group,
                            $product,
                            $featureId,
                            $valueId
                        );
                    });
                }
            } else {
                foreach ($valuesIds as $valueId) {
                    $group->products->each(function (Product $product) use ($group, $valueId, $featureId) {
                        ProductGroupFeatureValue::changeSingleValue(
                            $group,
                            $product,
                            $featureId,
                            $valueId
                        );
                    });
                }
            }
        }
        return $this->successJsonAnswer([
            'insert' => Widget::show(
                'features::admin::product-page',
                ProductGroupFeatureValue::getLinkedFeaturesAsArray($group),
                $group->feature_id
            )->render(),
        ]);
    }
    
}
