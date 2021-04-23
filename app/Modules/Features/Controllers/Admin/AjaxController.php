<?php

namespace App\Modules\Features\Controllers\Admin;

use App\Core\AjaxTrait;
use App\Core\AdminController;
use App\Modules\Features\Forms\AjaxFeatureForm;
use App\Modules\Features\Forms\FeatureValueForm;
use App\Modules\Features\Models\Feature;
use App\Modules\Features\Models\FeatureValue;
use App\Modules\Features\Models\FeatureValueTranslates;
use App\Modules\Features\Requests\FeatureAjaxRequest;
use App\Modules\Features\Requests\FeatureRequest;
use App\Modules\Features\Requests\FeatureValueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AjaxController
 *
 * @package App\Modules\Orders\Controllers\Admin
 */
class AjaxController extends AdminController
{
    use AjaxTrait;

    public function showFeaturesModal()
    {
        $formId = uniqid('add-feature');
        return $this->successMfpMessage(view('features::admin.popup', [
            'new' => true,
            'title' => trans('features::general.features.create'),
            'form' => AjaxFeatureForm::make(),
            'validation' => $this->makeValidationJavaScript(
                (new FeatureRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'url' => route('admin.features.ajax-create'),
        ])->render());
    }


    /**
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function showValuesModal(Request $request)
    {
        $feature = Feature::find($request->feature);
        $formId = 'add-feature-value';
        return $this->successMfpMessage(view('features::admin.values.popup', [
            'title' => trans('features::general.add-feature-value-title') . ' ' . $feature->current->name,
            'form' => FeatureValueForm::make(),
            'validation' => $this->makeValidationJavaScript(
                (new FeatureValueRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'url' => route('admin.feature-values.store', $feature->id),
        ])->render());
    }

    public function ajaxCreateFeature(FeatureAjaxRequest $featureAjaxRequest, FeatureValueRequest $valueRequest)
    {
        $feature = (new Feature());
        $feature->active = true;

        if ($message = $feature->createRowAjax($featureAjaxRequest)) {
            return $this->errorJsonAnswer([
                'notyMessage' => $message,
            ]);
        }

        $value = (new FeatureValue());
        $value->feature_id = $feature->id;
        $value->active = true;
        if ($message = $value->createRow($valueRequest)) {
            return $this->errorJsonAnswer([
                'notyMessage' => $message,
            ]);
        }

        $newFeature = $feature->id;
        $features = Feature::getList();
        return $this->successJsonAnswer([
            'insert' => [
                'values' => $feature->fresh('values')->values,
                'features' => $features,
                'feature_id' => $newFeature,
            ],
            'mfpClose' => true,
            'featureCreate' => true,
        ]);
    }

}
