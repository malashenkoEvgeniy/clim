<?php

namespace App\Modules\Categories\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Categories\Forms\CategoryForm;
use App\Modules\Categories\Models\Category;
use App\Modules\Categories\Requests\CategoryRequest;
use Seo;

/**
 * Class CategoryController
 *
 * @package App\Modules\Categories\Controllers\Admin
 */
class CategoryController extends AdminController
{
    /**
     * CategoryController constructor.
     * Global for controller parts
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add(
            'categories::seo.index',
            RouteObjectValue::make('admin.categories.index')
        );
    }
    
    /**
     * Categories tree page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->addCreateButton('admin.categories.create');
        Seo::meta()->setH1('categories::seo.index');
        $categories = Category::tree();
        if ($categories->isNotEmpty()) {
            return view('categories::admin.index', ['categories' => $categories]);
        }
        return view('categories::admin.no-pages');
    }
    
    /**
     * Create category page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function create()
    {
        Seo::breadcrumbs()->add('categories::seo.create');
        Seo::meta()->setH1('categories::seo.create');
        $this->initValidation((new CategoryRequest())->rules());
        return view('categories::admin.create', [
            'form' => CategoryForm::make(),
        ]);
    }
    
    /**
     * Store new category
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(CategoryRequest $request)
    {
        $category = (new Category());
        if ($message = $category->createRow($request)) {
            return $this->afterFail($message);
        }
        return $this->afterStore(['id' => $category->id]);
    }
    
    /**
     * Update category page
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function edit(Category $category)
    {
        Seo::breadcrumbs()->add($category->current->name ?? 'categories::seo.edit');
        Seo::meta()->setH1('categories::seo.edit');
        $this->initValidation((new CategoryRequest())->rules());
        return view('categories::admin.update', [
            'object' => $category,
            'form' => CategoryForm::make($category),
        ]);
    }
    
    /**
     * Update information for current category
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($message = $category->updateRow($request)) {
            return $this->afterFail($message);
        }
        return $this->afterUpdate();
    }
    
    /**
     * Delete preview in category
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteImage(Category $category)
    {
        $category->deleteImagesIfExist();
        return $this->afterDeletingImage();
    }
    
    /**
     * Delete all data for category including images
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Category $category)
    {
        $category->moveKidsToTheParentCategory();
        $category->deleteRow();
        return $this->afterDestroy();
    }
}
