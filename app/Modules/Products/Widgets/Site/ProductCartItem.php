<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductCartItem
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductCartItem implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var int|null
     */
    protected $dictionaryId;

    /**
     * ProductCartItem constructor.
     *
     * @param int $productId
     * @param int $quantity
     * @param int|null $dictionaryId
     */
    public function __construct(int $productId, int $quantity, $dictionaryId = null)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->dictionaryId = $dictionaryId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $product = Product::getOne($this->productId);
        if (!$product) {
            return null;
        }
        return view('products::site.widgets.cart-item.cart-item', [
            'product' => $product,
            'quantity' => $this->quantity,
            'dictionaryId' => $this->dictionaryId,
        ]);
    }
    
}
