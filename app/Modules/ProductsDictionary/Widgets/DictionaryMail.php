<?php

namespace App\Modules\ProductsDictionary\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use App\Modules\ProductsDictionary\Models\Dictionary;

/**
 * Class DictionaryMail
 *
 * @package App\Modules\Products\Widgets
 */
class DictionaryMail implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $dictionaryId;
    
    /**
     * ProductOrderMail constructor.
     *
     * @param int productId
     */
    public function __construct($product)
    {
        $this->dictionaryId = $product->dictionary_id;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $dictionary = Dictionary::find($this->dictionaryId);
        return view('products_dictionary::mail.order-item', [
            'dictionary' => $dictionary,
        ]);
    }
    
}
