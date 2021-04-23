<?php

namespace App\Core\Modules\Images\Models;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;
use App\Core\Modules\Languages\Models\Language;
use App\Exceptions\WrongParametersException;
use App\Traits\Imageable;
use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use URL;

/**
 * App\Core\Modules\Images\Models\Image
 *
 * @property int $id
 * @property string $imageable_class Model name Catalog::class, Gallery::class etc.
 * @property string $imageable_type Type of the image (Catalog::class, Gallery::class etc.)
 * @property int $imageable_id ID of the related row
 * @property bool $active
 * @property int $position
 * @property string $name
 * @property string $basename
 * @property string $mime
 * @property string $ext
 * @property string $size
 * @property array|null $information
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Core\Modules\Images\Models\ImageTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\ImageTranslates[] $data
 * @property-read string $edit_page_link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereBasename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereImageableClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use ModelMain;
    
    protected $casts = ['active' => 'boolean', 'information' => 'array'];
    
    protected $fillable = ['name', 'basename', 'mime', 'ext', 'size'];
    
    /**
     * @param string $size
     * @param array $attributes
     * @param bool $noPreview
     * @param string $noPhoto
     * @return null|string
     */
    public function imageTag(string $size, array $attributes = [], bool $noPreview = false, ?string $noPhoto = null): ?string
    {
        return \Widget::show('image', $this, $size, $attributes, $noPreview, $noPhoto);
    }
    
    /**
     * Store image to database & link it to the model
     *
     * @param Model $model
     * @param string $type
     * @param UploadedFile $file
     * @param string $filename
     * @return bool
     */
    public function store(Model $model, string $type, UploadedFile $file, string $filename): bool
    {
        $image = new Image();
        $image->name = $filename;
        $image->basename = $file->getClientOriginalName();
        $image->mime = $file->getMimeType();
        $image->ext = $file->extension();
        $image->size = $file->getSize();
        $image->imageable_class = get_class($model);
        $image->imageable_type = $type;
        $image->imageable_id = $model->id;
        if ($image->save()) {
            foreach (config('languages', []) as $language) {
                /** @var Language $language */
                ImageTranslates::createEmpty($image, $language);
            }
            return true;
        }
        return false;
    }
    
    /**
     * Collect information to save
     *
     * @return bool
     */
    public function collectInformation(): bool
    {
        $information = [];
        foreach (request()->post() as $key => $value) {
            if (
                !in_array($key, $this->fillable) &&
                !config('languages.' . $key) &&
                !in_array($key, ['_token', '_method', 'submit_only'])
            ) {
                $information[$key] = $value;
            }
        }
        $this->information = $information;
        return $this->save();
    }
    
    /**
     * Generate link to thumb. Image will be cropped and cached
     *
     * @param  string $folder
     * @return string
     */
    public function link(string $folder = 'original'): ?string
    {
        if ($this->name && $this->isImageExists()) {
            return (string)route('site.image.cache', [$folder, $this->name]);
        }
        return site_media('static/images/placeholders/no-photo.png');
    }

    /**
     * Show edit page link
     *
     * @return string
     */
    public function getEditPageLinkAttribute()
    {
        return route('admin.images.edit', [
            'id' => $this->id,
            'back' => URL::previous(),
        ]);
    }
    
    /**
     * Check if image exists
     *
     * @param  string $folder
     * @return bool
     */
    public function isImageExists(string $folder = 'original'): bool
    {
        if (!$this->exists) {
            return false;
        }
        $model = new $this->imageable_class;
        // Get configurations
        $configurations = $model->configurations($this->imageable_type);
        // Get current size Image config object
        $image = $configurations->getImage($folder);
        // Checks
        if (!$image || !$this->name) {
            return false;
        }
        // Return answer
        return $image && $image->exists($configurations->getPathToImage($this->name));
    }
    
    /**
     * Delete image
     *
     * @return bool
     */
    public function deleteImage()
    {
        return (new $this->imageable_class)->configurations($this->imageable_type)->deleteImages($this->name);
    }
    
    /**
     * Returns link to the original image
     *
     * @return null|string
     */
    public function __toString(): ?string
    {
        return $this->link('original', $this->imageable_type);
    }
    
    /**
     * @return ImagesGroup|null
     * @throws \App\Exceptions\WrongParametersException
     */
    public function configurations(): ?ImagesGroup
    {
        $imageInstance = $this->relatedImagesConfiguration();
        if ($imageInstance) {
            return $imageInstance->configurations();
        }
        throw new WrongParametersException();
    }
    
    /**
     * @return ImageContainer
     * @throws \App\Exceptions\WrongParametersException
     */
    public function relatedImagesConfiguration(): ImageContainer
    {
        /** @var Imageable $model */
        $model = (new $this->imageable_class);
        return $model->imageInstance($this->imageable_type);
    }
    
}
