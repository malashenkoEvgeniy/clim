<?php

namespace App\Modules\Orders\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Orders\Models\Order;
use Auth;

/**
 * Class PrintController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class PrintController extends SiteController
{

    public function show(Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            return redirect()->route('site.home')
                    ->with([
                        'message' => request()->session()->get('message'),
                    ]);
        }
        return view('orders::site.print-order.print-order', [
            'order' => $order,
        ]);
    }

}
