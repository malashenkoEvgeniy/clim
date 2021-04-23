<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Catalog;
use Illuminate\Support\Collection;

/**
 * Class ProductPrintOrder
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductPrintOrder implements AbstractWidget
{
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var float
     */
    protected $price;
    
    /**
     * @var int
     */
    protected $quantity;
    
    /**
     * ProductOrder constructor.
     * @param int $productId
     * @param float $price
     * @param int $quantity
     */
    public function __construct(int $productId, float $price, int $quantity)
    {
        $this->productId = $productId;
        $this->price = $price;
        $this->quantity = $quantity;
        if (ProductOrder::$products === null) {
            ProductOrder::$products = new Collection();
        }
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->productId) {
            return null;
        }
        if (ProductOrder::$products->has($this->productId)) {
            $product = ProductOrder::$products->get($this->productId);
        } else {
            $product = Product::find($this->productId);
            ProductOrder::$products->put($this->productId, $product);
        }
        if (Catalog::currenciesLoaded()) {
            $formattedPrice = Catalog::currency()->format($this->price);
            $formattedAmount = Catalog::currency()->format($this->price * $this->quantity);
        } else {
            $formattedPrice = $this->price;
            $formattedAmount = $this->price * $this->quantity;
        }
        return view('products::site.widgets.print-order-item', [
            'product' => $product,
            'formattedPrice' => $formattedPrice,
            'formattedAmount' => $formattedAmount,
            'quantity' => $this->quantity,
        ]);
    }
    
}
