<?php

namespace App\Modules\ProductsAvailability\Events;

/**
 * Class ProductsAvailabilityEvent
 *
 * @package App\Modules\FastOrders\Events
 */
class ChangeProductStatusEvent
{
    /**
     * @var int
     */
    public $productId;

    /**
     * ProductsAvailabilityEvent constructor.
     *
     * @param int $productId
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }
}
