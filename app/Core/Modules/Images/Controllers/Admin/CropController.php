<?php namespace App\Core\Modules\Images\Controllers\Admin;

use App\Components\Image\ImagesGroup;
use App\Core\AdminController;
use App\Core\Modules\Images\Requests\CropRequest;
use App\Core\Modules\Images\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Seo, Validator, Image;
use App\Core\Modules\Images\Models\Image as ImageModel;

/**
 * Class CropController
 *
 * @package App\Http\Controllers\Admin
 */
class CropController extends AdminController
{
    
    /**
     * @var ImageModel
     */
    private $model;
    
    /**
     * @var string
     */
    private $size;
    
    /**
     * @var string
     */
    private $folder;
    
    /**
     * @var string
     */
    private $field;
    
    /**
     * @var ImagesGroup
     */
    private $settings;
    
    /**
     * @var Crop
     */
    private $crop;
    
    /**
     * Подготавливаем почву для работы кропа
     *
     * @param Request $request
     * @param ImageModel $image
     * @throws \App\Exceptions\WrongParametersException
     */
    private function prepare(Request $request, ImageModel $image)
    {
        $this->model = $image;
        abort_if(!$request->input('back'), 404);
        abort_unless($image->isImageExists(), 404);
        $this->settings = $image->configurations();
        abort_unless($this->settings->imagesThatCanBeCropped()->isNotEmpty(), 404);
        $this->size = $request->input('size');
        if (!$this->size) {
            foreach ($this->settings->imagesThatCanBeCropped() as $imageConfiguration) {
                if ($imageConfiguration->getFolder() !== 'original') {
                    $this->size = $imageConfiguration->getFolder();
                    break;
                }
            }
        }
        abort_unless($this->size, 404);
        $this->field = $image->relatedImagesConfiguration()->getField();
        $this->crop = Crop::whereModelId($image->id)
            ->whereModelName($image->imageable_class)
            ->whereSize($this->size)
            ->whereFolder($this->settings->folder)
            ->first();
        if (!$this->crop) {
            $this->crop = new Crop();
            $this->crop->model_id = $image->id;
            $this->crop->model_name = $image->imageable_class;
            $this->crop->size = $this->settings->imagesThatCanBeCropped()->first()->getFolder();
            $this->crop->folder = $this->settings->folder;
        }
    }
    
    /**
     * Как кроп видит администратор
     *
     * @param Request $request
     * @param ImageModel $crop
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index(Request $request, ImageModel $crop)
    {
        Seo::meta()->setH1(__('images::seo.h1'));
        Seo::breadcrumbs()->add(__('images::seo.breadcrumb'));
        $this->prepare($request, $crop);
        return view(
            'images::crop.index', [
                'settings' => $this->settings,
                'model' => $this->model,
                'localSettings' => $this->settings->getImage($this->size),
                'crop' => $this->crop,
            ]
        );
    }
    
    /**
     * Как происходит процесс обработки фото
     *
     * @param Request $request
     * @param ImageModel $crop
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(Request $request, ImageModel $crop)
    {
        $this->prepare($request, $crop);
        $info = json_decode($request->input('data', '[]'), true);
        $validator = Validator::make($info, (new CropRequest())->rules());
        abort_unless(!$validator->failed(), 422);
        $setting = $this->settings->getImage($this->size);
        $originalImage = $this->settings->getImage('original');
        $image = new UploadedFile(
            $this->settings->getFullPathToImage($this->model->name),
            basename($this->model->name)
        );
        $file = Image::make($image);
        $file->crop((int)$info['width'], (int)$info['height'], (int)$info['x'], (int)$info['y']);
        $file->resize($setting->getWidth(), $setting->getHeight());
        if ($setting->getWatermark()) {
            $watermark = Image::make($setting->getWatermark()->getPath());
            $watermark->widen($setting->getWatermark()->getWidthPercent() * $file->width() / 100);
            $watermark->opacity($setting->getWatermark()->getOpacity());
            $file->insert(
                $watermark,
                $setting->getWatermark()->getPosition(),
                $setting->getWatermark()->getX(),
                $setting->getWatermark()->getY()
            );
        }
        $file->save($this->settings->getFullPathToImage($this->model->name));
        $this->crop->fill($info);
        $this->crop->save();
        return redirect()->back();
    }
}
