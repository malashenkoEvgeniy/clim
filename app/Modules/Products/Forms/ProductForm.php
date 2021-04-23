<?php

namespace App\Modules\Products\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Products\Models\Product;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Group\Row;
use CustomForm\Hidden;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\SimpleSelect;
use CustomForm\Text;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;
use Catalog;

/**
 * Class ProductForm
 *
 * @package App\Modules\Products\Forms
 */
class ProductForm implements FormInterface
{

    /**
     * Make form
     *
     * @param Model|Product|null $product
     * @param int $index
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $product = null, int $index = 0): Form
    {
        $priceLabel = 'validation.attributes.price';
        $oldPriceLabel = 'validation.attributes.old_price';
        if (Catalog::currenciesLoaded()) {
            $currencyClassName = Catalog::currency()->getClassName();
            $currency = config('currency.admin', new $currencyClassName);
            $priceLabel = __('validation.attributes.price') . ', ' . $currency->sign;
            $oldPriceLabel = __('validation.attributes.old_price') . ', ' . $currency->sign;
        }

        $product = $product ?? new Product();

        $form = Form::create();

        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->boxed(false)->add(
            Hidden::create('modification[id][' . $index . ']')->setValue($product->id ?? 0),
            Row::create()->add(
                Input::create('modification[price][' . $index . ']')
                    ->setType('number')
                    ->setValue($product->price ?? 0)
                    ->addClasses('modification-price')
                    ->setLabel($priceLabel)
                    ->setOptions(['step' => 0.25, 'min' => 0])
                    ->addClassesToDiv('col-md-6')
                    ->required(),
                Input::create('modification[old_price][' . $index . ']')
                    ->setType('number')
                    ->setValue($product->old_price ?? 0)
                    ->setLabel($oldPriceLabel)
                    ->setOptions(['step' => 0.25, 'min' => 0])
                    ->addClassesToDiv('col-md-6')
            ),
            Row::create()->add(
                Input::create('modification[vendor_code][' . $index . ']')
                    ->setValue($product->vendor_code)
                    ->setLabel('products::general.attributes.vendor_code')
                    ->addClassesToDiv('col-md-6'),
                SimpleSelect::create('modification[available][' . $index . ']')
                    ->setValue($product->available)
                    ->setLabel('validation.attributes.available')
                    ->add(config('products.availability', []))
                    ->addClassesToDiv('col-md-6')
                    ->setDefaultValue(Product::AVAILABLE)
            ),
            Text::create()->setDefaultValue(view('products::admin.product.images', ['product' => $product, 'index' => $index])),
            Row::create()->add(
                Text::create()->setDefaultValue(view('products::admin.wholesale.list', [
                    'prices' => $product->wholesale,
                    'product' => $product,
                    'index' => $index,
                ])),
                SimpleSelect::create('modification[value_id][' . $index . ']')
                    ->setValue($product->value_id)
                    ->setLabel(($product->exists && $product->value) ? $product->value->feature->current->name : trans('products::admin.attributes.modification-value'))
                    ->add(($product->exists && $product->value) ? $product->value->feature->values_dictionary : [])
                    ->addClassesToDiv('col-md-6')
                    ->addClasses('feature-value-select')
                    ->required()
            )
        );
        $form->fieldSetForLang(12)->boxed(false)->add(
            InputForSlug::create('modification][name][' . $index)
                ->setValue($product->exists ? $product->current->name : null)
                ->addClassesToDiv('col-md-6')
                ->setLabel('validation.attributes.name'),
            Slug::create('modification][slug][' . $index)
                ->setValue($product->exists ? $product->current->slug : null)
                ->addClassesToDiv('col-md-6')
                ->setLabel('validation.attributes.slug'),
            Input::create('modification][h1][' . $index)
                ->addClassesToDiv('col-md-6')
                ->setLabel('validation.attributes.h1')
                ->setValue($product->exists ? $product->current->h1 : null),
            Input::create('modification][title][' . $index)
                ->addClassesToDiv('col-md-6')
                ->setLabel('validation.attributes.title')
                ->setValue($product->exists ? $product->current->title : null),
            TextArea::create('modification][keywords][' . $index)
                ->setValue($product->exists ? $product->current->keywords : null)
                ->addClassesToDiv('col-md-6')
                ->setLabel('validation.attributes.keywords')
                ->setOptions(['rows' => 3]),
            TextArea::create('modification][description][' . $index)
                ->setValue($product->exists ? $product->current->description : null)
                ->addClassesToDiv('col-md-6')
                ->setLabel('validation.attributes.description')
                ->setOptions(['rows' => 3])
        );
        $form->doNotShowTopButtons();
        $form->doNotShowBottomButtons();
        return $form;
    }

}
