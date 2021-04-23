<?php

namespace App\Components\Image;

use Storage;
use Illuminate\Http\UploadedFile;
use Image as InterventionImage;
use Intervention\Image\Constraint;

/**
 * Class Image
 * Image element to store
 *
 * @package App\Components\Image
 */
class Image
{
    /**
     * Sub folder to save image
     *
     * @var string
     */
    protected $folder;
    
    /**
     * Custom string to show in sizes list on the crop page
     *
     * @var string
     */
    protected $name;
    
    /**
     * Image width
     *
     * @var int
     */
    protected $width;
    
    /**
     * Image height
     *
     * @var int
     */
    protected $height;
    
    /**
     * Image watermark properties
     *
     * @var Watermark|null
     */
    protected $watermark;
    
    /**
     * Does image need crop?
     *
     * @var bool
     */
    protected $crop = false;
    
    /**
     * Set watermark
     *
     * @param  $watermark
     * @return $this
     */
    public function setWatermark($watermark)
    {
        if ($watermark === true) {
            $this->watermark = new Watermark();
        } elseif ($watermark instanceof Watermark) {
            $this->watermark = $watermark;
        }
        
        return $this;
    }
    
    /**
     * Set `name` property
     *
     * @param  string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Set `width` property
     *
     * @param  int $width
     * @return $this
     */
    public function setWidth(int $width)
    {
        $this->width = $width;
        
        return $this;
    }
    
    /**
     * Set `height` property
     *
     * @param  int $height
     * @return $this
     */
    public function setHeight(int $height)
    {
        $this->height = $height;
        
        return $this;
    }
    
    /**
     * Set `crop` property
     *
     * @param  bool $crop
     * @return $this
     */
    public function setCrop(bool $crop)
    {
        $this->crop = $crop;
        
        return $this;
    }
    
    /**
     * Set `folder` property
     *
     * @param  string $folder
     * @return $this
     */
    public function setFolder(string $folder)
    {
        $this->folder = $folder;
        
        return $this;
    }
    
    /**
     * Folder
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }
    
    /**
     * Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name ?? $this->getWidth() . 'x' . $this->getHeight();
    }
    
    /**
     * Image width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * Image height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * Does image need crop?
     *
     * @return bool
     */
    public function getCrop()
    {
        return $this->crop;
    }
    
    /**
     * Get watermark properties
     *
     * @return Watermark|null
     */
    public function getWatermark()
    {
        return $this->watermark;
    }
    
    /**
     * Set image presets
     *
     * @param  array $presets
     * @return $this
     */
    public function presets(array $presets)
    {
        $this->width = array_get($presets, 'width');
        $this->height = array_get($presets, 'height');
        $this->folder = $presets['folder'] ?? '';
        $this->crop = $presets['crop'] ?? $this->crop;
        
        return $this;
    }
    
    /**
     * Image exemplar
     *
     * @var UploadedFile $photo
     * @var string $filename
     */
    public function store(UploadedFile $photo, string $path)
    {
        if ($photo->getClientOriginalExtension() === 'svg') {
            $photo->store(dirname($path));
            return;
        }
        // Make Image instance
        $image = InterventionImage::make($photo);
        // Crop image
        if ($this->crop === true && $this->width && $this->height) {
            $image->fit($this->width, $this->height);
        } else {
            // Set width
            if ((int)$this->width > 0 && $image->width() > $this->width) {
                $image->widen($this->width, function (Constraint $constraint) {
                    $constraint->upsize();
                });
            }
            // Set height
            if ((int)$this->height > 0 && $image->height() > $this->height) {
                $image->heighten($this->height, function (Constraint $constraint) {
                    $constraint->upsize();
                });
            }
        }
        // Add watermark
        if ($this->watermark instanceof Watermark && $this->watermark->overlay()) {
            $watermark = InterventionImage::make($this->watermark->getPath());
            if ($this->watermark->fill()) {
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
                $watermark->widen(round($this->watermark->getWidthPercent() * $image->width() * 0.01));
                $watermark->opacity($this->watermark->getOpacity());
                $image->insert($watermark, $this->watermark->getPosition(), $this->watermark->getX(), $this->watermark->getY());
            }
        }
        // Save file
        Storage::disk()->put($path, $image->stream(null, 100)->__toString());
    }
    
    /**
     * Check if image exists
     *
     * @param  string $path
     * @return bool
     */
    static function exists(string $path)
    {
        return Storage::disk()->exists($path);
    }
    
    /**
     * Delete image by path
     *
     * @param string $path
     */
    static function delete(string $path)
    {
        if (Image::exists($path)) {
            Storage::disk()->delete($path);
        }
    }
    
    /**
     * Get all needed data
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'folder' => $this->getFolder(),
            'name' => $this->getName(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
        ];
    }
    
}
