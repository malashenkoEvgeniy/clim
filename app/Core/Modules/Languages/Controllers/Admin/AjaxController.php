<?php

namespace App\Core\Modules\Languages\Controllers\Admin;

use App\Core\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AjaxController
 * This class controls languages list on the site
 *
 * @package App\Core\Modules\Languages\Controllers
 */
class AjaxController extends AdminController
{
    
    /**
     * Transliterate it
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function translit(Request $request)
    {
        return response()->json(
            [
                'slug' => Str::substr(Str::slug($request->input('name')), 0, 99),
            ]
        );
    }
    
}
