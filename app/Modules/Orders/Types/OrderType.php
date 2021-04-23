<?php

namespace App\Modules\Orders\Types;

use App\Components\Catalog\Interfaces\CartItemInterface;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderClient;
use App\Modules\Orders\Models\OrderItem;
use Illuminate\Support\Collection;

/**
 * Class OrderType
 *
 * @package App\Modules\Orders\Types
 */
class OrderType
{
    /**
     * Order id
     *
     * @var int
     */
    public $id;

    /**
     * Client email
     *
     * @var string
     */
    public $clientEmail;

    /**
     * Client phone number
     *
     * @var string
     */
    public $clientPhone;

    /**
     * Client full name
     *
     * @var string
     */
    public $clientName;

    /**
     * Delivery city
     *
     * @var string
     */
    public $city;

    /**
     * Delivery type
     *
     * @var string
     */
    public $deliveryType;

    /**
     * Delivery address
     *
     * @var string
     */
    public $deliveryAddress;

    /**
     * Payment method
     *
     * @var string
     */
    public $paymentMethod;

    /**
     * Client short comment
     *
     * @var string
     */
    public $comment;

    /**
     * Do we need not to call to the client
     *
     * @var boolean
     */
    public $do_not_call_me;

    /**
     * Ordered items list
     *
     * @var Collection|OrderItemType[]
     */
    public $items;
    public $total = 0;

    /**
     * OrderType constructor.
     *
     * @param Order $order
     * @param OrderClient $client
     * @param Collection $items
     */
    public function __construct(Order $order, OrderClient $client, Collection $items)
    {
        $this->id = $order->id;
        $this->city = $order->city;
        $this->deliveryType = $order->delivery;
        $this->deliveryAddress = $order->delivery_address;
        $this->paymentMethod = $order->payment_method;
        $this->comment = $order->comment;
        $this->do_not_call_me = $order->do_not_call_me;

        $this->clientName = $client->name;
        $this->clientEmail = $client->email;
        $this->clientPhone = $client->phone;

        $this->items = new Collection();
        foreach ($items as $item) {
            $this->items->push(new OrderItemType($item));
            $this->total += $item->price * $item->quantity;
        }
    }

    public function formattedAmount()
    {
        if (\Catalog::currenciesLoaded()) {
            return \Catalog::currency()->format($this->total);
        }
        return $this->total;
    }

}
