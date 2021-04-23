<?php

namespace App\Modules\CompareProducts\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use CompareProducts;

/**
 * Class AjaxController
 *
 * @package App\Modules\Compare\Controllers\Site
 */
class AjaxController extends SiteController
{
    use AjaxTrait;
    
    /**
     * Toggles product in comparison (adds and removes it)
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function toggle(int $productId)
    {
        CompareProducts::toggle($productId);
        return $this->successJsonAnswer([
            'total' => CompareProducts::count(),
        ]);
    }
}
