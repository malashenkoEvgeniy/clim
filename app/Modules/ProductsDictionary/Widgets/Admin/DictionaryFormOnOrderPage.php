<?php

namespace App\Modules\ProductsDictionary\Widgets\Admin;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\ProductsDictionary\Models\Dictionary;
use App\Modules\ProductsDictionary\Models\DictionaryRelation;
use CustomForm\Select;
use CustomForm\SimpleSelect;

/**
 * Class DictionaryFormOnOrderPage
 *
 * @package App\Modules\ProductsDictionary\Widgets
 */
class DictionaryFormOnOrderPage implements AbstractWidget
{
    /**
     * @var array
     */
    protected $order_item;


    /**
     * DictionaryFormOnProductPage constructor.
     *
     * @param ProductGroup $group
     */
    public function __construct($item)
    {
        $this->order_item = $item;
    }

    /**
     * @return \CustomForm\Select
     * @throws \App\Exceptions\WrongParametersException
     */
    public function render()
    {

        $dictionaryValues = [];
        $status = config('db.products_dictionary.select_status', 0);
        if(!$status) {
            $product = Product::whereId($this->order_item->product_id)->first();
            $relations = DictionaryRelation::whereGroupId($product->group_id)->get();
            foreach ($relations as $rel) {
                $dictionaryValues[$rel->dictionary()->first()->id] = $rel->dictionary()->first()->current->name;
            }
        } else{
            $dictionaries = Dictionary::with(['current'])->get();
            foreach ($dictionaries as $dictionary){
                $dictionaryValues[$dictionary->id] = $dictionary->current->name;
            }
        }

        $keys = array_keys($dictionaryValues);

        $dictionarySelect = SimpleSelect::create('items[dictionaries]['.$this->order_item->product_id.']['.$this->order_item->id.']')
            ->add($dictionaryValues)
            ->setValue(in_array($this->order_item->dictionary_id, $keys) ? $this->order_item->dictionary_id : array_shift($keys))
            ->setLabel('')
            ->addClassesToDiv('col-md-10')
            ->setOptions(['id' => 'dictionary-select']);


        return $dictionarySelect->render();
    }

}
