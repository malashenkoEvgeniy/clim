<?php

namespace App\Modules\Import\Controllers\Admin;

use App\Components\Parsers\Entry;
use App\Core\AjaxTrait;
use App\Modules\Import\Jobs\Import;
use App\Core\AdminController;
use App\Modules\Import\Forms\ImportForm;
use App\Modules\Import\Requests\ImportRequest;
use Storage;
use App\Modules\Import\Models\Import as ImportModel;

/**
 * Class IndexController
 *
 * @package App\Modules\Import\Controllers\Admin
 */
class IndexController extends AdminController
{
    use AjaxTrait;
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        $this->initValidation((new ImportRequest)->rules());
        return view('import::admin.index', [
            'form' => ImportForm::make(),
            'import' => ImportModel::getLast(),
        ]);
    }
    
    /**
     * @param ImportRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Throwable
     */
    public function store(ImportRequest $request)
    {
        $import = ImportModel::start($request->only(
            'images',
            'course',
            'categories',
            'products'
        ));
        if ($request->input('type') === Entry::TYPE_YANDEX_MARKET) {
            Import::dispatch($request->input('url'), $import, Entry::TYPE_YANDEX_MARKET);
        } else {
            $file = $request->file('import');
            Storage::put('import.' . $file->clientExtension(), $file->get());
            Import::dispatch('import.' . $file->clientExtension(), $import);
        }
        return redirect()->back();
    }
    
    /**
     * Check import status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        $import = ImportModel::getLast();
        return $this->successJsonAnswer([
            'status' => $import ? $import->status : '',
        ]);
    }
}
