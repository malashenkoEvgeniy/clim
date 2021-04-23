<?php

use App\Modules\Orders\Models\Order;

return [
    'deliveries' => [
        'nova-poshta-self' => 'orders::general.deliveries.nova-poshta-self',
        'nova-poshta' => 'orders::general.deliveries.nova-poshta',
        'self' => 'orders::general.deliveries.self',
        'address' => 'orders::general.deliveries.ukrposhta',
        'other' => 'orders::general.deliveries.other',
    ],
    'payment-methods' => [
        'cash' => 'orders::general.payment-methods.cash',
        'bank_transaction' => 'orders::general.payment-methods.bank_transaction',
        Order::PAYMENT_LIQPAY => 'orders::general.payment-methods.liqpay',
        'cash-on-delivery' => 'orders::general.payment-methods.cash-on-delivery',
    ],
    'rest-deliveries' => [
        'in-time' => 'Ин Тайм',
        'delivety' => 'Деливери',
        'night-express' => 'Ночной экспресс',
        'auto-lux' => 'Автолюкс',
    ],
];
