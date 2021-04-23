<?php

namespace App\Modules\ProductsDictionary\Widgets\Admin;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Components\Widget\AbstractWidget;
use App\Modules\Features\Models\Feature;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\ProductsDictionary\Models\Dictionary;
use App\Modules\ProductsDictionary\Models\DictionaryRelation;
use CustomForm\Macro\MultiSelect;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DictionaryFormOnProductPage
 *
 * @package App\Modules\ProductsDictionary\Widgets
 */
class DictionaryFormOnProductPage implements AbstractWidget
{
    /**
     * @var array
     */
    protected $group_id;


    /**
     * DictionaryFormOnProductPage constructor.
     *
     * @param ProductGroup $group
     */
    public function __construct($group)
    {
        $this->group_id = $group->id;
    }

    /**
     * @return \CustomForm\Select
     * @throws \App\Exceptions\WrongParametersException
     */
    public function render()
    {
        $selected = [];
        $dictionary = Dictionary::with(['current'])->whereActive(1)->get();
        foreach ($dictionary as $obj) {
            $dictionaryValues[$obj->id] = $obj->current->name;
        }
        $relations = DictionaryRelation::whereGroupId($this->group_id)->get();
        foreach ($relations as $rel) {
            $selected[] = $rel->dictionary()->first()->id;
        }

        $dictionarySelect = MultiSelect::create('group_dictionary_id[]')
            ->add($dictionaryValues)
            ->setLabel('categories::general.attributes.other-categories')
            ->setValue($selected)
            ->setLabel('products_dictionary::general.dictionary-values')
            ->addClassesToDiv('col-md-10')
            ->setOptions(['id' => 'dictionary-select', 'required']);

        return view('products_dictionary::admin.widgets.product-page', [
            'dictionarySelect' => $dictionarySelect,
            'dictionaryValues' => $dictionaryValues,
            'groupId' => $this->group_id
        ]);
    }

}
