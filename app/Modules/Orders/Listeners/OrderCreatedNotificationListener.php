<?php

namespace App\Modules\Orders\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Notifications\Models\Notification;
use App\Modules\Orders\Types\OrderType;

/**
 * Class OrderCreatedNotificationListener
 *
 * @package App\Modules\Orders\Listeners
 */
class OrderCreatedNotificationListener implements ListenerInterface
{
    const NOTIFICATION_TYPE = 'order';
    
    const NOTIFICATION_ICON = 'fa fa-cart-plus';
    
    public static function listens(): string
    {
        return 'orders::created';
    }
    
    public function handle(OrderType $order)
    {
        Notification::send(
            static::NOTIFICATION_TYPE,
            'orders::general.notification',
            'admin.orders.show',
            ['order' => $order->id]
        );
    }
}