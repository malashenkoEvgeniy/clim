<?php

namespace App\Modules\Wishlist\Widgets;

use App\Components\Widget\AbstractWidget;
use Catalog, Wishlist;

/**
 * Class ProductButton
 * @package App\Modules\Wishlist\Widgets
 */
class ProductButton implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * ProductButton constructor.
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     * @throws \Exception
     */
    public function render()
    {
        return view('wishlist::site.product-button', [
            'productId' => $this->productId,
            'isInWishlist' => Wishlist::has($this->productId),
        ]);
    }
    
}
