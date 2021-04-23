<?php

namespace App\Modules\Users\Controllers\Site\Auth;

use App\Core\SiteController;

/**
 * Class DemoController
 *
 * @package App\Modules\Users\Controllers\Site\Auth
 */
class DemoController extends SiteController
{
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (isDemo()) {
            session(['demo' => true]);
        }
        return redirect()->to('/');
    }
    
}
