<?php

namespace App\Modules\ProductsAvailability\Events;

/**
 * Class ChangeProductStatusEvent
 *
 * @package App\Modules\FastOrders\Events
 */
class ProductsAvailabilityEvent
{
    /**
     * @var string
    */
    public $email;

    /**
     * @object int
     */
    public $productId;

    /**
     * @var int
     */
    public $orderId;

    /**
     * ChangeProductStatusEvent constructor.
     *
     * @param string $email
     * @param int $productId
     */
    public function __construct(string $email, $productId, int $orderId)
    {
        $this->email = $email;
        $this->productId = $productId;
        $this->orderId = $orderId;
    }
}
