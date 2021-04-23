<?php

namespace App\Modules\FastOrders\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\FastOrders\Requests\SiteFastOrdersRequest;
use Auth;

/**
 * Class Popup
 *
 * @package App\Modules\Callback\Widgets
 */
class FastOrder implements AbstractWidget
{
    /**
     * @var int
     */
    protected $productId;

    /**
     * ProductCard constructor.
     *
     * @param int $product
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $formId = uniqid('orders-one-click-buy');
        $validation = \JsValidator::make(
            (new SiteFastOrdersRequest())->rules(),
            [],
            [],
            "#$formId"
        );
        return view('fast_orders::site.popup.one-click-buy', [
            'productId'=> $this->productId,
            'formId' => $formId,
            'validation' => $validation,
            'phone' => Auth::check() ? Auth::user()->phone : null,
        ]);
    }

}
