<?php

namespace App\Modules\ProductsDictionary\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\ProductsDictionary\Models\Dictionary;

/**
 * Class DictionaryFormOnOrderPage
 *
 * @package App\Modules\ProductsDictionary\Widgets
 */
class DictionaryDisplayText implements AbstractWidget
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * DictionaryFormOnProductPage constructor.
     *
     * @param int $id
     */
    public function __construct(?int $id)
    {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function render()
    {
        $dictionary = null;
        if ($this->id) {
            $dictionary = Dictionary::with(['current'])->whereId($this->id)->first();
        }
        return $dictionary ? $dictionary->current->name : null;
    }

}
