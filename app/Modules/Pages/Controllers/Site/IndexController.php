<?php

namespace App\Modules\Pages\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Pages\Models\Page;

/**
 * Class IndexController
 *
 * @package App\Modules\Pages\Controllers\Site
 */
class IndexController extends SiteController
{
    
    public function page(string $slug)
    {
        /** @var Page $page */
        $page = Page::getByCurrent('slug', $slug);
        abort_if(!$page || !$page->exists || !$page->active, 404);
    
        $this->meta($page->current);
        $this->breadcrumb($page->current->name, 'site.page', [$page->current->slug]);
        $this->canonical(route('site.page', [$page->current->slug]));
        return view('pages::site.page', [
            'page' => $page,
        ]);
    }
    
}