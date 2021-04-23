<?php

namespace App\Core\Modules\Dashboard\Controllers\Admin;

use App\Core\AdminController;

/**
 * Class IndexController
 *
 * @package App\Core\Modules\Dashboard\Controllers\Admin
 */
class IndexController extends AdminController
{
    
    /**
     * Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard::index');
    }
    
}
