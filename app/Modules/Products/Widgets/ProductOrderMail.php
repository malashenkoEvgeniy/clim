<?php

namespace App\Modules\Products\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductOrderMail
 *
 * @package App\Modules\Products\Widgets
 */
class ProductOrderMail implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * ProductOrderMail constructor.
     *
     * @param int productId
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $product = Product::find($this->productId);
        return view('products::mail.order-item', [
            'product' => $product,
        ]);
    }
    
}
