<?php

namespace App\Modules\Orders\Controllers\Site;

use App\Components\Payments\Services\LiqPay;
use App\Modules\Currencies\Models\Currency as CurrencyModel;
use Illuminate\Http\Request;
use App\Modules\Orders\Models\Order;
use Lang;

/**
 * Class LiqPayController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class LiqPayController
{
    
    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function form(Order $order)
    {
        /** @var CurrencyModel $currency */
        $currency = config('currency.site');
        abort_if(Order::PAYMENT_LIQPAY !== $order->payment_method, 404);
        $liqpay = new LiqPay();
        session(['thank-you' => $order->id]);
        return view('orders::site.liqpay', [
            'form' => $liqpay->cnb_form([
                'version' => '3',
                'amount' => (float)$order->total_amount,
                'sandbox' => (int)config('db.liqpay.test'),
                'currency' => $currency->microdata,
                'description' => __('settings::liqpay.order-pay') . $order->id . ' ' . __('settings::liqpay.site') . ' ' . route('site.home'),
                'order_id' => $order->id,
                'pay_way' => 'card,privat24,liqpay',
                'language' => Lang::getLocale(),
                'server_url' => route('site.orders.payment-liqpay-process'),
                'result_url' => route('site.thank-you'),
            ]),
        ]);
    }
    
    /**
     * @param Request $request
     */
    public function process(Request $request)
    {
        $data = $request->input('data');
        $postSignature = $request->input('signature');
    
        $privateKey = config('db.liqpay.private-key');
        $sign = base64_encode(sha1($privateKey . $data . $privateKey, 1));
        
        abort_unless($postSignature == $sign, 404);
    
        $result = json_decode(base64_decode($data), true);
        
        if (array_get($result, 'status') === 'success' || array_get($result, 'status') === 'sandbox') {
             $order = Order::findOrFail(array_get($result, 'order_id'));
             $order->paid = true;
             $order->paid_auto = true;
             $order->save();
        }
    }

}
