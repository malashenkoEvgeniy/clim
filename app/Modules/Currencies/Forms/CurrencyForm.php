<?php

namespace App\Modules\Currencies\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Currencies\Components\CurrencyRates\Rate;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyForm
 *
 * @package App\Core\Modules\Catalog\Forms
 */
class CurrencyForm implements FormInterface
{

    /**
     * @param  Model|Currency|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new Currency;
        $currentRate = '';
        $mainCurrencyCode = Rate::instance()->getMainCurrencyCode();
        if ($model->exists && $model->microdata !== $mainCurrencyCode) {
            $currentRate = trans('currencies::general.course', [
                'from' => $model->microdata,
                'amount' => Rate::convert(1, $model->microdata, $mainCurrencyCode, Rate::AGGREGATOR_NBU),
                'to' => $mainCurrencyCode,
            ]);
        }
        $form = Form::create();
        $form->fieldSet()->add(
            Input::create('name', $model)->required(),
            Input::create('sign', $model)
                ->setLabel('currencies::general.attributes.sign')
                ->required(),
            Input::create('multiplier', $model)
                ->setLabel('currencies::general.attributes.multiplier')
                ->setType('number')
                ->setHelp($currentRate)
                ->required()
        );
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }
    
}
