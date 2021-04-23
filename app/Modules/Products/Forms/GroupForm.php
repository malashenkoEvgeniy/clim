<?php

namespace App\Modules\Products\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\Models\Category;
use App\Modules\Features\Models\Feature;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use App\Modules\Products\Models\ProductGroupLabel;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DropZone;
use CustomForm\Macro\MultiSelect;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\Text;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;
use Widget;

/**
 * Class GroupForm
 *
 * @package App\Modules\Products\Forms
 */
class GroupForm implements FormInterface
{

    /**
     * Make form
     *
     * @param Model|ProductGroup|null $group
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $group = null): Form
    {
        $group = $group ?? new ProductGroup();

        $selectedMainCategory = null;
        $allSelectedLabels = [];
        if ($group->exists) {
            ProductGroupLabel::getRelationsForProduct($group->id)
                ->each(function (ProductGroupLabel $relation) use (&$allSelectedLabels) {
                    $allSelectedLabels[] = $relation->label_id;
                });
        }

        $form = Form::create();
        $tabs = $form->tabs(12);
        $mainInformationTab = $tabs->createTab('admin.tabs.general-information');
        
        $categories = Category::getDictionaryForSelects();
        
        $mainInformationTab->fieldSet(4, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $group)->required(),
            Select::create('category_id', $group)
                ->add($categories)
                ->setLabel('categories::general.attributes.main-category')
                ->required(),
            MultiSelect::create('categories[]')
                ->add($categories)
                ->setLabel('categories::general.attributes.other-categories')
                ->setValue($group ? $group->other_categories_ids : []),
            Input::create('position', $group)
                ->setType('number')
                ->setDefaultValue(ProductGroup::DEFAULT_POSITION)
                ->setLabel('products::general.attributes.position'),
            Select::create('brand_id', $group)
                ->model(
                    ModelForSelect::make(
                        Brand::with('current')->get()
                    )->setValueFieldName('current.name')
                )
                ->setPlaceholder('&mdash;'),
            ($group->exists && $group->feature_id) ?
                Text::create()->setDefaultValue(view('products::admin.groups.feature', [
                    'feature' => $group->feature,
                    'group' => $group,
                ])) :
                Select::create('feature_id', $group)
                    ->model(
                        ModelForSelect::make(
                            Feature::with('current')->get()
                        )->setValueFieldName('current.name')
                    ),
            MultiSelect::create('labels[]')
                ->addClassesToDiv('col-md-12')
                ->model(ModelForSelect::make(
                    Label::all()
                )->setValueFieldName('current.name'))
                ->setLabel('labels::general.permission-name')
                ->setValue($allSelectedLabels)
        );
        $mainInformationTab->fieldSetForLang(8)->add(
            Input::create('name', $group)->required(),
            TinyMce::create('text', $group)
                ->setOptions(['style' => 'height: 115px'])
                ->setLabel(__('products::general.attributes.text')),
            Input::create('text_related', $group)
                ->setLabel('products::general.text-related')
        );
        $mainInformationTab->fieldSetForView('products::admin.groups.products', ['group' => $group]);
        
        if ($group->exists) {
            $tabs->createTab('admin.tabs.images')
                ->fieldSet()
                ->add(DropZone::create('drop-zone', $group));
            $tabs->createTab('products::admin.tabs.related')
                ->fieldSetForView('products::admin.related.index', [
                    'group' => $group,
                    'relatedGroups' => $group->related,
                ]);
            $tabs->createTab('products::admin.tabs.features')
                ->fieldSet()
                ->add(
                    Text::create()->setDefaultValue(Widget::show(
                        'features::select-in-product',
                        ProductGroupFeatureValue::getLinkedFeaturesAsArray($group),
                        $group->feature_id
                    ))
                );
            $status = config('db.products_dictionary.site_status');
            $status_view = config('db.products_dictionary.select_status');
            if(isset($status) && $status && isset($status_view) && !$status_view) {
                $tabs->createTab('products_dictionary::admin.tab_dictionary')
                    ->fieldSet()
                    ->add(
                        Text::create()->setDefaultValue(Widget::show(
                            'products_dictionary::choose-in-product',
                            $group
                        ))
                    );
            }
        }

        return $form;
    }

}
