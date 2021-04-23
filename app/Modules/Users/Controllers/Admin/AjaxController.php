<?php

namespace App\Modules\Users\Controllers\Admin;

use App\Core\AjaxTrait;
use App\Core\AdminController;
use App\Modules\Users\Models\User;

/**
 * Class AjaxController
 *
 * @package App\Modules\Users\Controllers\Admin
 */
class AjaxController extends AdminController
{
    use AjaxTrait;
    
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index()
    {
        $users = [];
        /** @var User $user */
        foreach (User::forList() as $user) {
            $users[] = [
                'id' => $user->id,
                'markup' => view('users::admin.live-search-select-markup', ['user' => $user])->render(),
                'selection' => view('users::admin.live-search-select-selection', ['user' => $user])->render(),
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ];
        }
        return $this->successJsonAnswer([
            'items' => $users,
        ]);
    }
}
