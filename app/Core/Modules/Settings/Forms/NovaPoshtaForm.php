<?php

namespace App\Core\Modules\Settings\Forms;

use App\Components\Delivery\NovaPoshta;
use App\Core\Interfaces\FormInterface;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NovaPoshtaForm
 *
 * @package App\Core\Modules\Settings\Forms
 */
class NovaPoshtaForm implements FormInterface
{
    
    /**
     * @param Model|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $model = null): Form
    {
        $novaPoshta = new NovaPoshta();
        
        $cities = [];
        $npCities = $novaPoshta->getCities();
        if ($npCities) {
            foreach ($npCities->data as $city) {
                $cities[$city->Ref] = $city->DescriptionRu;
            }
        }
        
        $warehouses = [];
        if (config('db.nova-poshta.sender-warehouse')) {
            $npWarehouses = $novaPoshta->getWarehousesCityRef(config('db.nova-poshta.sender-city'));
            if ($npWarehouses) {
                foreach ($npWarehouses->data as $warehouse) {
                    $warehouses[$warehouse->Ref] = $warehouse->DescriptionRu;
                }
            }
        }
        
        // Form
        $form = Form::create();
        $form->fieldSet()->add(
            Input::create('key')
                ->setValue(config('db.nova-poshta.key'))
                ->setLabel('settings::nova-poshta.key'),
            Input::create('sender-last-name')
                ->setValue(config('db.nova-poshta.sender-last-name'))
                ->setLabel('settings::nova-poshta.sender-last-name'),
            Input::create('sender-first-name')
                ->setValue(config('db.nova-poshta.sender-first-name'))
                ->setLabel('settings::nova-poshta.sender-first-name'),
            Input::create('sender-middle-name')
                ->setValue(config('db.nova-poshta.sender-middle-name'))
                ->setLabel('settings::nova-poshta.sender-middle-name'),
            Input::create('sender-phone')
                ->setValue(config('db.nova-poshta.sender-phone'))
                ->setLabel('settings::nova-poshta.sender-phone'),
            Select::create('sender-city')
                ->setValue(config('db.nova-poshta.sender-city'))
                ->addClasses('changeCity')
                ->setOptions(['href' => url('/admin/warehouses-for-city'), 'insert-block' => '#senderWarehouses'])
                ->add($cities)
                ->setPlaceholder('&mdash;')
                ->setLabel('settings::nova-poshta.sender-city'),
            Select::create('sender-warehouse')
                ->setValue(config('db.nova-poshta.sender-warehouse'))
                ->setOptions(['id' => 'senderWarehouses'])
                ->add($warehouses)
                ->setPlaceholder('&mdash;')
                ->setLabel('settings::nova-poshta.sender-warehouse')
        );
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }
    
}
