<?php

namespace App\Core\Modules\Images\Controllers\Admin;

use App\Core\Modules\Images\Requests\ImagesRequest;
use App\Core\AdminController;
use App\Core\Modules\Images\Components\DropZone;
use App\Core\Modules\Images\Forms\ImageForm;
use App\Core\Modules\Images\Models\Image;
use App\Helpers\Alert;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IndexController
 *
 * @package App\Core\Modules\Images\Controllers\Admin
 */
class IndexController extends AdminController
{
    
    /**
     * Images list
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index()
    {
        $modelClass = request('model');
        $id = request('id');
        $type = request('type');
        
        abort_unless($modelClass && $id && $type, 400, 'Wrong parameters');
        
        /** @var Model|Imageable $model */
        $model = (new $modelClass)->whereId($id)->firstOrFail();
        
        // Send response
        return response()->json([
            'images' => DropZone::make($model, $type)->renderImages()->render(),
        ]);
    }
    
    /**
     * Upload image
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $modelClass = request('model');
        $id = request('id');
        $type = request('type');
    
        abort_unless($modelClass && $id && $type, 400, 'Wrong parameters');
    
        $model = (new $modelClass)->whereId($id)->firstOrFail();
        $model->uploadImage();
        
        // Response
        return response()->json([
            'confirm' => true,
        ]);
    }
    
    /**
     * Images sortable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortable()
    {
        foreach (request()->input('order',[]) as $key => $imageId) {
            Image::whereId($imageId)->update(['position' => $key]);
        }
        return response()->json();
    }
    
    /**
     * Edit image attributes page
     *
     * @param Image $image
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Image $image)
    {
        // Init validation
        $this->initValidation((new ImagesRequest())->rules());
        // Return form view
        return view('images::dropzone.update', [
            'form' => ImageForm::make($image),
            'backUrl' => request('back', route('admin.dashboard')),
        ]);
    }
    
    /**
     * Update data
     *
     * @param ImagesRequest $request
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ImagesRequest $request, Image $image)
    {
        if ($message = $image->updateRow($request)) {
            return $this->afterFail($message);
        }
        $image->collectInformation();
        Alert::success($message ?? 'admin.messages.data-updated');
        return back();
    }
    
    /**
     * Delete image
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteByPost()
    {
        $imageId = request('id');
        /** @var Image $image */
        $image = Image::findOrFail($imageId);
        $image->deleteImage();
        $image->delete();
        return response()->json(['success' => true]);
    }
    
    /**
     * Delete image
     *
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Image $image)
    {
        $image->deleteImage();
        $image->delete();
        return back();
    }
    
}