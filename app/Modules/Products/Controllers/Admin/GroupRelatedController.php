<?php

namespace App\Modules\Products\Controllers\Admin;

use App\Core\AdminController;
use App\Core\AjaxTrait;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupRelated;
use Illuminate\Http\Request;

/**
 * Class GroupRelatedController
 *
 * @package App\Modules\Products\Controllers\Admin
 */
class GroupRelatedController extends AdminController
{
    use AjaxTrait;
    
    /**
     * @param Request $request
     * @param ProductGroup $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request, ProductGroup $group)
    {
        $item = ProductGroup::find($request->input('groupId'));
        if (!$item || $item->id === $group->id) {
            return $this->errorJsonAnswer();
        }
        $related = ProductGroupRelated::link($group, $item);
        if ($related->wasRecentlyCreated === false) {
            return $this->errorJsonAnswer();
        }
        return $this->successJsonAnswer([
            'element' => view('products::admin.related.item', [
                'group' => $group,
                'item' => $item,
            ])->render(),
        ]);
    }
    
    /**
     * @param ProductGroup $group
     * @param ProductGroup $item
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ProductGroup $group, ProductGroup $item)
    {
        ProductGroupRelated::unlink($group, $item);
        return $this->successJsonAnswer();
    }
    
}
