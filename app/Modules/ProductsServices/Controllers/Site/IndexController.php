<?php

namespace App\Modules\ProductsServices\Controllers\Site;

use App\Core\AdminController;
use App\Modules\ProductsServices\Models\ProductService;

/**
 * Class IndexController
 *
 * @package App\Modules\ProductsServices\Controllers\Admin
 */
class IndexController extends AdminController
{
    public function info(ProductService $service)
    {
        return view('site._widgets.popup.wysiwyg', [
            'title' => $service->current->name,
            'text' => $service->current->text,
        ]);
    }
}
