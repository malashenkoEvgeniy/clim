<?php

namespace App\Modules\Pages\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Pages\Models\Page;

class PageMenu implements AbstractWidget
{

    private $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function render()
    {
        if (!isset($this->page->menu)) {
            return null;
        }
        $menuItems = Page::getMenuAtPage($this->page->menu);
        if ($menuItems->IsEmpty()) {
            return null;
        }
        return view('pages::site.widgets.menu', ['menuItems' => $menuItems,'current'=> $this->page->current->slug]);
    }

}
