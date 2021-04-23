<?php

namespace App\Modules\Orders\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Orders\Models\Order;
use CustomRoles;

/**
 * Class DashboardOrders
 *
 * @package App\Modules\Orders\Widgets
 */
class DashboardOrders implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (CustomRoles::can('orders.index') === false) {
            return null;
        }
        
        $orders = Order::paginatedList(5);
        
        return view('orders::admin.orders.dashboard-widget', [
            'orders' => $orders,
        ]);
    }
    
}
