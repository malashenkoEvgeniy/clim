<?php

namespace App\Modules\FastOrders\Controllers\Site;

use App\Core\SiteController;
use App\Modules\FastOrders\Events\FastOrderEvent;
use App\Modules\FastOrders\Models\FastOrder;
use App\Modules\FastOrders\Requests\SiteFastOrdersRequest;
use Auth, Event;
use App\Core\AjaxTrait;

/**
 * Class FastOrdersController
 * @package App\Modules\FastOrders\Controllers\Site
 */
class FastOrdersController extends SiteController
{
    use AjaxTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('fast_orders::site.index');
    }
    
    /**
     * @param SiteFastOrdersRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function send(SiteFastOrdersRequest $request)
    {
        $fastOrder = new FastOrder();
        $fastOrder->fill($request->all());
        $fastOrder->ip = request()->ip();
        $fastOrder->user_id = Auth::id();
        if($fastOrder->save()){
            $fastOrder->save();
            Event::fire(new FastOrderEvent($fastOrder->phone, $fastOrder->product_id, $fastOrder->id));
            return $this->successMfpMessage(trans('fast_orders::general.message-success'));
        }
        return $this->errorJsonAnswer([
            'notyMessage' => trans('fast_orders::general.message-false'),
        ]);
        
    }

}
