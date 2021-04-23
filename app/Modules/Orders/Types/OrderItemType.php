<?php

namespace App\Modules\Orders\Types;

use App\Modules\Orders\Models\OrderItem;

/**
 * Class OrderItemType
 *
 * @package App\Modules\Orders\Types
 */
class OrderItemType
{

    /**
     * Product id
     *
     * @var int
     */
    public $productId;

    /**
     * Same items quantity
     *
     * @var int
     */
    public $quantity;

    /**
     * Item price for 1
     *
     * @var float
     */
    public $price;

    /**
     *
     * @var int|null
     */
    public $dictionary_id;

    /**
     * OrderItemType constructor.
     *
     * @param OrderItem $item
     */
    public function __construct(OrderItem $item)
    {
        $this->productId = $item->product_id;
        $this->quantity = $item->quantity;
        $this->price = $item->price;
        $this->dictionary_id = isset($item->dictionary_id) ? $item->dictionary_id : null;
    }

    public function formattedPrice()
    {
        if (\Catalog::currenciesLoaded()) {
            return \Catalog::currency()->format($this->price);
        }
        return $this->price;
    }

    public function formattedAmount()
    {
        $amount = $this->price * $this->quantity;
        if (\Catalog::currenciesLoaded()) {
            return \Catalog::currency()->format($amount);
        }
        return $amount;
    }

}
