<?php

namespace App\Modules\Products\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Html;

/**
 * Class ProductOrderPreview
 *
 * @package App\Modules\Products\Widgets
 */
class ProductInvoice implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var bool
     */
    protected $returnLink;
    
    /**
     * ProductOrder constructor.
     * @param bool $returnLink
     * @param int $productId
     */
    public function __construct(int $productId, bool $returnLink = false)
    {
        $this->productId = $productId;
        $this->returnLink = $returnLink;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->productId) {
            return trans('products::general.product-deleted');
        }
        $product = Product::find($this->productId);
        if (!$product) {
            return trans('products::general.product-deleted');
        }
    
        if ($this->returnLink === true) {
            return Html::link(
                route('admin.groups.edit', $product->group_id),
                $product->name,
                ['target' => '_blank'],
                null,
                false
            );
        }
        return $product->name;
    }
    
}
