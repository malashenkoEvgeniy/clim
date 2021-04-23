<?php

namespace App\Modules\Orders\Widgets\Cart;

use App\Components\Widget\AbstractWidget;
use Widget;

/**
 * Class Button
 *
 * @package App\Modules\Orders\Cart\Widgets
 */
class Button implements AbstractWidget
{

    /**
     * @var int
     */
    private $productId;

    /**
     * @var bool
     */
    private $isAvailable;

    /**
     * @var bool
     */
    private $withText;

    /**
     * Labels constructor.
     *
     * @param int $productId
     * @param bool $isAvailable
     */
    public function __construct(int $productId, bool $isAvailable = true, bool $withText = false)
    {
        $this->productId = $productId;
        $this->isAvailable = $isAvailable;
        $this->withText = $withText;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if ($this->isAvailable === false) {
            return Widget::show('products-availability::button', $this->productId);
        }
        return view('orders::site.cart.button', [
            'productId' => $this->productId,
            'withText' => $this->withText,
        ]);
    }

}
