<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Catalog;

/**
 * Class ProductInCheckout
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductInCheckout implements AbstractWidget
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
     * @var int
     */
    protected $dictionaryId;
    
    /**
     * ProductInCheckout constructor.
     *
     * @param int $productId
     * @param int $quantity
     * @param int|null $dictionaryId
     */
    public function __construct(int $productId, int $quantity, ?int $dictionaryId = null)
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
        if (Catalog::currenciesLoaded()) {
            $formattedAmount = Catalog::currency()->format($product->price * $this->quantity);
        } else {
            $formattedAmount = $product->price * $this->quantity;
        }
        return view('products::site.widgets.order-product.order-product--checkout', [
            'product' => $product,
            'formattedPrice' => $product->formatted_price,
            'formattedAmount' => $formattedAmount,
            'quantity' => $this->quantity,
            'dictionaryId' => $this->dictionaryId,
        ]);
    }
    
}
