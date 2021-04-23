<?php

namespace App\Modules\ProductsAvailability\Controllers\Site;

use App\Core\SiteController;
use App\Modules\ProductsAvailability\Events\ProductsAvailabilityEvent;
use App\Modules\ProductsAvailability\Models\ProductsAvailability;
use App\Modules\ProductsAvailability\Requests\SiteProductsAvailabilityRequest;
use Auth, Event;
use App\Core\AjaxTrait;

/**
 * Class IndexController
 * @package App\Modules\FastOrders\Controllers\Site
 */
class IndexController extends SiteController
{
    use AjaxTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('products_availability::site.index');
    }

    /**
     * @param SiteProductsAvailabilityRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function send(SiteProductsAvailabilityRequest $request)
    {
        $order = new ProductsAvailability();
        $order->fill($request->all());
        $order->user_id = Auth::id();
        if ($order->save()) {
            $order->save();
            Event::fire(new ProductsAvailabilityEvent($order->email, $order->product_id, $order->id));
            return $this->successMfpMessage(trans('products-availability::general.message-success'));
        }
        return $this->errorJsonAnswer([
            'notyMessage' => trans('products-availability::general.message-false'),
        ]);

    }

}
