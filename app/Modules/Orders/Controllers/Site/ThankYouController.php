<?php

namespace App\Modules\Orders\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

/**
 * Class ThankYouController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class ThankYouController extends SiteController
{
    public function show(Request $request)
    {
        $orderId = $request->session()->pull('thank-you');
        abort_unless($orderId, 404);
        $order = Order::find($orderId);
        abort_unless($order && $order->exists, 404);
        return view('orders::site.thank-you-page.thank-you', [
            'order' => $order,
        ]);
    }
}

