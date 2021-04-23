<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Catalog;
use Illuminate\Support\Collection;

/**
 * Class ProductOrder
 *
 * @package App\Modules\Products\Widgets
 */
class ProductOrder implements AbstractWidget
{
    /**
     * @var Collection
     */
    public static $products;
    
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
     * @var int|null
     */
    protected $dictionaryId;
    
    /**
     * ProductOrder constructor.
     * @param int $productId
     * @param float $price
     * @param int $quantity
     * @param int|null $dictionaryId
     */
    public function __construct(int $productId, float $price, int $quantity, ?int $dictionaryId = null)
    {
        $this->productId = $productId;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->dictionaryId = $dictionaryId;
        if (static::$products === null) {
            static::$products = new Collection();
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
        if (static::$products->has($this->productId)) {
            $product = static::$products->get($this->productId);
        } else {
            $product = Product::find($this->productId);
            if ($product) {
                static::$products->put($this->productId, $product);
            }
        }
        if (Catalog::currenciesLoaded()) {
            $formattedPrice = Catalog::currency()->format($this->price);
            $formattedAmount = Catalog::currency()->format($this->price * $this->quantity);
        } else {
            $formattedPrice = $this->price;
            $formattedAmount = $this->price * $this->quantity;
        }
        return view('products::site.widgets.order-product.order-product--checkout', [
            'product' => $product,
            'formattedPrice' => $formattedPrice,
            'formattedAmount' => $formattedAmount,
            'quantity' => $this->quantity,
            'dictionaryId' => $this->dictionaryId,
        ]);
    }
    
}
