<?php

namespace App\Modules\SeoFiles\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoFiles\Forms\AdminSeoFilesForm;
use App\Modules\SeoFiles\Forms\AdminUpdateSeoFileForm;
use App\Modules\SeoFiles\Models\SeoFile;
use App\Modules\SeoFiles\Requests\AdminSeoFilesRequest;
use App\Modules\SeoFiles\Requests\AdminUpdateSeoFilesRequest;
use Seo;

/**
 * Class SeoFilesController
 *
 * @package App\Modules\SeoFiles\Controllers\Admin
 */
class SeoFilesController extends AdminController
{

    public function __construct()
    {
        Seo::breadcrumbs()->add('seo_files::seo.index', RouteObjectValue::make('admin.seo_files.index'));
    }

    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new seoScript button
        $this->addCreateButton('admin.seo_files.create');
    }

    /**
     * SeoFiles list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('seo_files::seo.index');
        // Return view list
        return view('seo_files::admin.index', [
            'seoFiles' => SeoFile::getAll(),
        ]);
    }

    /**
     * Create new file
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('seo_files::seo.create');
        // Set h1
        Seo::meta()->setH1('seo_files::seo.create');
        // Javascript validation
        $this->initValidation((new AdminSeoFilesRequest)->rules());
        // Return form view
        return view('seo_files::admin.create', [
            'form' => AdminSeoFilesForm::make(),
        ]);
    }

    /**
     * Create new file
     *
     * @param  AdminSeoFilesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminSeoFilesRequest $request)
    {
        try {
            return $this->afterStore(['id' => SeoFile::createFile($request)]);
        } catch (\Exception $exception) {
            return $this->afterFail($exception->getMessage());
        }
    }

    /**
     * @param SeoFile $seoFile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(SeoFile $seoFile)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($seoFile->name ?? 'seo_files::seo.edit');
        // Set h1
        Seo::meta()->setH1('seo_files::seo.edit');
        // Javascript validation
        $this->initValidation((new AdminUpdateSeoFilesRequest())->rules());
        return view('seo_files::admin.update', [
            'form' => AdminUpdateSeoFileForm::make($seoFile),
        ]);
    }

    /**
     * Update content in file
     *
     * @param SeoFile$seoFile
     * @param AdminUpdateSeoFilesRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminUpdateSeoFilesRequest $request, SeoFile $seoFile)
    {
        $seoFile->updateContent($request);
        // Do something
        return $this->afterUpdate();
    }

    /**
     * Delete file
     *
     * @param SeoFile $seoFile
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(SeoFile $seoFile)
    {
        $seoFile->deleteFile();
        // Do something
        return $this->afterDestroy();
    }
}
