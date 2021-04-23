<?php

namespace App\Core\Modules\Images\Controllers\Site;

use App\Components\Image\Watermark;
use App\Core\Modules\Images\Models\Image;
use App\Components\Image\Image as ImageConfiguration;
use Image as InterventionImage;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Storage;

/**
 * Class IndexController
 *
 * @package App\Core\Modules\Images\Controllers\Site
 */
class IndexController extends \App\Core\Controller
{
    
    /**
     * Return cached and resized image
     *
     * @param string $size
     * @param string $image
     * @return mixed
     */
    public function image(string $size, string $image)
    {
        /** @var \Intervention\Image\Image $image */
        $image = \Cache::remember($size . '_' . $image, config('basic.cache_life_time', 2592000), function () use ($size, $image) {
            $imageModel = Image::whereActive(true)->whereName($image)->first();
            abort_unless((bool)$imageModel, 404);
    
            $configurations = $imageModel->configurations();
            $originalConfig = $configurations->getImage('original');
            abort_unless((bool)$originalConfig, 404);
    
            $path = $configurations->getPathToImage($imageModel->name);
            abort_unless($originalConfig->exists($path), 404);
            
            $localSettings = $configurations->getImage($size);
            if ($localSettings === null) {
                return $this->getCachedImageFromSizes($size, $path, $imageModel);
            }
            return $this->getCachedImageFromConfiguration($imageModel, $localSettings, $path);
        });
        $response = \Response::make($image->getEncoded());
        $response->header('Content-Type', $image->mime);
        $response->header('Cache-Control', 'private, max-age="' . config('basic.cache_life_time', 2592000) . '"');
        return $response;
    }
    
    /**
     * @param string $size
     * @param string $image
     * @param string $path
     * @param Image $imageModel
     * @return \Intervention\Image\Image
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getCachedImageFromSizes(string $size, string $path, Image $imageModel): \Intervention\Image\Image
    {
        $sizes = explode('x', $size);
        abort_unless(count($sizes) === 2, 404);
        
        $gdImage = new ImageManager();
        $gdImage = $gdImage->make(Storage::disk()->get($path))->resize($sizes[0], $sizes[1], function ($constraint) {
            $constraint->aspectRatio();
        });
        return $gdImage->encode($imageModel->ext, 100);
    }
    
    /**
     * @param Image $model
     * @param ImageConfiguration $configuration
     * @param string $pathToOriginalImage
     * @return \Intervention\Image\Image
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getCachedImageFromConfiguration(Image $model, ImageConfiguration $configuration, string $pathToOriginalImage): \Intervention\Image\Image
    {
        // Make Image instance
        $image = InterventionImage::make(Storage::disk()->get($pathToOriginalImage));
        // Crop image
        if ($configuration->getCrop() === true && $configuration->getWidth() && $configuration->getHeight()) {
            $image->fit($configuration->getWidth(), $configuration->getHeight());
        } else {
            // Set width
            if ((int)$configuration->getWidth() > 0 && $image->width() > $configuration->getWidth()) {
                $image->widen($configuration->getWidth(), function (Constraint $constraint) {
                    $constraint->upsize();
                });
            }
            // Set height
            if ((int)$configuration->getHeight() > 0 && $image->height() > $configuration->getHeight()) {
                $image->heighten($configuration->getHeight(), function (Constraint $constraint) {
                    $constraint->upsize();
                });
            }
        }
        // Add watermark
        $watermarkConfigurations = $configuration->getWatermark();
        if ($watermarkConfigurations instanceof Watermark && $configuration->getWatermark()->overlay()) {
            $watermark = InterventionImage::make($watermarkConfigurations->getPath());
            if ($configuration->getWatermark()->fill()) {
                if ($watermark->width() > $image->width()) {
                    $watermark->widen($image->width() * 0.25, function (Constraint $constraint) {
                        $constraint->upsize();
                    });
                }
                if ($watermark->height() > $image->height()) {
                    $watermark->heighten($image->height() * 0.25, function (Constraint $constraint) {
                        $constraint->upsize();
                    });
                }
                $image->fill($watermark);
            } else {
                $watermark->widen(round($watermarkConfigurations->getWidthPercent() * $image->width() * 0.01));
                $watermark->opacity($watermarkConfigurations->getOpacity());
                $image->insert($watermark, $watermarkConfigurations->getPosition(), $watermarkConfigurations->getX(), $watermarkConfigurations->getY());
            }
        }
        
        return (new ImageManager)->make($image)->encode($model->ext, 100);
    }
    
}
