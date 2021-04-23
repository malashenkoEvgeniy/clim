<?php

namespace App\Modules\Wishlist\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use Illuminate\Http\Request;
use Wishlist, Widget;

/**
 * Class NewsController
 *
 * @package App\Modules\News\Controllers\Site
 */
class AjaxController extends SiteController
{
    use AjaxTrait;
    
    /**
     * Toggles product in wishlist (adds and removes it)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function toggle(Request $request)
    {
        foreach ($request->input('product_id', []) as $productId) {
            Wishlist::toggle($productId);
        }
        $totalAmount = Widget::show('wishlist::total-amount');
        return $this->successJsonAnswer([
            'total' => Wishlist::count(),
            'widget' => $totalAmount ? $totalAmount->render() : null,
        ]);
    }
}
