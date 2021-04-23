<?php

namespace App\Modules\FastOrders\Events;

/**
 * Class FastOrderEventEvent
 *
 * @package App\Modules\FastOrders\Events
 */
class FastOrderEvent
{
    /**
     * @var string
    */
    public $phone;

    /**
     * @var int
    */
    public $productId;
    
    /**
     * @var int
     */
    public $orderId;

    /**
     * FastOrderEvent constructor.
     *
     * @param string $phone
     * @param int $productId
     * @param int $orderId
     */
    public function __construct(string $phone, int $productId, int $orderId)
    {
        $this->phone = $phone;
        $this->productId = $productId;
        $this->orderId = $orderId;
    }
}