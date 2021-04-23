<?php

namespace App\Modules\Orders\Controllers\Admin;

use App\Components\Delivery\NovaPoshta;
use App\Core\AjaxTrait;
use App\Core\AdminController;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

/**
 * Class AjaxController
 *
 * @package App\Modules\Orders\Controllers\Admin
 */
class AjaxController extends AdminController
{
    use AjaxTrait;
    
    public function togglePaid(Request $request, Order $order)
    {
        $order->paid = !$order->paid;
        $order->save();
        
        return $this->successJsonAnswer([
            'paid' => $order->paid,
        ]);
    }

    public function getWarehousesForCity(Request $request)
    {
        $cityRef = $request->input('cityRef');
        if(!$cityRef){
            return [];
        }
        $novaPoshta = new NovaPoshta();
        $warehouses = $novaPoshta->getWarehousesCityRef($cityRef)->data;
        return $this->successJsonAnswer([
            'html' => view('orders::admin.widgets.warehouses-for-city', ['warehouses' => $warehouses])->render(),
        ]);
    }
}
