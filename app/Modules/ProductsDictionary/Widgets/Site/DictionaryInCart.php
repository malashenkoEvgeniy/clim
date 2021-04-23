<?php

namespace App\Modules\ProductsDictionary\Widgets\Site;


use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\ProductsDictionary\Models\Dictionary;
use App\Modules\ProductsDictionary\Models\DictionaryRelation;
use CustomForm\Macro\MultiSelect;
use CustomForm\Select;

/**
 * Class DictionaryInCart
 *
 * @package App\Modules\ProductsDictionary\Widgets
 */
class DictionaryInCart implements AbstractWidget
{
    /**
     * @var int
     */
    protected $group_id;
    
    /**
     * @var int
     */
    protected $product_id;
    
    /**
     * @var int|array
     */
    protected $selected;
    
    
    /**
     * DictionaryInCart constructor.
     *
     * @param $productId
     * @param null $selected
     */
    public function __construct($productId, $selected = null)
    {
        $product = Product::whereId($productId)->firstOrFail();
        $this->group_id = $product->group_id;
        $this->product_id = $product->id;
        if(isset($selected)) {
            $this->selected = $selected;
        } else{
            $this->selected = [];
        }
    }

    /**
     * @return \CustomForm\Select
     * @throws \App\Exceptions\WrongParametersException
     */
    public function render()
    {
        $selected = [];
        $status = config('db.products_dictionary.select_status');

        if (isset($status) && $status) {
            $dictionaries = Dictionary::with('current')->get();
            foreach ($dictionaries as $obj){
                $selected[$obj->id] = $obj->current->name;
            }
        } else {
            $relations = DictionaryRelation::whereGroupId($this->group_id)->get();
            foreach ($relations as $rel) {
                $result = $rel->dictionary()->first();
                $selected[$result->id] = $result->current->name;
            }
        }

        $dictionarySelect = Select::create('dictionary_id')
            ->add($selected)
            ->setValue($this->selected)
            ->setLabel(false)
            ->setOptions([
                'id' => 'dictionary-select',
                'class' => 'select select--size-small',
                'data-product-dictionary' => '',
                'data-product-id' => $this->product_id,
            ]);

        return view('products_dictionary::site.widgets.cart-item', [
            'dictionarySelect' => $dictionarySelect,
            'values' => $selected
        ]);
    }

}
