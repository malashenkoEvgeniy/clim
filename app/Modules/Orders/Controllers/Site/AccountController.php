<?php

namespace App\Modules\Orders\Controllers\Site;

use App\Components\Delivery\NovaPoshta;
use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Orders\Models\Order;
use Auth;
use Carbon\Carbon;

/**
 * Class AccountController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class AccountController extends SiteController
{
    use AjaxTrait;

    public function index()
    {
        $this->sameMeta('orders::site.my-orders');
        $this->breadcrumb('orders::site.my-orders');
        $orders = Order::paginateForUser(Auth::id());
        return view('orders::site.account', [
            'orders' => $orders,
        ]);
    }


    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getDeliveryStatus(Order $order)
    {
        if ($order->ttn) {
            $novaposhta = new NovaPoshta();
            $response = $novaposhta->getDeliveryInformationByTTN($order->ttn);
            $deliveryInformation = array_get($response->data, 0);
            if ($response && $deliveryInformation) {
                $date = Carbon::parse($deliveryInformation->DateCreated);
                $data = [
                    'delivery' => [
                        'ttn' => $deliveryInformation->Number,
                        'date' => $date->format('d') . ' ' .
                            __(config('months.full.' . $date->format('n'), $date->format('m'))) . ' ' .
                            $date->format('Y'),
                        'time' => $date->format('H:i:s'),
                        'citySender' => $deliveryInformation->CitySender,
                        'cityRecipient' => $deliveryInformation->CityRecipient,
                        'status' => $deliveryInformation->Status,
                        'warehouseRecipient' => $deliveryInformation->WarehouseRecipient,
                    ],
                    'link' => route('site.orders.get-delivery-status', ['order' => $order->id]),
                ];
                return view('orders::site.widgets.delivery-status.delivery-status', $data);
            }
        }
        return response()->json(null, 204);
    }

}
