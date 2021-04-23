<?php

namespace App\Modules\Orders\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Orders\Components\Cart\CartItem;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderClient;
use App\Modules\Orders\Models\OrderStatus;
use App\Modules\Orders\Models\OrderStatusesHistory;
use App\Modules\Orders\Requests\CheckoutContactInformationRequest;
use App\Modules\Orders\Requests\CheckoutDeliveryAndPaymentRequest;
use App\Modules\Orders\Types\OrderType;
use App\Modules\Orders\Types\StepOneType;
use Auth, Cart, Exception;
use Illuminate\Http\Request;
use App\Components\Delivery\NovaPoshta;

/**
 * Class CheckoutController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class CheckoutController extends SiteController
{
    use AjaxTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactInformation()
    {
        $info = $this->getUnfinishedOrderInformation();
        $this->sameMeta('orders::site.step-1');
        $this->breadcrumb('orders::site.step-1');
        $formId = 'checkout-information-form';
        return view('orders::site.checkout-step-1', [
            'info' => new StepOneType($info),
            'formId' => $formId,
            'rules' => (new CheckoutContactInformationRequest())->rules(),
            'messages' => (new CheckoutContactInformationRequest())->messages(),
            'attributes' => (new CheckoutContactInformationRequest())->attributes(),
        ]);
    }

    /**
     * @param CheckoutContactInformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function storeContactInformation(CheckoutContactInformationRequest $request)
    {
        $this->validation();
        $novaPoshta = new NovaPoshta($request->input('location'));
        $info = $request->only('name', 'phone', 'email', 'locationId');
        $info['city'] = $request->input('location');
        Cart::linkUnfinishedOrder($info);
        return $this->successJsonAnswer([
            'redirect' => route('site.checkout.step-2'),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function deliveryAndPayment()
    {
        $this->validation();
        $info = $this->getUnfinishedOrderInformation();
        if (!$info) {
            return response()->redirectToRoute('site.checkout');
        }
        $warehouses = (object)[];
        if ($info['city']) {
            $novaPoshta = new NovaPoshta($info['city']);
            $warehouses = $novaPoshta->getWarehouses($novaPoshta->getCity());
            $warehouses = $warehouses->data;
        }
        $this->sameMeta('orders::site.step-2');
        $this->breadcrumb('orders::site.step-2');
        return view('orders::site.checkout-step-2', [
            'info' => new StepOneType($info),
            'deliveries' => config('orders.deliveries', []),
            'restDeliveries' => config('orders.rest-deliveries', []),
            'paymentMethods' => config('orders.payment-methods', []),
            'warehouses' => $warehouses,
            'formId' => 'checkout-delivery-form',
            'rules' => (new CheckoutDeliveryAndPaymentRequest())->rules(),
            'messages' => (new CheckoutDeliveryAndPaymentRequest())->messages(),
            'attributes' => (new CheckoutDeliveryAndPaymentRequest())->attributes(),
            'showLiqpay' => config('db.liqpay.public-key') && config('db.liqpay.private-key'),
        ]);
    }

    /**
     * @param CheckoutDeliveryAndPaymentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function storeDeliveryAndPaymentInformation(CheckoutDeliveryAndPaymentRequest $request)
    {
        $this->validation();
        $data = $this->getUnfinishedOrderInformation();
        if (!$data) {
            return $this->errorJsonAnswer([
                'redirect' => route('site.checkout'),
            ]);
        }
        $orderStatus = OrderStatus::newOrder();
        // Merge data to save
        $delivery = $request->input('delivery');

        $data += $request->only('delivery', 'payment_method', 'comment');
        $data['do_not_call_me'] = (bool)$request->input('do_not_call_me');
        $data['status_id'] = $orderStatus->id;
        $data['city_ref'] = array_get($data, 'locationId');
        if ($delivery === 'nova-poshta-self') {
            $warehouseRef = $request->input($delivery);
            $data['warehouse_ref'] = $warehouseRef;
            $data['delivery_address'] = (new NovaPoshta)->getWarehouseInfo($warehouseRef);
        } else {
            $data['delivery_address'] = $request->input($delivery);
        }
        // Save order
        $order = Order::store($data, Auth::id());
        // Create client in the database and link to the order
        $client = OrderClient::store(
            $order->id,
            array_get($data, 'name'),
            array_get($data, 'phone'),
            array_get($data, 'email')
        );

        $orderId = $order->id;
        $items = [];

        Cart::getItems()->each(function (CartItem $item) use (&$items, $orderId) {
            if($item->getDictionaryId()) {
                $items[$item->getProductId()][] = [
                    'product_id' => $item->getProductId(),
                    'order_id' => $orderId,
                    'quantity' => $item->getQuantity(),
                    'price' => null,
                    'dictionary_id' => $item->getDictionaryId()
                ];
            } else{
                $items[$item->getProductId()][] = [
                    'product_id' => $item->getProductId(),
                    'order_id' => $orderId,
                    'quantity' => $item->getQuantity(),
                    'price' => null,
                ];
            }
        });
        event('orders::data-for-checkout-ready-without-prices', [$items]);
        OrderStatusesHistory::write($order->id, $order->status_id);
        event('orders::created', new OrderType($order, $client, $order->fresh('items')->items));

        if ($order->payment_method === Order::PAYMENT_LIQPAY) {
            return $this->successJsonAnswer([
                'redirect' => route('site.orders.payment-liqpay', $order->id),
            ]);
        }
        session(['thank-you' => $order->id]);
        return $this->successJsonAnswer([
            'redirect' => route('site.thank-you'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function locationSuggest(Request $request)
    {
        $query = $request->input('query');
        $data = (new NovaPoshta)->searchSettlements($query);
        if (!$data || !isset($data['data']) || empty($data['data']) || !isset($data['data'][0]['TotalCount']) || !$data['data'][0]['TotalCount']) {
            return $this->successJsonAnswer([
                'html' => view('orders::site.widgets.location-suggest.location-suggest', ['locations' => []])->render(),
            ]);
        }
        $addresses = $data['data'][0]['Addresses'];
        return $this->successJsonAnswer([
            'html' => view('orders::site.widgets.location-suggest.location-suggest', ['locations' => $addresses])->render(),
        ]);
    }

    /**
     * @return array
     */
    private function getUnfinishedOrderInformation(): array
    {
        if (Cart::hasUnfinishedOrder()) {
            return Cart::getUnfinishedOrder()->getInformation();
        }
        return Auth::guest() ? [] : [
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
            'name' => Auth::user()->name,
        ];
    }

    /**
     * @throws Exception
     */
    private function validation()
    {
        abort_unless(Cart::getTotalQuantity(), 404, 'You can not order nothing');
    }

}
