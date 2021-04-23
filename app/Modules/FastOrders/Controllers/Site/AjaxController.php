<?php

namespace App\Modules\FastOrders\Controllers\Site;

use App\Core\SiteController;
use App\Modules\FastOrders\Requests\SiteFastOrdersRequest;
use Illuminate\Http\Request;

class AjaxController extends SiteController
{
    public function popup(Request $request, int $productId)
    {
        return \Widget::show('orders-one-click-buy', $productId) ?? '';
    }
}
