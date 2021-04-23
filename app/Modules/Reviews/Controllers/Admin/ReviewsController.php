<?php

namespace App\Modules\Reviews\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Reviews\Filters\ReviewsFilter;
use App\Modules\Reviews\Forms\AdminReviewForm;
use App\Modules\Reviews\Models\Review;
use App\Modules\Reviews\Requests\AdminReviewRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class PagesController
 *
 * @package App\Modules\Pages\Controllers\Admin
 */
class ReviewsController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('reviews::seo.index', RouteObjectValue::make('admin.reviews.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new page button
        $this->addCreateButton('admin.reviews.create');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('reviews::seo.index');
        // Get pages
        $reviews = Review::getList();
        // Return view with sortable pages list
        return view('reviews::admin.index', [
            'reviews' => $reviews,
            'filter' => ReviewsFilter::showFilter(),
        ]);
    }
    
    /**
     * Create new review page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('reviews::seo.create');
        // Set h1
        Seo::meta()->setH1('reviews::seo.create');
        // Javascript validation
        $this->initValidation((new AdminReviewRequest)->rules());
        // Return form view
        return view('reviews::admin.create', [
            'form' => AdminReviewForm::make(),
        ]);
    }
    
    /**
     * Create review in database
     *
     * @param  AdminReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminReviewRequest $request)
    {
        $review = new Review;
        $review->fill($request->all());
        $review->save();
        return $this->afterStore(['id' => $review->id]);
    }
    
    /**
     * Update review page
     *
     * @param  Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Review $review)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('reviews::seo.edit');
        // Set h1
        Seo::meta()->setH1('reviews::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminReviewRequest())->rules());
        // Return form view
        return view('reviews::admin.update', [
            'form' => AdminReviewForm::make($review),
        ]);
    }
    
    /**
     * Update review in database
     *
     * @param  AdminReviewRequest $request
     * @param  Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminReviewRequest $request, Review $review)
    {
        // Fill new data
        $review->fill($request->all());
        // Update existed page
        $review->save();
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete review from database
     *
     * @param  Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Review $review)
    {
        // Delete review
        $review->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
}
