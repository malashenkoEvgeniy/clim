<?php

namespace App\Modules\Features\Controllers\Admin;

use App\Core\AjaxTrait;
use App\Core\AdminController;
use App\Modules\Features\Models\Feature;
use App\Modules\Features\Forms\FeatureValueForm;
use App\Modules\Features\Models\FeatureValueTranslates;
use App\Modules\Features\Requests\FeatureValueRequest;
use App\Modules\Features\Models\FeatureValue;
use Illuminate\Http\Request;

class FeaturesValuesController extends AdminController
{
    use AjaxTrait;
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $options = [];
        $feature = Feature::whereId($request->input('feature'))->first();
        if (!$feature) {
            return $this->successJsonAnswer([
                'options' => $options,
            ]);
        }
        $feature->values->each(function (FeatureValue $value) use (&$options) {
            $options[] = [
                'text' => $value->current->name,
                'id' => $value->id,
            ];
        });
        return $this->successJsonAnswer([
            'options' => $options,
            'multiple' => $feature->type === Feature::TYPE_MULTIPLE,
        ]);
    }
    
    /**
     * @param Feature $feature
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function create(Feature $feature)
    {
        $formId = 'add-feature-value';
        return $this->successMfpMessage(view('features::admin.values.popup', [
            'title' => trans('features::general.add-feature-value-title'),
            'form' => FeatureValueForm::make(),
            'validation' => $this->makeValidationJavaScript(
                (new FeatureValueRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'url' => route('admin.feature-values.store', $feature->id),
        ])->render());
    }
    
    /**
     * @param Feature $feature
     * @param FeatureValueRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(FeatureValueRequest $request, Feature $feature)
    {
        $value = (new FeatureValue());
        $value->feature_id = $feature->id;
        $value->active = true;
        if ($message = $value->createRow($request)) {
            return $this->errorJsonAnswer([
                'notyMessage' => $message,
            ]);
        }
        $currentValue = $value->id;
        return $this->successJsonAnswer([
            'insert' => view('features::admin.values.items', [
                'values' => $feature->fresh('values')->values,
                'feature' => $feature,
            ])->render(),
            'ajaxFeatureValues' => $feature->fresh('values')->values,
            'currentValue' => $currentValue,
            'featureType' => $feature->type,
            'mfpClose' => true,
        ]);
    }
    
    /**
     * @param Feature $feature
     * @param FeatureValue $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function edit(Feature $feature, FeatureValue $value)
    {
        $formId = 'edit-feature-value-' . $value->id;
        return $this->successMfpMessage(view('features::admin.values.popup', [
            'title' => trans('features::general.update-feature-value-title', [
                'value' => $value->current->name,
            ]),
            'form' => FeatureValueForm::make($value),
            'validation' => $this->makeValidationJavaScript(
                (new FeatureValueRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'method' => 'PUT',
            'url' => route('admin.feature-values.update', [$feature->id, $value->id]),
        ])->render());
    }
    
    /**
     * @param FeatureValueRequest $request
     * @param Feature $feature
     * @param FeatureValue $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(FeatureValueRequest $request, Feature $feature, FeatureValue $value)
    {
        $values = [];
        $value->data->each(function (FeatureValueTranslates $translate) use (&$values) {
            $values[$translate->language] = $translate->slug;
        });
    
        if ($message = $value->updateRow($request)) {
            return $this->errorJsonAnswer([
                'notyMessage' => $message,
            ]);
        }
    
        return $this->successJsonAnswer([
            'insert' => view('features::admin.values.items', [
                'values' => $feature->fresh('values')->values,
                'feature' => $feature,
            ])->render(),
            'mfpClose' => true,
        ]);
    }
    
    /**
     * @param FeatureValue $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy(FeatureValue $value)
    {
        $feature = $value->feature;
        $valueId = $value->id;
        $values = [];
        $value->data->each(function (FeatureValueTranslates $translate) use (&$values) {
            $values[$translate->language] = $translate->slug;
        });
        $value->deleteRow();
        event('features::value-deleted', $valueId);
        return $this->successJsonAnswer([
            'insert' => view('features::admin.values.items', [
                'values' => $feature->fresh('values')->values,
                'feature' => $feature,
            ])->render(),
            'mfpClose' => true,
        ]);
    }

}
