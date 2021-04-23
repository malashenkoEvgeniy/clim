<?php

namespace App\Modules\ProductsAvailability\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\ProductsAvailability\Requests\SiteProductsAvailabilityRequest;
use Auth;

/**
 * Class Popup
 *
 * @package App\Modules\Callback\Widgets
 */
class ProductsAvailability implements AbstractWidget
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
        $formId = uniqid('products-availability');
        $validation = \JsValidator::make(
            (new SiteProductsAvailabilityRequest())->rules(),
            [],
            [],
            "#$formId"
        );
        return view('products_availability::site.popup.order', [
            'productId'=> $this->productId,
            'formId' => $formId,
            'validation' => $validation,
            'email' => Auth::check() ? Auth::user()->email : null,
        ]);
    }

}
