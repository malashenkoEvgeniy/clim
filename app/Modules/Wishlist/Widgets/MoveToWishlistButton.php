<?php

namespace App\Modules\Wishlist\Widgets;

use App\Components\Widget\AbstractWidget;
use Wishlist;

/**
 * Class MoveToWishlistButton
 *
 * @package App\Modules\Wishlist\Widgets
 */
class MoveToWishlistButton implements AbstractWidget
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
        if (Wishlist::has($this->productId)) {
            return null;
        }

        return view('wishlist::site.move-to-wishlist-button', [
            'productId' => $this->productId,
        ]);
    }

}
