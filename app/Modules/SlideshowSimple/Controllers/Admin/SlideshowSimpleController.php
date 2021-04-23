<?php

namespace App\Modules\SlideshowSimple\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SlideshowSimple\Forms\SlideshowSimpleForm;
use App\Modules\SlideshowSimple\Images\SliderBgImage;
use App\Modules\SlideshowSimple\Models\SlideshowSimple;
use App\Modules\SlideshowSimple\Requests\SliderSimpleRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class SlideshowSimpleController
 *
 * @package App\Modules\SlideshowSimple\Controllers\Admin
 */
class SlideshowSimpleController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('slideshow_simple::seo.index', RouteObjectValue::make('admin.slideshow_simple.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new slideshow button
        $this->addCreateButton('admin.slideshow_simple.create');
    }
    
    /**
     * News sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('slideshow_simple::seo.index');
        // Get slideshowSimple
        $sliders = SlideshowSimple::getList();
        // Return view list
        return view('slideshow_simple::admin.index', ['sliders' => $sliders]);
    }
    
    /**
     * Create new element page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('slideshow_simple::seo.create');
        // Set h1
        Seo::meta()->setH1('slideshow_simple::seo.create');
        // Javascript validation
        $this->initValidation((new SliderSimpleRequest())->rules());
        // Return form view
        return view('slideshow_simple::admin.create', [
            'form' => SlideshowSimpleForm::make(),
        ]);
    }
    
    /**
     * Create page in database
     *
     * @param SliderSimpleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(SliderSimpleRequest $request)
    {
        $slideshowSimple = (new SlideshowSimple());
        // Create new slideshowSimple
        if ($message = $slideshowSimple->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $slideshowSimple->id]);
    }
    
    /**
     * Update element page
     *
     * @param SlideshowSimple $slideshowSimple
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SlideshowSimple $slideshowSimple)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($slideshowSimple->current->name ?? 'slideshow_simple::seo.edit');
        // Set h1
        Seo::meta()->setH1('slideshow_simple::seo.edit');
        // Javascript validation
        $this->initValidation((new SliderSimpleRequest())->rules());
        // Return form view
        return view('slideshow_simple::admin.update', [
            'form' => SlideshowSimpleForm::make($slideshowSimple),
        ]);
    }
    
    /**
     * Update page in database
     *
     * @param SliderSimpleRequest $request
     * @param SlideshowSimple $slideshowSimple
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(SliderSimpleRequest $request, SlideshowSimple $slideshowSimple)
    {
        // Update existed slideshow
        if ($message = $slideshowSimple->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param SlideshowSimple $slideshowSimple
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(SlideshowSimple $slideshowSimple)
    {
        // Delete news's image
        $slideshowSimple->deleteImagesIfExist();
        // Delete news
        $slideshowSimple->forceDelete();
        // Do something
        return $this->afterDestroy();
    }
    
    /**
     * Delete image
     *
     * @param SlideshowSimple $slideshowSimple
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteImage(SlideshowSimple $slideshowSimple)
    {
        // Delete slideshowSimple's image
        $slideshowSimple->deleteImagesIfExist();
        // Do something
        return $this->afterDeletingImage();
    }
    
}
