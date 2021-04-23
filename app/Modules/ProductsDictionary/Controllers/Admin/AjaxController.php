<?php

namespace App\Modules\ProductsDictionary\Controllers\Admin;

use App\Core\AdminController;
use App\Core\AjaxTrait;
use App\Modules\Products\Models\Product;
use App\Modules\ProductsDictionary\Models\DictionaryRelation;

/**
 * Class AjaxController
 *
 * @package App\Modules\ProductsDictionary\Controllers\Admin
 */
class AjaxController extends AdminController
{
    use AjaxTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRelations()
    {

        $groupId = request()->input('group_id');
        $values = request()->input('values_ids', []);
        DictionaryRelation::whereGroupId($groupId)->delete();
        foreach ($values as $value){
            $relation = new DictionaryRelation();
            $relation->group_id = $groupId;
            $relation->dictionary_id = $value;
            $relation->save();
        }
        return $this->successJsonAnswer([
            'notyMessage' => trans('products_dictionary::admin.success-update'),
        ]);
    }

}
