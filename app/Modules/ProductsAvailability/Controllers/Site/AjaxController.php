<?php

namespace App\Modules\ProductsAvailability\Controllers\Site;

use App\Core\SiteController;

class AjaxController extends SiteController
{
    /**
     * @param $productId
     * @return null|string
     */
    public function popup($productId)
    {
        return \Widget::show('products-availability', $productId) ?? '';
    }
}
