<?php

namespace App\Modules\CompareProducts\Widgets;

use App\Components\Widget\AbstractWidget;
use CompareProducts;

/**
 * Class CompareProductButton
 *
 * @package App\Modules\CompareProducts\Widgets
 */
class CompareProductButton implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * CompareProductButton constructor.
     *
     * @param int $productId
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
        return view('compare::site.product-button', [
            'productId' => $this->productId,
            'isInComparison' => CompareProducts::has($this->productId),
        ]);
    }
    
}
