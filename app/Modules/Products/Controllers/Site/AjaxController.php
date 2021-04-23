<?php

namespace App\Modules\Products\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AjaxController
 *
 * @package App\Modules\Products\Controllers\Site
 */
class AjaxController extends SiteController
{
    use AjaxTrait;

    /**
     * Live search
     *
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function search(Request $request)
    {
        $limit = 8;

        $query = $request->input('query');
        if (!$query && Str::length($query) >= $limit) {
            return $this->errorJsonAnswer();
        }
        $products = Product::search($limit);
        $products->loadMissing('current');
        return $this->successJsonAnswer([
            'html' => view('products::site.widgets.suggestions.suggestions', [
                'products' => $products,
                'total' => $products->total(),
                'limit' => $limit,
                'query' => $query,
            ])->render(),
        ]);
    }

    public function infoPopup(string $info)
    {
        $type = $info == 'sizes' ? 'products' : 'basic';
        
        return view('site._widgets.popup.wysiwyg', [
            'title' => config("db.{$type}.{$info}_title"),
            'text' => config("db.{$type}.{$info}_text"),
        ]);
    }

}
