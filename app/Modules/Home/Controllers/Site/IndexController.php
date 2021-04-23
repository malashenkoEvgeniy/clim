<?php

namespace App\Modules\Home\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Home\Provider;

/**
 * Class IndexController
 *
 * @package App\Modules\Home\Controllers\Site
 */
class IndexController extends SiteController
{
    
    public function home()
    {
        $this->meta(Provider::$page->current, Provider::$page->current->content);
        $this->canonical(route('site.home'));
        return view('home::site.home', [
            'page' => Provider::$page,
        ]);
    }
    
}
