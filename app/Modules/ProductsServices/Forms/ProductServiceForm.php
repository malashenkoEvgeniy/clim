<?php

namespace App\Modules\ProductsServices\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\ProductsServices\Models\ProductService;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\TinyMce;
use CustomForm\WysiHtml5;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductForm
 *
 * @package App\Modules\ProductsServices\Forms
 */
class ProductServiceForm implements FormInterface
{

    /**
     * Make form
     *
     * @param Model|ProductService|null $service
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $service = null): Form
    {
        $service = $service ?? new ProductService();

        $form = Form::create();
        
        $form->fieldSetForLang(8)->add(
            Input::create('name', $service)->required(),
            WysiHtml5::create('description', $service)
                ->setLabel('products_services::attributes.description')
                ->required(),
            TinyMce::create('text', $service)->required()
        );
    
        $fieldset = $form->fieldSet(4, FieldSet::COLOR_SUCCESS);
        $fieldset->add(Toggle::create('active', $service)->required());
        if ($service->exists && $service->system) {
            $fieldset->add(
                Toggle::create('show_icon', $service)
                    ->setLabel('products_services::attributes.show_icon')
                    ->required()
            );
        }
        return $form;
    }

}
