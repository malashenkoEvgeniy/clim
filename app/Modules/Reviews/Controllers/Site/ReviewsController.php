<?php

namespace App\Modules\Reviews\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Reviews\Models\Review;
use App\Core\AjaxTrait;
use App\Modules\Reviews\Requests\SiteReviewRequest;
use Carbon\Carbon;
use Auth;

/**
 * Class ReviewsController
 *
 * @package App\Modules\Reviews\Controllers\Site
 */
class ReviewsController extends SiteController
{

    use AjaxTrait;
    /**
     * @var SystemPage
     */
    static $page;
    
    /**
     * ReviewsController constructor.
     */
    public function __construct()
    {
        /** @var SystemPage $page */
        static::$page = SystemPage::getByCurrent('slug', 'reviews');
        abort_unless(static::$page && static::$page->exists, 404);
    }

    /**
     * Reviews list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reviews = Review::getReviewsForClientSide();
        $this->pageNumber();
        $this->canonical(route('site.reviews'));
        $this->meta(static::$page->current, static::$page->current->content);
        $this->breadcrumb(static::$page->current->name, 'site.reviews');
        $this->setOtherLanguagesLinks(static::$page);
        $this->initValidation((new SiteReviewRequest)->rules(), '#review-form');
        return view('reviews::site.index', [
            'reviews' => $reviews,
            'page' => static::$page,
        ]);
    }
    
    /**
     * @param SiteReviewRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function send(SiteReviewRequest $request)
    {
        $review = new Review();
        $review->fill($request->all());
        $review->published_at = Carbon::now();
        $review->active = false;
        $review->user_id = Auth::id();
        if ($review->save()) {
            event('review', $review);
            event('review::created', $review);
        }
        if ($request->expectsJson()) {
            return $this->successJsonAnswer([
                'notyMessage' => 'Отзыв сохранен!',
                'replaceForm' => view('reviews::site.message')->render(),
            ]);
        }
        return redirect()->route('site.reviews');
    }
}
