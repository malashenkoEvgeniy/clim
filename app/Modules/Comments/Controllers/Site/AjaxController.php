<?php

namespace App\Modules\Comments\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Comments\Models\Comment;
use App\Modules\Comments\Requests\SiteCommentRequest;
use Illuminate\Http\Request;
use Widget;

/**
 * Class AjaxController
 *
 * @package App\Modules\Comments\Controllers\Site
 */
class AjaxController extends SiteController
{
    use AjaxTrait;

    public function products(Request $request, string $type, int $id)
    {
        return $this->successJsonAnswer([
            'html' => (string)Widget::show('comments::product-reviews', $type, $id),
        ]);
    }

    /**
     * @param SiteCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(SiteCommentRequest $request)
    {
        Comment::createByUser();
        return $this->successJsonAnswer([
            'replaceForm' => view('comments::site.message')->render(),
        ]);
    }

}
