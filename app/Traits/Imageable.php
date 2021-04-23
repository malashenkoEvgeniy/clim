<?php

namespace App\Traits;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;
use App\Core\Modules\Images\Models\Image;
use App\Exceptions\WrongParametersException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * Trait Imageable
 * Adds functionality to store images
 *
 * @package App\Traits
 */
trait Imageable
{

    /**
     * @var ImagesGroup
     */
    private $configurations;

    /**
     * @var ImageContainer[]|Collection
     */
    private $imagesMap;

    /**
     * Current type of image to work with
     *
     * @var string
     */
    private $defaultType;

    /**
     * Get $defaultType property
     *
     * @return null|string
     * @throws WrongParametersException
     */
    public function getDefaultType(): ?string
    {
        if ($this->defaultType) {
            return $this->defaultType;
        }
        if (!($this->imagesMap instanceof Collection)) {
            $this->makeImagesMap();
        }
        $firstRowInCollection = $this->imagesMap->first();
        if ($firstRowInCollection) {
            return $this->defaultType = $firstRowInCollection->getType();
        }
        return null;
    }

    /**
     * Name of the field in the form
     *
     * @param string|null $type
     * @return string
     * @throws WrongParametersException
     */
    protected function imageFieldName(?string $type = null): string
    {
        return $this->imageInstance($type)->getField();
    }

    /**
     * Image class name(s)
     *
     * @return string|array
     */
    protected abstract function imageClass();

    /**
     * Get image configurations class instance
     *
     * @param string|null $type
     * @return ImageContainer
     * @throws WrongParametersException
     */
    public function imageInstance(?string $type = null): ImageContainer
    {
        if (!($this->imagesMap instanceof Collection)) {
            $this->makeImagesMap();
        }
        $type = $type ?? $this->getDefaultType();
        if ($this->imagesMap->has($type)) {
            return $this->imagesMap->get($type);
        }
        throw new WrongParametersException("Wrong images type {$type}!");
    }

    /**
     * @param string $size
     * @param array $attributes
     * @param bool $noPreview
     * @param string|null $noPhoto
     * @return string|null
     */
    public function imageTag(string $size, array $attributes = [], bool $noPreview = false, ?string $noPhoto = null): ?string
    {
        return $this->image->imageTag($size, $attributes, $noPreview, $noPhoto);
    }

    /**
     * Make map of images configurations
     *
     * @throws WrongParametersException
     */
    private function makeImagesMap()
    {
        $this->imagesMap = new Collection();
        $classes = $this->imageClass();
        if (is_string($classes)) {
            $classes = [$classes];
        }
        foreach ($classes as $class) {
            /** @var ImageContainer $instance */
            $instance = app()->make($class);
            $this->imagesMap->put($instance->getType(), $instance);
        }
        if ($this->imagesMap->isEmpty()) {
            throw new WrongParametersException('Please specify some images types');
        }
    }

    /**
     * Returns image configurations
     *
     * @param string|null $type
     * @return ImagesGroup
     * @throws WrongParametersException
     */
    protected function imageConfigurations(?string $type = null): ImagesGroup
    {
        return $this->imageInstance($type)->configurations();
    }

    /**
     * Check if file was uploaded
     *
     * @param string|null $type
     * @return bool
     * @throws \App\Exceptions\WrongParametersException
     */
    public function fileUploaded(?string $type = null): bool
    {
        $imageFieldName = $this->imageFieldName($type);
        return $this->fileValidation(request()->file($imageFieldName));
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function fileValidation(?UploadedFile $file): bool
    {
        return $file && UPLOAD_ERR_OK === $file->getError() && $file->isFile();
    }

    /**
     * Real images configurations
     *
     * @param string|null $type
     * @return ImagesGroup
     * @throws \App\Exceptions\WrongParametersException
     */
    public function configurations(?string $type = null): ImagesGroup
    {
        return $this->imageConfigurations($type);
    }

    /**
     * Get all images for current row
     *
     * @return mixed
     */
    public function allImages()
    {
        return $this->hasMany(Image::class, 'imageable_id', 'id')
            ->whereIn('imageable_type', (array)$this->imageClass())
            ->oldest('position')
            ->latest('id');
    }

    /**
     * Get images by default type
     *
     * @return mixed
     * @throws WrongParametersException
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'imageable_id', 'id')
            ->where('imageable_type', '=', $this->getDefaultType())
            ->oldest('position')
            ->latest('id');
    }

    /**
     * Get images by custom type
     *
     * @param null|string $type
     * @return EloquentCollection
     */
    public function getImages(string $type): EloquentCollection
    {
        return $this->hasMany(Image::class, 'imageable_id', 'id')
            ->where('imageable_type', '=', $type)
            ->oldest('position')
            ->latest('id')
            ->get();
    }

    /**
     * First image from the list by default type
     *
     * @return mixed
     * @throws WrongParametersException
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'imageable_id', 'id')
            ->where('imageable_type', '=', $this->getDefaultType())
            ->oldest('position')
            ->latest('id')
            ->withDefault();
    }

    /**
     * Get one image by custom type
     *
     * @param null|string $type
     * @return mixed
     */
    public function getImage(string $type)
    {
        foreach ($this->allImages as $image) {
            if ($type === $image->imageable_type) {
                return $image;
            }
        }
        return null;
    }

    /**
     * Upload image
     *
     * @param string|null
     * @throws \App\Exceptions\WrongParametersException
     */
    public function uploadImage(?string $type = null)
    {
        if (request()->file($this->imageFieldName($type))) {
            $this->uploadImageFromResource(request()->file($this->imageFieldName($type)), $type);
        }
    }

    /**
     * @param UploadedFile $photo
     * @param string|null
     * @throws WrongParametersException
     */
    public function uploadImageFromResource(UploadedFile $photo, ?string $type = null)
    {
        // Get configurations
        $configurations = $this->configurations($type);
        // Check for sizes existence
        if ($configurations->sizes->count() === 0) {
            return;
        }
        // Photo validation
        if (!$this->fileValidation($photo)) {
            return;
        }
        // Generate filename
        $filename = $photo->hashName();
        // Resize, crop and store file
        $imageSize = $configurations->sizes->get('original');
        $imageSize->store($photo, $configurations->getPathToImage($filename));
        // Add image name to the column for storing in database
        (new Image)->store($this, $type ?? $this->getDefaultType(), $photo, $filename);
    }

    /**
     * Upload new file to storage & link it with current model
     * This method will delete old file if it exists
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    public function updateImage()
    {
        if ($this->fileUploaded()) {
            // Delete existed image if exists
            $this->deleteImagesIfExist();
            // Upload new image
            $this->uploadImage();
        }
    }

    /**
     * Delete images from current group for default type
     */
    public function deleteImagesIfExist()
    {
        $this->images->each(function (Image $image) {
            $image->deleteImage();
            $image->delete();
        });
    }

    /**
     * Delete images from current group for default type
     */
    public function deleteAllImages()
    {
        $this->allImages->each(function (Image $image) {
            $image->deleteImage();
            $image->delete();
        });
    }

    /**
     * Delete images from current group by type
     *
     * @param string $type
     */
    public function deleteImagesIfExistByType(string $type)
    {
        $this->getImages($type)->each(function (Image $image) {
            $image->deleteImage();
            $image->delete();
        });
    }

}
